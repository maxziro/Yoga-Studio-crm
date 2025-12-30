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
