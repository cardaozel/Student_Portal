# Student Portal — SQL Injection Test Project

A dual-version PHP web application for learning and testing SQL injection vulnerabilities.

## Project Structure

- unsecure/Students_Portal — Vulnerable (SQL injection)
- secure/Secure-portal — Protected (prepared statements)

## Setup

- PHP 7.4+ with MySQL
- Import schema: secure/Secure-portal/schema.sql
- Run: php -S localhost:8000 -t unsecure/Students_Portal

## License

Educational / MIT
