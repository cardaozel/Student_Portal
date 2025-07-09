<?php
session_start();

// Set a flash message that can be displayed on the next page load
$_SESSION['logout_message'] = "You have been logged out successfully.";

// Clear all session variables
$_SESSION = [];

// If the session uses cookies, then delete the session cookie as well
if (ini_get("session.use_cookies")) {

    $params = session_get_cookie_params();  // Get current cookie parameters

    setcookie(  // Set the session cookie to expire in the past (effectively deletes it)
        session_name(), // Name of the session cookie
        '',             // Set its value to empty
        time() - 42000, // Set expiration time in the past
        $params["path"],  // Maintain the same path, domain, etc.
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy session
session_destroy();

// Redirect to login.php
header('Location: login.php');
// Ensure no further code is executed after redirect
exit;
