# Student Portal — SQL Injection Test Project

A dual-version PHP web application for learning and testing SQL injection vulnerabilities. Compare the **unsecure** implementation (vulnerable) with the **secure** implementation (hardened).

> ⚠️ **Educational Purpose Only** — The unsecure version is intentionally vulnerable. Do **not** deploy it in production.

---

## Project Structure

```
Student_Portal/
├── unsecure/
│   ├── Students_Portal/           # Vulnerable PHP app (SQL injection)
│   └── test_automation_unsecure/  # Cucumber/Java tests
├── secure/
│   ├── Secure-portal/             # Hardened PHP app (prepared statements)
│   └── test_automation_secure/    # Cucumber/Java tests
└── .gitignore
```

---

## Differences

| Aspect | Unsecure | Secure |
|--------|----------|--------|
| **Login** | Raw string concatenation in SQL | Prepared statements / parameterized queries |
| **SQL Injection** | Vulnerable | Protected |
| **Use Case** | Testing, learning | Reference implementation |

---

## Setup

### Prerequisites

- PHP 7.4+ with PDO MySQL
- MySQL/MariaDB
- (Optional) Java + Maven for test automation

### Database

1. Create a database and import the schema:
   ```bash
   mysql -u root -p < secure/Secure-portal/schema.sql
   ```

2. Update `config/config.php` (secure) or `db.php` (unsecure) with your DB credentials.

### Run Locally

1. **Unsecure** (for testing injection):
   ```bash
   php -S localhost:8000 -t unsecure/Students_Portal
   ```

2. **Secure** (for comparison):
   ```bash
   php -S localhost:8001 -t secure/Secure-portal
   ```

---

## SQL Injection Example (Unsecure)

In the unsecure login, input is concatenated directly into the query:

```php
// VULNERABLE - do not use in production
$sql = "SELECT id FROM users WHERE email='".$_POST['email']."' AND password='".$_POST['password']."'";
```

**Attack example:** Email: `' OR '1'='1` — can bypass authentication.

---

## Test Automation

Both versions include Cucumber/Java Selenium tests:

```bash
cd secure/test_automation_secure   # or unsecure/test_automation_unsecure
mvn test
```

---

## Contributors

2 contributors — [GitHub](https://github.com/cardaozel/Student_Portal/graphs/contributors)

## License

Educational / MIT
