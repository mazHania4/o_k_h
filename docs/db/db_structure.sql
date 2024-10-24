DROP DATABASE IF EXISTS o_k_h;
CREATE DATABASE o_k_h;
USE o_k_h;

CREATE TABLE users (
    user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    type ENUM('admin', 'publisher', 'user') NOT NULL DEFAULT 'user',
    state ENUM('active', 'inactive') NOT NULL DEFAULT 'active'
);

CREATE TABLE publishers (
    user_id INT NOT NULL PRIMARY KEY,
    approved_posts INT DEFAULT 0,
    state ENUM('active', 'on_test', 'banned') DEFAULT 'on_test',
    CONSTRAINT fk_publisher_to_user FOREIGN KEY(user_id) REFERENCES users(user_id)  
);

CREATE TABLE posts (
    post_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    publisher_id INT NOT NULL,
    title VARCHAR(255),
    start_date DATE,
    start_time TIME,
    end_date DATE,
    end_time TIME,
    capacity INT,
    attendances INT DEFAULT 0,
    reports INT DEFAULT 0,
    location VARCHAR(350),
    description VARCHAR(750),
    url VARCHAR(255),
    state ENUM('active', 'pending', 'banned') DEFAULT 'active',
    CONSTRAINT fk_post_to_publisher FOREIGN KEY (publisher_id) REFERENCES publishers(user_id)  
);

CREATE TABLE categories (
    category_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description VARCHAR(350)
);

CREATE TABLE post_cat (
    category_id INT NOT NULL,
    post_id INT NOT NULL,
    PRIMARY KEY (category_id, post_id),
    CONSTRAINT fk_postcat_to_categories FOREIGN KEY (category_id) REFERENCES categories(category_id)  ,
    CONSTRAINT fk_postcat_to_posts FOREIGN KEY (post_id) REFERENCES posts(post_id)  
);

CREATE TABLE audience_types (
    audience_type_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description VARCHAR(350)
);

CREATE TABLE post_audience (
    audience_type_id INT NOT NULL,
    post_id INT NOT NULL,
    PRIMARY KEY (audience_type_id, post_id),
    CONSTRAINT fk_postaud_to_audience FOREIGN KEY (audience_type_id) REFERENCES audience_types(audience_type_id),
    CONSTRAINT fk_postaud_to_posts FOREIGN KEY (post_id) REFERENCES posts(post_id)  
);

CREATE TABLE attendances (
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    PRIMARY KEY (user_id, post_id),
    CONSTRAINT fk_attendance_to_users FOREIGN KEY (user_id) REFERENCES users(user_id),
    CONSTRAINT fk_attendance_to_posts FOREIGN KEY (post_id) REFERENCES posts(post_id)  
);

CREATE TABLE report_types (
    report_types_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description VARCHAR(350)
);

CREATE TABLE reports (
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    report_type INT NOT NULL,
    comment VARCHAR(255),
    PRIMARY KEY (user_id, post_id),
    CONSTRAINT fk_reports_to_users FOREIGN KEY (user_id) REFERENCES users(user_id)  ,
    CONSTRAINT fk_reports_to_posts FOREIGN KEY (post_id) REFERENCES posts(post_id)  ,
    CONSTRAINT fk_reports_to_repType FOREIGN KEY (report_type) REFERENCES report_types(report_types_id)  
);

CREATE TABLE notif_types (
    notif_types_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE,
    description VARCHAR(350)
);

CREATE TABLE notifications (
    notification_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    title VARCHAR(255),
    type_id INT NOT NULL,
    description VARCHAR(500),
    date DATETIME DEFAULT NOW(),
    state ENUM('active', 'dismissed') DEFAULT 'active',
    CONSTRAINT fk_notif_to_user FOREIGN KEY (user_id) REFERENCES users(user_id)  ,
    CONSTRAINT fk_notif_to_posts FOREIGN KEY (post_id) REFERENCES posts(post_id)  ,
    CONSTRAINT fk_notif_to_notifType FOREIGN KEY (type_id) REFERENCES notif_types(notif_types_id)  
);
