-- =============================================
-- MCA PORTAL MOCK DATA FOR TESTING & DEVELOPMENT
-- Grade Input & Real-Time Display Testing
-- =============================================

-- 1. SUBJECTS (Core subjects for testing)
INSERT INTO `subjects` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Mathematics', 'MATH-101', NOW(), NOW()),
(2, 'English', 'ENG-101', NOW(), NOW()),
(3, 'Science', 'SCI-101', NOW(), NOW()),
(4, 'Filipino', 'FIL-101', NOW(), NOW()),
(5, 'Social Studies', 'SS-101', NOW(), NOW()),
(6, 'Physical Education', 'PE-101', NOW(), NOW()),
(7, 'Computer Science', 'CS-101', NOW(), NOW()),
(8, 'Arts', 'ART-101', NOW(), NOW()),
(9, 'Music', 'MUS-101', NOW(), NOW()),
(10, 'Values Education', 'VE-101', NOW(), NOW());

-- 2. SECTIONS (Sample sections for grades 7-10)
INSERT INTO `section` (`id`, `section_name`, `grade_level_id`, `strand_id`, `created_at`, `updated_at`) VALUES
(1, 'Grade 7 - Diamond', 1, NULL, NOW(), NOW()),
(2, 'Grade 7 - Ruby', 1, NULL, NOW(), NOW()),
(3, 'Grade 8 - Emerald', 2, NULL, NOW(), NOW()),
(4, 'Grade 8 - Sapphire', 2, NULL, NOW(), NOW()),
(5, 'Grade 9 - Gold', 3, NULL, NOW(), NOW()),
(6, 'Grade 9 - Silver', 3, NULL, NOW(), NOW()),
(7, 'Grade 10 - Pearl', 4, NULL, NOW(), NOW()),
(8, 'Grade 10 - Jade', 4, NULL, NOW(), NOW());

-- 3. CLASSES (Courses linking subjects, sections, and grade levels)
INSERT INTO `classes` (`id`, `name`, `code`, `subject_id`, `grade_level_id`, `strand_id`, `section_id`, `semester`, `room`, `created_at`, `updated_at`) VALUES
(1, 'Mathematics 7 - Diamond', 'MATH7-DIA', 1, 1, NULL, 1, NULL, 'Room 101', NOW(), NOW()),
(2, 'English 7 - Diamond', 'ENG7-DIA', 2, 1, NULL, 1, NULL, 'Room 102', NOW(), NOW()),
(3, 'Science 7 - Diamond', 'SCI7-DIA', 3, 1, NULL, 1, NULL, 'Room 103', NOW(), NOW()),
(4, 'Mathematics 8 - Emerald', 'MATH8-EME', 1, 2, NULL, 3, NULL, 'Room 201', NOW(), NOW()),
(5, 'English 8 - Emerald', 'ENG8-EME', 2, 2, NULL, 3, NULL, 'Room 202', NOW(), NOW()),
(6, 'Science 8 - Emerald', 'SCI8-EME', 3, 2, NULL, 3, NULL, 'Room 203', NOW(), NOW()),
(7, 'Mathematics 9 - Gold', 'MATH9-GOL', 1, 3, NULL, 5, NULL, 'Room 301', NOW(), NOW()),
(8, 'English 9 - Gold', 'ENG9-GOL', 2, 3, NULL, 5, NULL, 'Room 302', NOW(), NOW()),
(9, 'Mathematics 10 - Pearl', 'MATH10-PEA', 1, 4, NULL, 7, NULL, 'Room 401', NOW(), NOW()),
(10, 'English 10 - Pearl', 'ENG10-PEA', 2, 4, NULL, 7, NULL, 'Room 402', NOW(), NOW());

-- 4. STUDENTS (Mock students for grade input testing)
-- Note: Assumes users table already has entries. Adjust user_id accordingly
INSERT INTO `students` (`student_id`, `school_student_id`, `user_id`, `first_name`, `middle_name`, `last_name`, `suffix`, `gender`, `date_of_birth`, `contact_number`, `email`, `address`, `grade_level_id`, `strand_id`, `section_id`, `status_id`, `date_enrolled`, `semester`, `grade_id`, `created_at`, `updated_at`) VALUES
-- Grade 7 - Diamond Students
(1, 'STU-2025-001', 100, 'Juan', 'Santos', 'Dela Cruz', NULL, 'male', '2012-03-15', '09171234567', 'juan.delacruz@student.mca.edu', '123 Main St, Manila', 1, NULL, 1, 1, '2025-06-01', NULL, 1, NOW(), NOW()),
(2, 'STU-2025-002', 101, 'Maria', 'Garcia', 'Reyes', NULL, 'female', '2012-05-20', '09181234567', 'maria.reyes@student.mca.edu', '456 Secondary St, Manila', 1, NULL, 1, 1, '2025-06-01', NULL, 1, NOW(), NOW()),
(3, 'STU-2025-003', 102, 'Pedro', 'Cruz', 'Santos', 'Jr.', 'male', '2012-07-10', '09191234567', 'pedro.santos@student.mca.edu', '789 Third St, Manila', 1, NULL, 1, 1, '2025-06-01', NULL, 1, NOW(), NOW()),
(4, 'STU-2025-004', 103, 'Ana', 'Lim', 'Fernandez', NULL, 'female', '2012-02-28', '09201234567', 'ana.fernandez@student.mca.edu', '321 Fourth St, Manila', 1, NULL, 1, 1, '2025-06-01', NULL, 1, NOW(), NOW()),
(5, 'STU-2025-005', 104, 'Miguel', 'Torres', 'Aquino', NULL, 'male', '2012-08-05', '09211234567', 'miguel.aquino@student.mca.edu', '654 Fifth St, Manila', 1, NULL, 1, 1, '2025-06-01', NULL, 1, NOW(), NOW()),

-- Grade 8 - Emerald Students
(6, 'STU-2025-006', 105, 'Sofia', 'Ramos', 'Cruz', NULL, 'female', '2011-04-12', '09221234567', 'sofia.cruz@student.mca.edu', '987 Sixth St, Manila', 2, NULL, 3, 1, '2024-06-01', NULL, 2, NOW(), NOW()),
(7, 'STU-2025-007', 106, 'Carlos', 'Mendoza', 'Garcia', NULL, 'male', '2011-06-18', '09231234567', 'carlos.garcia@student.mca.edu', '147 Seventh St, Manila', 2, NULL, 3, 1, '2024-06-01', NULL, 2, NOW(), NOW()),
(8, 'STU-2025-008', 107, 'Isabella', 'Flores', 'Lopez', NULL, 'female', '2011-09-22', '09241234567', 'isabella.lopez@student.mca.edu', '258 Eighth St, Manila', 2, NULL, 3, 1, '2024-06-01', NULL, 2, NOW(), NOW()),

-- Grade 9 - Gold Students
(9, 'STU-2025-009', 108, 'Gabriel', 'Castillo', 'Rivera', NULL, 'male', '2010-01-30', '09251234567', 'gabriel.rivera@student.mca.edu', '369 Ninth St, Manila', 3, NULL, 5, 1, '2023-06-01', NULL, 3, NOW(), NOW()),
(10, 'STU-2025-010', 109, 'Samantha', 'Diaz', 'Morales', NULL, 'female', '2010-11-15', '09261234567', 'samantha.morales@student.mca.edu', '741 Tenth St, Manila', 3, NULL, 5, 1, '2023-06-01', NULL, 3, NOW(), NOW()),

-- Grade 10 - Pearl Students
(11, 'STU-2025-011', 110, 'Diego', 'Hernandez', 'Jimenez', NULL, 'male', '2009-03-08', '09271234567', 'diego.jimenez@student.mca.edu', '852 Eleventh St, Manila', 4, NULL, 7, 1, '2022-06-01', NULL, 4, NOW(), NOW()),
(12, 'STU-2025-012', 111, 'Valentina', 'Gomez', 'Velasco', NULL, 'female', '2009-12-25', '09281234567', 'valentina.velasco@student.mca.edu', '963 Twelfth St, Manila', 4, NULL, 7, 1, '2022-06-01', NULL, 4, NOW(), NOW());

-- 5. INSTRUCTOR_CLASSES (Assign instructors to classes)
-- Note: Assumes instructor with instructor_id=1 exists. Adjust as needed
INSERT INTO `instructor_classes` (`id`, `instructor_id`, `class_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NOW(), NOW()),  -- Math 7 Diamond
(2, 1, 2, NOW(), NOW()),  -- English 7 Diamond
(3, 1, 3, NOW(), NOW()),  -- Science 7 Diamond
(4, 1, 4, NOW(), NOW()),  -- Math 8 Emerald
(5, 1, 5, NOW(), NOW()),  -- English 8 Emerald
(6, 1, 6, NOW(), NOW()),  -- Science 8 Emerald
(7, 1, 7, NOW(), NOW()),  -- Math 9 Gold
(8, 1, 8, NOW(), NOW()),  -- English 9 Gold
(9, 1, 9, NOW(), NOW()),  -- Math 10 Pearl
(10, 1, 10, NOW(), NOW()); -- English 10 Pearl

-- 6. SCHEDULES (Class schedules for testing)
INSERT INTO `schedules` (`schedule_id`, `instructor_class_id`, `day_of_week`, `start_time`, `end_time`, `room`, `created_at`, `updated_at`) VALUES
-- Grade 7 Diamond Schedules
(1, 1, 'Monday', '08:00:00', '09:00:00', 'Room 101', NOW(), NOW()),
(2, 2, 'Monday', '09:00:00', '10:00:00', 'Room 102', NOW(), NOW()),
(3, 3, 'Tuesday', '08:00:00', '09:00:00', 'Room 103', NOW(), NOW()),

-- Grade 8 Emerald Schedules
(4, 4, 'Monday', '10:00:00', '11:00:00', 'Room 201', NOW(), NOW()),
(5, 5, 'Tuesday', '09:00:00', '10:00:00', 'Room 202', NOW(), NOW()),
(6, 6, 'Tuesday', '10:00:00', '11:00:00', 'Room 203', NOW(), NOW()),

-- Grade 9 Gold Schedules
(7, 7, 'Wednesday', '08:00:00', '09:00:00', 'Room 301', NOW(), NOW()),
(8, 8, 'Wednesday', '09:00:00', '10:00:00', 'Room 302', NOW(), NOW()),

-- Grade 10 Pearl Schedules
(9, 9, 'Thursday', '08:00:00', '09:00:00', 'Room 401', NOW(), NOW()),
(10, 10, 'Thursday', '09:00:00', '10:00:00', 'Room 402', NOW(), NOW());

-- 7. GRADES (Sample grades for testing - with validation 70-100 range)
INSERT INTO `grades` (`id`, `student_id`, `class_id`, `subject_id`, `first_quarter`, `second_quarter`, `third_quarter`, `fourth_quarter`, `final_grade`, `created_at`, `updated_at`) VALUES
-- Grade 7 Diamond - Student 1 (Juan Dela Cruz)
(1, 1, 1, 1, 85.50, 88.00, 90.25, 87.75, 87.88, NOW(), NOW()),  -- Mathematics
(2, 1, 2, 2, 92.00, 90.50, 91.75, 93.00, 91.81, NOW(), NOW()),  -- English
(3, 1, 3, 3, 88.25, 86.50, 89.00, 88.75, 88.13, NOW(), NOW()),  -- Science

-- Grade 7 Diamond - Student 2 (Maria Reyes)
(4, 2, 1, 1, 90.00, 92.50, 91.25, 93.00, 91.69, NOW(), NOW()),  -- Mathematics
(5, 2, 2, 2, 95.00, 94.50, 96.00, 95.25, 95.19, NOW(), NOW()),  -- English
(6, 2, 3, 3, 91.50, 90.75, 92.00, 91.25, 91.38, NOW(), NOW()),  -- Science

-- Grade 7 Diamond - Student 3 (Pedro Santos)
(7, 3, 1, 1, 78.00, 80.50, 82.25, 81.00, 80.44, NOW(), NOW()),  -- Mathematics
(8, 3, 2, 2, 85.00, 83.50, 86.00, 84.75, 84.81, NOW(), NOW()),  -- English
(9, 3, 3, 3, 80.25, 82.00, 81.50, 83.00, 81.69, NOW(), NOW()),  -- Science

-- Grade 7 Diamond - Student 4 (Ana Fernandez)
(10, 4, 1, 1, 93.50, 95.00, 94.25, 96.00, 94.69, NOW(), NOW()), -- Mathematics
(11, 4, 2, 2, 88.00, 89.50, 90.00, 88.75, 89.06, NOW(), NOW()), -- English
(12, 4, 3, 3, 91.00, 92.50, 90.75, 93.00, 91.81, NOW(), NOW()), -- Science

-- Grade 7 Diamond - Student 5 (Miguel Aquino)
(13, 5, 1, 1, 82.50, 84.00, 83.75, 85.25, 83.88, NOW(), NOW()), -- Mathematics
(14, 5, 2, 2, 87.00, 88.50, 86.75, 89.00, 87.81, NOW(), NOW()), -- English
(15, 5, 3, 3, 85.50, 86.00, 87.25, 86.50, 86.31, NOW(), NOW()), -- Science

-- Grade 8 Emerald - Student 6 (Sofia Cruz)
(16, 6, 4, 1, 89.00, 90.50, 91.00, 90.25, 90.19, NOW(), NOW()), -- Mathematics
(17, 6, 5, 2, 92.50, 93.00, 94.25, 93.50, 93.31, NOW(), NOW()), -- English
(18, 6, 6, 3, 88.75, 89.50, 90.00, 89.25, 89.38, NOW(), NOW()), -- Science

-- Grade 8 Emerald - Student 7 (Carlos Garcia)
(19, 7, 4, 1, 85.50, 87.00, 86.25, 88.00, 86.69, NOW(), NOW()), -- Mathematics
(20, 7, 5, 2, 90.00, 91.50, 89.75, 92.00, 90.81, NOW(), NOW()), -- English
(21, 7, 6, 3, 87.50, 88.00, 89.25, 88.75, 88.38, NOW(), NOW()), -- Science

-- Grade 8 Emerald - Student 8 (Isabella Lopez)
(22, 8, 4, 1, 91.00, 92.50, 93.25, 92.00, 92.19, NOW(), NOW()), -- Mathematics
(23, 8, 5, 2, 94.50, 95.00, 96.25, 95.50, 95.31, NOW(), NOW()), -- English
(24, 8, 6, 3, 90.75, 91.50, 92.00, 91.25, 91.38, NOW(), NOW()), -- Science

-- Grade 9 Gold - Student 9 (Gabriel Rivera)
(25, 9, 7, 1, 87.50, 89.00, 88.25, 90.00, 88.69, NOW(), NOW()), -- Mathematics
(26, 9, 8, 2, 91.00, 92.50, 90.75, 93.00, 91.81, NOW(), NOW()), -- English

-- Grade 9 Gold - Student 10 (Samantha Morales)
(27, 10, 7, 1, 93.50, 95.00, 94.25, 96.00, 94.69, NOW(), NOW()), -- Mathematics
(28, 10, 8, 2, 96.00, 97.50, 96.75, 98.00, 97.06, NOW(), NOW()), -- English

-- Grade 10 Pearl - Student 11 (Diego Jimenez)
(29, 11, 9, 1, 88.00, 89.50, 90.00, 89.25, 89.19, NOW(), NOW()), -- Mathematics
(30, 11, 10, 2, 92.50, 93.00, 94.25, 93.50, 93.31, NOW(), NOW()), -- English

-- Grade 10 Pearl - Student 12 (Valentina Velasco)
(31, 12, 9, 1, 95.00, 96.50, 97.25, 96.00, 96.19, NOW(), NOW()), -- Mathematics
(32, 12, 10, 2, 98.00, 99.00, 98.50, 99.50, 98.75, NOW(), NOW()); -- English

-- 8. ENROLLMENTS (Link students to classes they're enrolled in)
INSERT INTO `enrollments` (`student_id`, `class_id`, `enrolled_at`, `created_at`, `updated_at`) VALUES
-- Grade 7 Diamond Students enrolled in their classes
(1, 1, NOW(), NOW(), NOW()),  -- Juan in Math 7
(1, 2, NOW(), NOW(), NOW()),  -- Juan in English 7
(1, 3, NOW(), NOW(), NOW()),  -- Juan in Science 7
(2, 1, NOW(), NOW(), NOW()),  -- Maria in Math 7
(2, 2, NOW(), NOW(), NOW()),  -- Maria in English 7
(2, 3, NOW(), NOW(), NOW()),  -- Maria in Science 7
(3, 1, NOW(), NOW(), NOW()),  -- Pedro in Math 7
(3, 2, NOW(), NOW(), NOW()),  -- Pedro in English 7
(3, 3, NOW(), NOW(), NOW()),  -- Pedro in Science 7
(4, 1, NOW(), NOW(), NOW()),  -- Ana in Math 7
(4, 2, NOW(), NOW(), NOW()),  -- Ana in English 7
(4, 3, NOW(), NOW(), NOW()),  -- Ana in Science 7
(5, 1, NOW(), NOW(), NOW()),  -- Miguel in Math 7
(5, 2, NOW(), NOW(), NOW()),  -- Miguel in English 7
(5, 3, NOW(), NOW(), NOW()),  -- Miguel in Science 7

-- Grade 8 Emerald Students
(6, 4, NOW(), NOW(), NOW()),  -- Sofia in Math 8
(6, 5, NOW(), NOW(), NOW()),  -- Sofia in English 8
(6, 6, NOW(), NOW(), NOW()),  -- Sofia in Science 8
(7, 4, NOW(), NOW(), NOW()),  -- Carlos in Math 8
(7, 5, NOW(), NOW(), NOW()),  -- Carlos in English 8
(7, 6, NOW(), NOW(), NOW()),  -- Carlos in Science 8
(8, 4, NOW(), NOW(), NOW()),  -- Isabella in Math 8
(8, 5, NOW(), NOW(), NOW()),  -- Isabella in English 8
(8, 6, NOW(), NOW(), NOW()),  -- Isabella in Science 8

-- Grade 9 Gold Students
(9, 7, NOW(), NOW(), NOW()),  -- Gabriel in Math 9
(9, 8, NOW(), NOW(), NOW()),  -- Gabriel in English 9
(10, 7, NOW(), NOW(), NOW()), -- Samantha in Math 9
(10, 8, NOW(), NOW(), NOW()), -- Samantha in English 9

-- Grade 10 Pearl Students
(11, 9, NOW(), NOW(), NOW()), -- Diego in Math 10
(11, 10, NOW(), NOW(), NOW()), -- Diego in English 10
(12, 9, NOW(), NOW(), NOW()), -- Valentina in Math 10
(12, 10, NOW(), NOW(), NOW()); -- Valentina in English 10

-- =============================================
-- NOTES FOR TESTING:
-- =============================================
-- 1. All grades are within the 70-100 range as required
-- 2. Final grades are calculated as average of 4 quarters
-- 3. Students are properly linked to sections, classes, and have grades
-- 4. Schedules are set up for instructor-class relationships
-- 5. To test grade input:
--    - Login as instructor (instructor_id=1)
--    - Navigate to grade input page
--    - Select a class
--    - Input/modify grades for students
--    - Test confirmation popup before saving
--    - Verify real-time update in student view
-- 6. Adjust user_id values (100-111) based on your actual users table
-- 7. Adjust instructor_id (1) based on your actual instructors table
-- 8. All timestamps use NOW() for current date/time
-- =============================================

