-- Create a database
CREATE DATABASE IF NOT EXISTS short_url;

-- Use the created database
USE short_url;

-- Create a sample table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
);