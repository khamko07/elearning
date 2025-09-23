# E-Learning System Using PHP/MySQLi

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

## 📖 Overview

E-Learning System is a comprehensive web-based platform designed to facilitate online education by making it easier for teachers to create, manage, and deliver educational content. The system provides a seamless experience for both educators and students, featuring lesson management, quiz creation, and student assessment tools.

### 🎯 Purpose

This system aims to:
- Simplify the process of creating and managing online lessons
- Enable teachers to upload multimedia content (videos, PDFs)
- Provide interactive quizzes and assessments
- Track student progress and performance
- Create a centralized platform for educational content delivery

## ✨ Features

### 👨‍💼 Admin/Teacher Features

#### 📚 Lesson Management
- **List of Lessons**: View all available lessons in an organized manner
- **Upload Lesson**: Add new educational content (videos, PDF files)
- **Edit Lesson**: Modify existing lesson content and details
- **Change the File**: Replace lesson files with updated versions
- **View Lesson**: Preview lessons before publishing
- **Delete Lesson**: Remove outdated or unnecessary content

#### 📝 Exercise & Quiz Management
- **List of Questions**: View all quiz questions and exercises
- **Add Question**: Create new quiz questions with multiple choice options
- **Edit Question**: Modify existing questions and answers
- **Delete Question**: Remove outdated or incorrect questions

#### 👥 Student Management
- **List of Students**: View all registered students
- **Student Progress Tracking**: Monitor individual student performance

#### 🔧 User Management
- **List of Users**: View all system users (teachers, admins)
- **Add User**: Create new user accounts
- **Edit User**: Modify user information and permissions
- **Delete User**: Remove inactive or unauthorized users

### 👨‍🎓 Student Features

#### 🔐 Account Management
- **Create Account**: Register for new student accounts
- **Login/Logout**: Secure authentication system
- **Profile Management**: Update personal information

#### 📖 Learning Features
- **View Lessons**: Access uploaded educational content
- **Take Quizzes**: Participate in interactive assessments
- **Generate Score**: Automatic scoring and feedback system
- **Download Lessons**: Save content for offline study

## 🛠️ Technologies Used

- **Backend**: PHP 7.4+
- **Database**: MySQL/MySQLi
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap
- **Additional Libraries**:
  - jQuery
  - Bootstrap DatePicker
  - DataTables
  - Font Awesome
  - jQuery UI

## 📋 System Requirements

- **Web Server**: Apache 2.4+
- **PHP**: Version 7.4 or higher
- **Database**: MySQL 5.7+ or MariaDB 10.2+
- **Browser**: Modern web browser (Chrome, Firefox, Safari, Edge)

## 🚀 Installation Guide

### Step 1: Download Required Software
1. Download and install [XAMPP](https://www.apachefriends.org/download.html)
2. Download the E-Learning System source code

### Step 2: Setup Web Server
1. Start XAMPP Control Panel
2. Start **Apache** and **MySQL** services
3. Ensure both services are running (green status)

### Step 3: Deploy Source Code
1. Navigate to `C:\xampp\htdocs\`
2. Extract the downloaded zip file
3. Rename the folder to `elearning` (if not already named)

### Step 4: Database Setup
1. Open your web browser
2. Navigate to `http://localhost/phpmyadmin/`
3. Click **"New"** to create a new database
4. Name the database: `dbcaiwl`
5. Click **"Create"**

### Step 5: Import Database
1. Select the `dbcaiwl` database
2. Click **"Import"** tab
3. Click **"Choose File"**
4. Select `dbcaiwl.sql` from the project root folder
5. Click **"Go"** to import the database structure and data

### Step 6: Configuration
1. Navigate to `include/config.php`
2. Verify database connection settings:
   ```php
   $host = 'localhost';
   $username = 'root';
   $password = '';
   $database = 'dbcaiwl';
   ```

### Step 7: Access the System
1. Open your web browser
2. Navigate to `http://localhost/elearning/`
3. The system should now be accessible

## 🔑 Default Login Credentials

### Admin Access
- **URL**: `http://localhost/elearning/admin/`
- **Username**: janobe
- **Password**: admin

### Student Access
- Students need to register through the registration page
- **Registration URL**: `http://localhost/elearning/register.php`

## 📁 Project Structure

```
elearning/
├── admin/                  # Admin panel files
│   ├── modules/           # Admin modules
│   ├── adminMenu/         # Admin UI components
│   └── navigation/        # Admin navigation
├── assets/                # CSS, JS, and other assets
├── css/                   # Stylesheets
├── fonts/                 # Font files
├── images/               # System images
├── img/                  # Additional images
├── include/              # PHP includes and configurations
├── js/                   # JavaScript files
├── jquery/               # jQuery library files
├── navigation/           # Navigation components
├── dbcaiwl.sql          # Database structure and data
└── *.php                # Main application files
```

## 🔧 Configuration

### Database Configuration
Edit `include/config.php` to match your database settings:

```php
<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'dbcaiwl');
?>
```

### File Upload Settings
Ensure PHP settings allow file uploads:
- `upload_max_filesize = 50M`
- `post_max_size = 50M`
- `max_execution_time = 300`

## 🎯 Usage Instructions

### For Teachers/Admins:
1. Login to the admin panel
2. Navigate to "Lessons" to upload educational content
3. Use "Exercises" to create quizzes and assessments
4. Monitor student progress through the dashboard

### For Students:
1. Register for a new account
2. Login with your credentials
3. Browse available lessons
4. Take quizzes to test your knowledge
5. Download materials for offline study

## 🐛 Troubleshooting

### Common Issues:

**Database Connection Error**
- Verify MySQL service is running in XAMPP
- Check database credentials in `config.php`
- Ensure database `dbcaiwl` exists

**File Upload Issues**
- Check PHP file upload settings
- Verify folder permissions for upload directories
- Ensure adequate disk space

**Login Problems**
- Clear browser cache and cookies
- Verify user credentials in database
- Check session configuration

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/new-feature`)
3. Commit your changes (`git commit -am 'Add new feature'`)
4. Push to the branch (`git push origin feature/new-feature`)
5. Create a Pull Request

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

## 📞 Support

For support and questions:
- Create an issue in the repository
- Check the documentation
- Review troubleshooting section

## 🔄 Version History

- **v1.0.0** - Initial release with core functionality
- Features: Lesson management, quiz system, user management

---

**Note**: This system is designed for educational purposes and may require additional security measures for production use.