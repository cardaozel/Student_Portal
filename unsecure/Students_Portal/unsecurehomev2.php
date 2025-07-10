<?php
// Start session and ensure user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Include database connection
require 'db.php';

// Get logged-in user ID from session
$uid = $_SESSION['user_id'];

/* ===========================================
   Handle First Name Update (Unsafe)
   =========================================== */
// If form was submitted with a new first name
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['first_name'])) {
    $fname = $_POST['first_name'];

    try {
        // WARNING: Vulnerable to SQL Injection (unsafe dynamic query)
        $pdo->query("UPDATE student_profiles SET first_name = '$fname' WHERE user_id = $uid");
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>❌ Error en UPDATE: " . htmlspecialchars($e->getMessage()) . "</div>";
    }

    // Reload the page after saving
    header("Location: unsecurehomev2.php");
    exit;
}

/* ===========================================
   Log User-Agent Header (Unsafe)
   =========================================== */
// This logs the browser's User-Agent string
// WARNING: This can be exploited if attacker injects SQL via header manipulation
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
try {
    $pdo->query("INSERT INTO user_logs (agent_string) VALUES ('$userAgent')");
} catch (Exception $e) {
    // Error intentionally suppressed (also unsafe)
}

/* ===========================================
   Check Table Status (for attack detection)
   =========================================== */
$logtable_ok = $profiles_ok = $catalog_ok = true;

try { $pdo->query("SELECT COUNT(*) FROM user_logs"); } catch (PDOException $e) { $logtable_ok = false; }
try { $pdo->query("SELECT COUNT(*) FROM student_profiles"); } catch (PDOException $e) { $profiles_ok = false; }
try { $pdo->query("SELECT COUNT(*) FROM course_catalog"); } catch (PDOException $e) { $catalog_ok = false; }

// Check for existence of a known malicious user
$hacked = $pdo->query("SELECT COUNT(*) FROM portal_users WHERE email='hacked@ue-germany.de'")->fetchColumn();

/* ===========================================
   Load Student Profile Info
   =========================================== */
$profileSql = "SELECT sp.*, ap.name AS program_name, ap.total_semesters
               FROM student_profiles sp
               LEFT JOIN academic_programs ap ON ap.id = sp.program_id
               WHERE sp.user_id = $uid";
$student = $pdo->query($profileSql)->fetch(PDO::FETCH_ASSOC);

/* ===========================================
   Simulate Second-Order SQL Injection
   =========================================== */
// Tries to execute a query using a previously saved first name
// If malicious SQL was stored, it could execute here
try {
    $injectedSql = "SELECT * FROM student_profiles WHERE first_name = '" . $student['first_name'] . "'";
    $pdo->query($injectedSql);
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>⚠️ Second-order SQLi triggered: " . htmlspecialchars($e->getMessage()) . "</div>";
}

/* ===========================================
   Load Enrolled Courses
   =========================================== */
$cSql = "SELECT cc.course_code, cc.course_name, co.room_number, co.duration_hours,
                pp.first_name AS prof_fn, pp.family_name AS prof_ln
         FROM student_enrolments se
         JOIN class_offerings co ON co.id = se.class_id
         JOIN course_catalog cc ON cc.id = co.course_id
         JOIN portal_users pu ON pu.id = co.professor_user_id
         JOIN professor_profiles pp ON pp.user_id = pu.id
         WHERE se.student_user_id = $uid";
$courses = $pdo->query($cSql)->fetchAll(PDO::FETCH_ASSOC);

/* ===========================================
   Load Upcoming Exams
   =========================================== */
$eSql = "SELECT e.exam_date,
                TIME_FORMAT(e.exam_time,'%H:%i') AS time,
                e.exam_type,
                cc.course_name
         FROM student_exams e
         JOIN class_offerings co ON co.id = e.class_id
         JOIN course_catalog cc ON cc.id = co.course_id
         WHERE e.student_user_id = $uid";
$exams = $pdo->query($eSql)->fetchAll(PDO::FETCH_ASSOC);
?>
