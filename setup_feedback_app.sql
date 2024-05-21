CREATE DATABASE feedback_app;

USE feedback_app;

CREATE TABLE feedback (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          name VARCHAR(255) NOT NULL,
                          email VARCHAR(255) NOT NULL,
                          message TEXT NOT NULL,
                          image VARCHAR(255),
                          date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                          status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
                          modified_by_admin BOOLEAN DEFAULT FALSE
);

CREATE TABLE admin (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       username VARCHAR(255) NOT NULL,
                       password VARCHAR(255) NOT NULL
);

INSERT INTO admin (username, password) VALUES ('admin', MD5('123'));
