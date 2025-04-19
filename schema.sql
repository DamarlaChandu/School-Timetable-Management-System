CREATE DATABASE school_timetable;
USE school_timetable;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    class INT
);

CREATE TABLE teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    subject VARCHAR(100)
);

CREATE TABLE timetable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class INT,
    subject_id INT,
    teacher_id INT,
    day_of_week VARCHAR(20),
    period INT
);