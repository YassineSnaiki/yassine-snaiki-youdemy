# Youdemy - Interactive Learning Platform

## 🎯 Project Overview

Youdemy is an innovative online learning platform designed to revolutionize education by providing an interactive and personalized learning experience for both students and teachers. The platform facilitates course management, student enrollment, and educational content delivery.

## ✨ Features

### 👥 User Roles

#### Visitors
- Browse course catalog with pagination
- Search courses by keywords
- Create account (Student/Teacher)

#### Students
- View and search course details
- Enroll in courses
- Access personal course dashboard

#### Teachers
- Create and manage courses
- Upload course content (videos/documents)
- View course statistics
- Tag and categorize courses

#### Administrators
- Validate teacher accounts
- Manage users and content
- View global statistics
- Bulk tag management

## 🛠 Technical Requirements

### Prerequisites
- PHP 8.0 or higher
- PostgreSQL 14.0 or higher
- Apache/Nginx web server
- Composer (for dependency management)

### Dependencies
- PHP PDO with PostgreSQL driver
- PHP Session handling
- HTML5
- JavaScript (Native)
- tailwindcss for responsive design

### Project Architecture
- MVC (Model-View-Controller) pattern
- Object-Oriented Programming principles:
  - Encapsulation
  - Inheritance
- Database design with proper relationships:
  - One-to-Many (Users to Courses)
  - Many-to-Many (Courses to Tags)
  - Polymorphic relationships for course content

## 🚀 Installation & Setup

1. **Clone the Repository**
```bash
git clone [repository-url]
cd youdemy
```

2. **Database Setup**
- Install PostgreSQL if not already installed
- Create a new PostgreSQL database
- Update database configuration in `config/database.php`
- Database tables will be automatically created with proper relationships:
  ```sql
  -- Core Tables
  users (id, username, email, password, role, status)
  courses (id, title, description, teacher_id, category_id, created_at)
  categories (id, name, description)
  tags (id, name)
  course_tags (course_id, tag_id)
  enrollments (id, student_id, course_id, enrollment_date)
  course_content (id, course_id, type, content, order)
  ```

3. **Environment Configuration**
- Update the following variables in config file:
  ```
  DB_CONNECTION=pgsql
  DB_HOST=localhost
  DB_PORT=5432
  DB_DATABASE=youdemydb
  DB_USERNAME=postgres
  DB_PASSWORD=0000
  ```

4. **Run the Application**
- Configure your web server to point to the `public` directory
- Access the application through your web browser

## 📚 Database Structure

The database is automatically created with the following structure:

- `users` - Store user information and roles
- `courses` - Course details and content
- `categories` - Course categories
- `tags` - Course tags
- `enrollments` - Student course enrollments
- `course_tags` - Many-to-many relationship between courses and tags
- `course_content` - Store course content with proper relationships

## Default Admin Account
When the database is first created, a default admin account is automatically generated with the following credentials:
- **Email**: admin@gmail.com
- **Password**: admin
- **Role**: Administrator (Full system access)


## 🔒 Security Features

- Cross-Site Scripting (XSS) protection
- CSRF token implementation
- Prepared SQL statements
- Input validation and sanitization
- Role-based access control
- Secure session management

## 💡 Additional Features

- Advanced search with filters
- Engagement analytics



