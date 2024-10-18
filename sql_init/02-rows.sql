-- Populate tags table
INSERT INTO tags (name) VALUES
('work'), ('personal'), ('important'), ('idea'), ('meeting'), ('travel'), ('health'), ('finance');

-- Populate events table
INSERT INTO events (display_timestamp, title, icon, color, input_text, input_audio, input_image) VALUES
('2024-10-18 09:00:00', 'Team Meeting', 'users', 'blue', 'Discuss project timeline', NULL, NULL),
('2024-10-18 12:30:00', 'Lunch with Sarah', 'utensils', 'green', 'Catch up over sushi', NULL, NULL),
('2024-10-18 15:00:00', 'Dentist Appointment', 'tooth', 'red', 'Regular checkup', NULL, NULL),
('2024-10-19 10:00:00', 'Brainstorming Session', 'lightbulb', 'yellow', 'New product ideas', 'brainstorm_audio.mp3', NULL),
('2024-10-19 14:00:00', 'Client Call', 'phone', 'purple', 'Discuss contract renewal', NULL, NULL),
('2024-10-20 08:00:00', 'Morning Jog', 'running', 'green', '5km run in the park', NULL, 'jog_route.jpg'),
('2024-10-20 13:00:00', 'Budget Review', 'chart-line', 'blue', 'Q4 financial planning', NULL, 'budget_chart.png'),
('2024-10-21 11:00:00', 'Travel Booking', 'plane', 'orange', 'Book flights for conference', NULL, NULL),
('2024-10-21 16:00:00', 'Project Deadline', 'clock', 'red', 'Submit final report', NULL, NULL),
('2024-10-22 09:30:00', 'Team Building', 'users', 'green', 'Escape room challenge', NULL, 'team_photo.jpg');

-- Populate events_tags table
INSERT INTO events_tags (event_id, tag_id) VALUES
(1, 1), (1, 5), -- Team Meeting: work, meeting
(2, 2), -- Lunch with Sarah: personal
(3, 2), (3, 7), -- Dentist Appointment: personal, health
(4, 1), (4, 4), -- Brainstorming Session: work, idea
(5, 1), (5, 3), -- Client Call: work, important
(6, 2), (6, 7), -- Morning Jog: personal, health
(7, 1), (7, 8), -- Budget Review: work, finance
(8, 1), (8, 6), -- Travel Booking: work, travel
(9, 1), (9, 3), -- Project Deadline: work, important
(10, 1), (10, 2); -- Team Building: work, personal