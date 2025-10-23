# Yii2 Book Catalog

Book catalog application built with Yii2 + MySQL.

## Task Requirements

Books can have multiple authors.

**Entities:**

1. Book - title, publication year, description, ISBN, cover photo
2. Author - full name

**Access Rights:**

1. Guest - view only + subscribe to new books by author
2. User - view, add, edit, delete

**Report:**

TOP 10 authors who published the most books in a given year (accessible to all users).

**Additional Requirements:**

- Web application (not API)
- Authentication required
- Cover photo - any format, file or URL storage
- Report as separate page, accessible to all
- Subscription to specific author (not per book)
- Guest - unauthenticated user (subscription via phone number)
- No admin functionality for managing subscriptions
- CRUD applies to books and authors
- Author is not a user (separate entity)
- No unsubscribe functionality required
- Migrations instead of database dump
- PHP 8+, MySQL/MariaDB
- Can use basic or advanced Yii2 template
