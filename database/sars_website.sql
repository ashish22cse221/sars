-- Create database
CREATE DATABASE IF NOT EXISTS sars_website;
USE sars_website;

-- Admin table
CREATE TABLE admin_users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin
INSERT INTO admin_users (username, password) VALUES ('sars@admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- About us table
CREATE TABLE about_us (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(255),
    description TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default about us
INSERT INTO about_us (title, subtitle, description) VALUES 
('About Us', 'Innovating the Future with Robotics', 'SARS Robotics is a visionary research and development team committed to revolutionizing the field of robotics through creative innovation, interdisciplinary collaboration, and hands-on education. Established in 2011, SARS has been at the forefront of technological advancement for over a decade.\n\nOur team brings together passionate minds from engineering, computer science, and design to develop intelligent robotic systems that tackle real-world problems. Through national competitions, technical workshops, and community outreach programs, we aim to inspire and empower the next generation of tech leaders while making robotics accessible and impactful for all.');

-- Achievements table
CREATE TABLE achievements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    tab_name VARCHAR(100),
    is_featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default achievements
INSERT INTO achievements (title, description, tab_name, is_featured) VALUES
('Successfully Competed at IIT Bhubaneswar', 'Our participation at IIT Bhubaneswar marked a major milestone in our journey. Presenting our advanced robotic systems at a nationally recognized platform allowed us to engage with industry experts, receive valuable feedback, and showcase our technical prowess.', 'IIT Bhubaneswar', TRUE),
('Successfully Competed at IIT Kharagpur', 'At the Techno-Management Fest of IIT Kharagpur—one of India\'s most prestigious technical events—our team stood out with creative, real-world robotic solutions.', 'IIT Kharagpur', TRUE),
('4 Successful Workshops in 2024', 'In 2024, we organized four hands-on robotics workshops that collectively attracted over 400 participants from different colleges and schools.', 'Workshops 2024', TRUE);

-- Projects table
CREATE TABLE projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image_path VARCHAR(255),
    is_featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default projects
INSERT INTO projects (title, description, image_path, is_featured) VALUES
('Line Follower', 'An intelligent robot programmed to follow a pre-defined path using sensor-based navigation and precision control.', 'images/LINE_FOLLOWER.jpg', TRUE),
('Competitive Bots', 'Engineered for excellence, our competitive robots are designed to dominate challenges in events like the ITT Robotics Competitions.', 'images/SUMO-BOT.png', TRUE),
('Agricultural Bot', 'Automated farming assistant that monitors crops and performs precision harvesting.', 'images/AGRI_BOT.jpeg', TRUE);

-- Events table
CREATE TABLE events (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    event_date DATE,
    status ENUM('upcoming', 'completed') DEFAULT 'upcoming',
    poster_path VARCHAR(255),
    registration_link VARCHAR(255),
    venue VARCHAR(255),
    expected_participants INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default events
INSERT INTO events (title, description, event_date, status, poster_path, venue, expected_participants) VALUES
('Robotics Bootcamp', 'An upcoming intensive training program to master autonomous robotics, machine learning, and real-world deployment.', '2025-03-15', 'upcoming', 'images/Event1.jpg', 'Smart Class 1 & 2', 200),
('IoT Devices & Simulation Workshop', 'Get hands-on experience with modern IoT sensors, platforms, and simulations in this interactive workshop.', '2024-12-15', 'completed', 'images/Event1.jpg', 'Smart Class 1', 150);

-- Team members table
CREATE TABLE team_members (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    role VARCHAR(255),
    image_path VARCHAR(255),
    bio TEXT,
    linkedin_url VARCHAR(255),
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default team members
INSERT INTO team_members (name, role, image_path, bio, display_order) VALUES
('Dr. Ashish Tiwary', 'Club Convener', 'images/DR.ASHISH TIWARY.jpg', 'BTECH, M.TECH, (PhD)\n\nSpecialization:\nMICRO ELECTRO MECHANICAL SYSTEMS', 1),
('VIVEK CHOUDHURY', 'CLUB LEAD', 'images/VIVEK.jpg', 'B. TECH CSE-AIML 4th YEAR 2022-26', 2),
('ASHISH CHOUDHURY', 'DESIGNER & SOCIAL', 'images/ASHISH.jpg', 'B. TECH CSE 4th YEAR 2022-26', 3),
('ASUTOSH PANDA', 'MANAGEMENT LEAD', 'images/ASUTOSH.jpg', 'B. TECH CSE 4th YEAR 2022-26', 4);

-- Terminal messages table
CREATE TABLE terminal_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    message TEXT NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default terminal messages
INSERT INTO terminal_messages (message, is_active) VALUES
('Dr. Ashish Tiwary (Club Convener)', TRUE),
('VIVEK CHOUDHURY (CLUB LEAD)', TRUE),
('ASUTOSH PANDA (MANAGEMENT LEAD)', TRUE),
('ASHISH CHOUDHURY (DESIGNER & SOCIAL LEAD)', TRUE);

-- Contact messages table
CREATE TABLE contact_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    email VARCHAR(255),
    subject VARCHAR(255),
    message TEXT,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
