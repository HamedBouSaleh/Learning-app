-- ============================================
-- Learning Platform Database Schema
-- ============================================

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('Student', 'Instructor', 'Admin') NOT NULL DEFAULT 'Student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Courses Table
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    short_description VARCHAR(500),
    long_description TEXT,
    category VARCHAR(100),
    difficulty ENUM('Beginner', 'Intermediate', 'Advanced') NOT NULL DEFAULT 'Beginner',
    thumbnail_url VARCHAR(255),
    estimated_duration INT COMMENT 'Duration in minutes',
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_published BOOLEAN DEFAULT FALSE,
    enrollment_count INT DEFAULT 0,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_category (category),
    INDEX idx_difficulty (difficulty),
    INDEX idx_is_published (is_published),
    INDEX idx_created_by (created_by)
);

-- Lessons Table
CREATE TABLE lessons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    video_url VARCHAR(255),
    lesson_type ENUM('Video', 'Article', 'Mixed') NOT NULL DEFAULT 'Video',
    order_position INT NOT NULL,
    estimated_duration INT COMMENT 'Duration in minutes',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    INDEX idx_course_id (course_id),
    INDEX idx_order_position (order_position),
    INDEX idx_lesson_type (lesson_type)
);

-- Course_Progress Table
CREATE TABLE course_progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    user_id INT NOT NULL,
    total_lessons INT DEFAULT 0,
    completed_lessons INT DEFAULT 0,
    total_quizzes INT DEFAULT 0,
    completed_quizzes INT DEFAULT 0,
    progress_percentage DECIMAL(5,2) DEFAULT 0.00,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_course (user_id, course_id),
    INDEX idx_course_id (course_id),
    INDEX idx_user_id (user_id),
    INDEX idx_progress_percentage (progress_percentage)
);

-- Enrollments Table
CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    last_accessed_at TIMESTAMP NULL,
    status ENUM('Active', 'Completed', 'Dropped') NOT NULL DEFAULT 'Active',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_course_enrollment (user_id, course_id),
    INDEX idx_user_id (user_id),
    INDEX idx_course_id (course_id),
    INDEX idx_status (status)
);

-- Certificates Table
CREATE TABLE certificates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    certificate_url VARCHAR(255),
    verification_code VARCHAR(255) UNIQUE NOT NULL,
    generated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    instructor_name VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_course_certificate (user_id, course_id),
    INDEX idx_user_id (user_id),
    INDEX idx_course_id (course_id),
    INDEX idx_verification_code (verification_code)
);

-- Quizzes Table
CREATE TABLE quizzes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    lesson_id INT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    passing_score INT NOT NULL,
    time_limit INT COMMENT 'Time limit in minutes',
    shuffle_questions BOOLEAN DEFAULT FALSE,
    show_correct_answers BOOLEAN DEFAULT TRUE,
    allow_retake BOOLEAN DEFAULT TRUE,
    max_attempts INT DEFAULT 3,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE SET NULL,
    INDEX idx_course_id (course_id),
    INDEX idx_lesson_id (lesson_id)
);

-- Questions Table
CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    question_text TEXT NOT NULL,
    question_type ENUM('MCQ', 'MSQ', 'TrueFalse', 'ShortAnswer') NOT NULL,
    order_position INT NOT NULL,
    points INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE,
    INDEX idx_quiz_id (quiz_id),
    INDEX idx_order_position (order_position)
);

-- Answers Table
CREATE TABLE answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT NOT NULL,
    answer_text TEXT NOT NULL,
    is_correct BOOLEAN DEFAULT FALSE,
    order_position INT NOT NULL,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,
    INDEX idx_question_id (question_id)
);

-- Quiz_Attempts Table
CREATE TABLE quiz_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    user_id INT NOT NULL,
    score INT DEFAULT 0,
    total_points INT NOT NULL,
    percentage DECIMAL(5,2) DEFAULT 0.00,
    time_spent_seconds INT DEFAULT 0,
    attempt_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    attempt_number INT NOT NULL,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_quiz_id (quiz_id),
    INDEX idx_user_id (user_id),
    INDEX idx_attempt_date (attempt_date)
);

-- Student_Answers Table
CREATE TABLE student_answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_attempt_id INT NOT NULL,
    question_id INT NOT NULL,
    answer_id INT NULL COMMENT 'Nullable for short answer questions',
    short_answer_text TEXT NULL,
    is_correct BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (quiz_attempt_id) REFERENCES quiz_attempts(id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,
    FOREIGN KEY (answer_id) REFERENCES answers(id) ON DELETE SET NULL,
    INDEX idx_quiz_attempt_id (quiz_attempt_id),
    INDEX idx_question_id (question_id)
);

-- Lesson_Completion Table
CREATE TABLE lesson_completion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lesson_id INT NOT NULL,
    user_id INT NOT NULL,
    completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    time_spent_seconds INT DEFAULT 0,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_lesson (user_id, lesson_id),
    INDEX idx_lesson_id (lesson_id),
    INDEX idx_user_id (user_id)
);

-- Attachments Table
CREATE TABLE attachments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lesson_id INT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_url VARCHAR(255) NOT NULL,
    file_type ENUM('PDF', 'Image', 'Document') NOT NULL,
    file_size_kb INT,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE,
    INDEX idx_lesson_id (lesson_id),
    INDEX idx_file_type (file_type)
);