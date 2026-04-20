-- ===========================================
-- DATABASE: student_system
-- DESCRIPTION: Stores all student registration data
-- ===========================================

-- Create database
CREATE DATABASE IF NOT EXISTS student_system;
USE student_system;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    department VARCHAR(100) NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    hobbies TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample data (optional - for testing)
INSERT INTO users (first_name, last_name, email, password, department, gender, hobbies) 
VALUES ('John', 'Doe', 'john@example.com', '$2y$10$YourHashedPasswordHere', 'Computer Science', 'male', 'Reading, Sports');