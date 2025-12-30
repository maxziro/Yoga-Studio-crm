CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'teacher', 'student') DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default Admin (Password: admin1234) - PLEASE CHANGE AFTER IMPORT
INSERT INTO users (name, email, password, role) VALUES
('admin', 'admin@parsifalyoga.it', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhQe', 'admin');

-- Courses Table
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    periodicity ENUM('settimanale', 'mensile', 'giornaliera') NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    day_of_week ENUM('lunedì', 'martedì', 'mercoledì', 'giovedì', 'venerdì', 'sabato', 'domenica') NULL,
    time TIME NOT NULL,
    duration INT NOT NULL COMMENT 'Durata in minuti',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Subscription Types Table
CREATE TABLE IF NOT EXISTS subscription_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type ENUM('single_weekly', 'full_access') NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Student Subscriptions Table
CREATE TABLE IF NOT EXISTS student_subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    subscription_type_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    status ENUM('active', 'expired', 'suspended') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (subscription_type_id) REFERENCES subscription_types(id) ON DELETE RESTRICT
);

-- Payments Table
CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_subscription_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_date DATE NOT NULL,
    payment_method ENUM('cash', 'bank_transfer', 'credit_card') NOT NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_subscription_id) REFERENCES student_subscriptions(id) ON DELETE CASCADE
);
