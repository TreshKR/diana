INSERT INTO projects (title) VALUES ('Twin peaks');

INSERT INTO tags (name) VALUES 
('interview'),
('evidence'),
('forensics'),
('surveillance'),
('lead'),
('theory'),
('timeline'),
('location'),
('suspect'),
('victim'),
('witness'),
('official'),
('personal'),
('weather'),
('dream');

-- Events spanning 3 years (2019-2022)
INSERT INTO events (display_timestamp, title, input_text, project_id) VALUES
('2019-02-15 09:30:00', 'Initial Case Report', 'Body discovered in woods near Twin Peaks. Female victim, approximately 17 years old. Signs of trauma.', 1),
('2019-02-15 14:45:00', 'Weather Report', 'Heavy rain last night may have compromised some evidence. Ground is heavily saturated.', 1),
('2019-02-16 10:00:00', 'Autopsy Findings', 'Victim identified as Laura Palmer. Cause of death: multiple injuries. Time of death estimated between 12-2 AM.', 1),
('2019-02-17 08:30:00', 'Evidence Collection', 'Retrieved victim''s diary from bedroom. Several pages appear to be missing.', 1),
('2019-02-18 11:20:00', 'Witness Interview', 'Donna Hayward interviewed regarding victim''s last known whereabouts.', 1),
('2019-02-19 15:45:00', 'Location Analysis', 'Crime scene perimeter established. Multiple footprints found leading to water.', 1),
('2019-02-20 09:15:00', 'Dream Log Entry', 'Giant appeared in dream, spoke of owls and darkness.', 1),
('2019-02-22 14:30:00', 'Surveillance Setup', 'Initiated surveillance at Roadhouse Bar based on tip.', 1),
('2019-02-25 16:00:00', 'Personal Note', 'Local diner''s cherry pie continues to impress. Must get recipe.', 1),
('2019-03-01 10:30:00', 'Evidence Analysis', 'Fiber analysis results received from lab. Unknown synthetic material.', 1),
('2019-03-05 13:45:00', 'Suspect Interview', 'Leo Johnson questioned about whereabouts on night of murder.', 1),
('2019-03-10 09:00:00', 'Weather Report', 'Dense fog affecting visibility in investigation areas.', 1),
('2019-03-15 11:20:00', 'Location Search', 'Team searched abandoned train car. Signs of recent activity.', 1),
('2019-03-20 14:15:00', 'Evidence Recovery', 'Half-heart necklace found near mill. Possible connection to victim.', 1),
('2019-03-25 16:30:00', 'Witness Statement', 'Gas station attendant reports suspicious vehicle night of murder.', 1),
('2019-04-01 09:45:00', 'Dream Log', 'Red room appeared again. Messages seem clearer but still cryptic.', 1),
('2019-04-05 13:20:00', 'Forensic Report', 'Toxicology results show presence of unknown substance.', 1),
('2019-04-10 15:00:00', 'Surveillance Notes', 'Observed meeting between suspects at Double R Diner.', 1),
('2019-04-15 10:30:00', 'Official Document', 'Search warrant executed for Palmer residence.', 1),
('2019-04-20 14:45:00', 'Theory Development', 'Multiple threads suggesting organized crime connection.', 1),
('2019-05-01 11:15:00', 'Lead Investigation', 'New information about victim''s secret life emerging.', 1),
('2019-05-10 16:00:00', 'Personal Reflection', 'Something about this case feels different. Darker.', 1),
('2019-05-20 09:30:00', 'Evidence Processing', 'Analysis of victim''s car complete. Traces of cocaine found.', 1),
('2019-06-01 13:45:00', 'Witness Interview', 'School teacher reports unusual behavior days before death.', 1),
('2019-06-15 15:20:00', 'Location Investigation', 'Hidden room discovered in local bar basement.', 1),
('2019-07-01 10:00:00', 'Dream Sequence', 'Black lodge symbols appearing repeatedly in dreams.', 1),
('2019-07-15 14:30:00', 'Suspect Surveillance', 'Jacques Renault observed making suspicious deliveries.', 1),
('2019-08-01 11:45:00', 'Evidence Collection', 'Retrieved surveillance tapes from bank cameras.', 1),
('2019-08-15 16:20:00', 'Weather Note', 'Unusual owl activity during full moon.', 1),
('2019-09-01 09:15:00', 'Forensic Analysis', 'DNA results from fingernail samples received.', 1),
('2019-09-15 13:40:00', 'Lead Follow-up', 'Connection to Ghostwood Development project discovered.', 1),
('2019-10-01 15:15:00', 'Official Report', 'Preliminary findings submitted to FBI headquarters.', 1),
('2019-10-15 10:45:00', 'Theory Update', 'Multiple victims possible over several years.', 1),
('2019-11-01 14:20:00', 'Personal Note', 'Douglas firs whisper secrets of their own.', 1),
('2019-11-15 16:00:00', 'Surveillance Report', 'Suspicious gathering at Great Northern Hotel.', 1),
('2020-01-01 11:30:00', 'Evidence Review', 'Re-examination of initial crime scene photos reveals new detail.', 1),
('2020-01-15 15:45:00', 'Witness Statement', 'Log Lady provides cryptic but relevant information.', 1),
('2020-02-01 09:20:00', 'Location Search', 'Pearl Lakes area searched based on tip.', 1),
('2020-02-15 13:50:00', 'Dream Log', 'MIKE appeared with warning about BOB.', 1),
('2020-03-01 16:15:00', 'Suspect Interview', 'Benjamin Horne questioned about business dealings.', 1),
('2020-03-15 10:40:00', 'Evidence Analysis', 'Strange symbols found carved in trees near crime scene.', 1),
('2020-04-01 14:25:00', 'Forensic Report', 'Soil analysis shows traces of scorched engine oil.', 1),
('2020-04-15 16:55:00', 'Lead Investigation', 'Connection to Owl Cave symbols established.', 1),
('2020-05-01 11:10:00', 'Weather Update', 'Electrical storms increasing in frequency.', 1),
('2020-05-15 15:35:00', 'Official Document', 'Request for additional forensic resources approved.', 1),
('2020-06-01 09:50:00', 'Theory Development', 'Pattern of occult symbolism emerging.', 1),
('2020-06-15 13:15:00', 'Personal Reflection', 'Case affecting sleep patterns. Dreams more vivid.', 1),
('2020-07-01 16:40:00', 'Surveillance Notes', 'Unusual activity at Glastonbury Grove.', 1),
('2020-07-15 10:05:00', 'Evidence Collection', 'Anonymous package received containing victim''s diary pages.', 1),
('2020-08-01 14:30:00', 'Witness Interview', 'Harold Smith provides crucial diary information.', 1),
('2020-08-15 16:00:00', 'Location Analysis', 'Underground bunker discovered near Packard Mill.', 1),
('2020-09-01 11:25:00', 'Dream Sequence', 'Dancing dwarf reveals coordinates in dream.', 1),
('2020-09-15 15:50:00', 'Suspect Surveillance', 'Observed ritual-like gathering in woods.', 1),
('2020-10-01 09:15:00', 'Evidence Processing', 'Analysis of ring with owl cave symbol complete.', 1),
('2020-10-15 13:40:00', 'Forensic Report', 'Strange residues found on victim''s clothing.', 1),
('2020-11-01 16:05:00', 'Lead Follow-up', 'Connection to military installation discovered.', 1),
('2020-11-15 10:30:00', 'Weather Note', 'Unexplained lights in sky above Twin Peaks.', 1),
('2020-12-01 14:55:00', 'Official Report', 'Updated case summary sent to Gordon Cole.', 1),
('2020-12-15 16:20:00', 'Theory Update', 'Multiple dimensions of crime becoming clear.', 1),
('2021-01-01 11:45:00', 'Personal Note', 'Strong coffee required for these revelations.', 1),
('2021-01-15 15:10:00', 'Evidence Review', 'New interpretation of original evidence emerging.', 1),
('2021-02-01 09:35:00', 'Surveillance Report', 'Monitored activity at One Eyed Jack''s.', 1),
('2021-02-15 13:00:00', 'Witness Statement', 'Margaret Lanterman shares log''s insights.', 1),
('2021-03-01 16:25:00', 'Location Search', 'Black lodge entrance identified.', 1),
('2021-03-15 10:50:00', 'Dream Log', 'Laura Palmer appeared with new message.', 1),
('2021-04-01 14:15:00', 'Suspect Interview', 'Leland Palmer provides disturbing testimony.', 1),
('2021-04-15 16:40:00', 'Evidence Analysis', 'Decoded diary reveals secret meetings.', 1),
('2021-05-01 11:05:00', 'Forensic Report', 'Matching fibers found at multiple locations.', 1),
('2021-05-15 15:30:00', 'Lead Investigation', 'Drug trafficking route mapped through Canada.', 1),
('2021-06-01 09:55:00', 'Weather Update', 'Frequency of owl sightings increasing.', 1),
('2021-06-15 13:20:00', 'Official Document', 'Arrest warrants prepared for multiple suspects.', 1),
('2021-07-01 16:45:00', 'Theory Development', 'Supernatural elements cannot be ignored.', 1),
('2021-07-15 10:10:00', 'Personal Reflection', 'Reality becoming increasingly fluid.', 1),
('2021-08-01 14:35:00', 'Surveillance Notes', 'Recorded bizarre ritual at Glastonbury Grove.', 1),
('2021-08-15 16:00:00', 'Evidence Collection', 'Retrieved ceremonial mask from cave.', 1),
('2021-09-01 11:25:00', 'Witness Interview', 'Annie Blackburn provides valuable insight.', 1),
('2021-09-15 15:50:00', 'Location Analysis', 'Mapped ley lines through Twin Peaks.', 1),
('2021-10-01 09:15:00', 'Dream Sequence', 'Giant reveals final piece of puzzle.', 1),
('2021-10-15 13:40:00', 'Suspect Surveillance', 'Tracked BOB''s movements through hosts.', 1),
('2021-11-01 16:05:00', 'Evidence Processing', 'Analysis of owl feathers complete.', 1),
('2021-11-15 10:30:00', 'Forensic Report', 'Identified unique chemical compound.', 1),
('2021-12-01 14:55:00', 'Lead Follow-up', 'Project Blue Book connection confirmed.', 1),
('2021-12-15 16:20:00', 'Weather Note', 'Electrical disturbances peak at midnight.', 1),
('2022-01-01 11:45:00', 'Official Report', 'Case reaching critical phase.', 1),
('2022-01-15 15:10:00', 'Theory Update', 'Final pattern becomes clear.', 1),
('2022-01-30 09:35:00', 'Personal Note', 'The owls are not what they seem.', 1),
('2022-02-01 13:00:00', 'Evidence Review', 'All pieces finally connecting.', 1),
('2022-02-05 16:25:00', 'Location Search', 'Final search of coordinates revealed.', 1),
('2022-02-07 10:50:00', 'Dream Log', 'Final warning from White Lodge.', 1),
('2022-02-08 14:15:00', 'Suspect Interview', 'Final confrontation approaching.', 1),
('2022-02-09 16:40:00', 'Evidence Analysis', 'Last pieces fall into place.', 1),
('2022-02-10 11:05:00', 'Official Document', 'Case closure procedures initiated.', 1),
('2022-02-12 15:30:00', 'Forensic Report', 'Final analysis confirms theories.', 1),
('2022-02-13 09:55:00', 'Theory Development', 'Case solved but questions remain.', 1),
('2022-02-14 13:20:00', 'Personal Reflection', 'Twin Peaks forever changed.', 1),
('2022-02-15 16:45:00', 'Official Report', 'Case officially closed.', 1);

INSERT INTO events (display_timestamp, title, input_text, project_id) VALUES
('2024-11-01 09:00:00', 'Field Investigation', 'Multiple tracks found in snow, evidence suggests three suspects', 1),
('2024-11-15 14:30:00', 'Witness Statement', 'Store clerk reports suspicious activity near closing time', 1),
('2024-12-01 11:00:00', 'Surveillance Report', 'Target observed meeting unknown contacts at cafe', 1),
('2024-12-15 16:45:00', 'Personal Notes', 'Something doesn''t add up about the timeline', 1),
('2024-12-24 20:00:00', 'Weather Impact', 'Heavy snowfall may affect evidence preservation', 1),
('2025-01-02 08:15:00', 'Theory Development', 'New patterns emerging from recent surveillance data', 1),
('2025-01-15 13:00:00', 'Evidence Collection', 'Retrieved security footage from nearby buildings', 1);


INSERT INTO events_tags (event_id, tag_id) VALUES
-- Initial Case Report - Event 1
(1, 2), (1, 12), -- EVIDENCE, OFFICIAL
-- Weather Report - Event 2
(2, 14), -- WEATHER
-- Autopsy Findings - Event 3
(3, 3), (3, 2), (3, 12), -- FORENSICS, EVIDENCE, OFFICIAL
-- Evidence Collection - Event 4
(4, 2), (4, 5), -- EVIDENCE, LEAD
-- Witness Interview - Event 5
(5, 11), (5, 1), -- WITNESS, INTERVIEW
-- Location Analysis - Event 6
(6, 8), (6, 2), -- LOCATION, EVIDENCE
-- Dream Log Entry - Event 7
(7, 15), (7, 13), -- DREAM, PERSONAL
-- Surveillance Setup - Event 8
(8, 4), -- SURVEILLANCE
-- Personal Note - Event 9
(9, 13), -- PERSONAL
-- Evidence Analysis - Event 10
(10, 2), (10, 3), -- EVIDENCE, FORENSICS
-- Suspect Interview - Event 11
(11, 9), (11, 1), -- SUSPECT, INTERVIEW
-- Weather Report - Event 12
(12, 14), -- WEATHER
-- Location Search - Event 13
(13, 8), -- LOCATION
-- Evidence Recovery - Event 14
(14, 2), -- EVIDENCE
-- Witness Statement - Event 15
(15, 11), (15, 1), -- WITNESS, INTERVIEW
-- Dream Log - Event 16
(16, 15), (16, 13), -- DREAM, PERSONAL
-- Forensic Report - Event 17
(17, 3), (17, 2), -- FORENSICS, EVIDENCE
-- Surveillance Notes - Event 18
(18, 4), -- SURVEILLANCE
-- Official Document - Event 19
(19, 12), -- OFFICIAL
-- Theory Development - Event 20
(20, 6), -- THEORY
-- Lead Investigation - Event 21
(21, 5), -- LEAD
-- Personal Reflection - Event 22
(22, 13), -- PERSONAL
-- Evidence Processing - Event 23
(23, 2), (23, 3), -- EVIDENCE, FORENSICS
-- Witness Interview - Event 24
(24, 11), (24, 1), -- WITNESS, INTERVIEW
-- Location Investigation - Event 25
(25, 8), -- LOCATION
-- Dream Sequence - Event 26
(26, 15), -- DREAM
-- Suspect Surveillance - Event 27
(27, 9), (27, 4), -- SUSPECT, SURVEILLANCE
-- Evidence Collection - Event 28
(28, 2), -- EVIDENCE
-- Weather Note - Event 29
(29, 14), -- WEATHER
-- Forensic Analysis - Event 30
(30, 3), -- FORENSICS
-- Lead Follow-up - Event 31
(31, 5), -- LEAD
-- Official Report - Event 32
(32, 12), -- OFFICIAL
-- Theory Update - Event 33
(33, 6), -- THEORY
-- Personal Note - Event 34
(34, 13), -- PERSONAL
-- Surveillance Report - Event 35
(35, 4), -- SURVEILLANCE
-- Evidence Review - Event 36
(36, 2), -- EVIDENCE
-- Witness Statement - Event 37
(37, 11), -- WITNESS
-- Location Search - Event 38
(38, 8), -- LOCATION
-- Dream Log - Event 39
(39, 15), -- DREAM
-- Suspect Interview - Event 40
(40, 9), (40, 1), -- SUSPECT, INTERVIEW
-- Evidence Analysis - Event 41
(41, 2), -- EVIDENCE
-- Forensic Report - Event 42
(42, 3), -- FORENSICS
-- Lead Investigation - Event 43
(43, 5), -- LEAD
-- Weather Update - Event 44
(44, 14), -- WEATHER
-- Official Document - Event 45
(45, 12), -- OFFICIAL
-- Theory Development - Event 46
(46, 6), -- THEORY
-- Personal Reflection - Event 47
(47, 13), -- PERSONAL
-- Surveillance Notes - Event 48
(48, 4), -- SURVEILLANCE
-- Evidence Collection - Event 49
(49, 2), -- EVIDENCE
-- Witness Interview - Event 50
(50, 11), (50, 1), -- WITNESS, INTERVIEW
-- Location Analysis - Event 51
(51, 8), -- LOCATION
-- Dream Sequence - Event 52
(52, 15), -- DREAM
-- Suspect Surveillance - Event 53
(53, 9), (53, 4), -- SUSPECT, SURVEILLANCE
-- Evidence Processing - Event 54
(54, 2), -- EVIDENCE
-- Forensic Report - Event 55
(55, 3), -- FORENSICS
-- Lead Follow-up - Event 56
(56, 5), -- LEAD
-- Weather Note - Event 57
(57, 14), -- WEATHER
-- Official Report - Event 58
(58, 12), -- OFFICIAL
-- Theory Update - Event 59
(59, 6), -- THEORY
-- Personal Note - Event 60
(60, 13), -- PERSONAL
-- Evidence Review - Event 61
(61, 2), -- EVIDENCE
-- Surveillance Report - Event 62
(62, 4), -- SURVEILLANCE
-- Witness Statement - Event 63
(63, 11), -- WITNESS
-- Location Search - Event 64
(64, 8), -- LOCATION
-- Dream Log - Event 65
(65, 15), -- DREAM
-- Suspect Interview - Event 66
(66, 9), (66, 1), -- SUSPECT, INTERVIEW
-- Evidence Analysis - Event 67
(67, 2), -- EVIDENCE
-- Forensic Report - Event 68
(68, 3), -- FORENSICS
-- Lead Investigation - Event 69
(69, 5), -- LEAD
-- Weather Update - Event 70
(70, 14), -- WEATHER
-- Official Document - Event 71
(71, 12), -- OFFICIAL
-- Theory Development - Event 72
(72, 6), -- THEORY
-- Personal Reflection - Event 73
(73, 13), -- PERSONAL
-- Surveillance Notes - Event 74
(74, 4), -- SURVEILLANCE
-- Evidence Collection - Event 75
(75, 2), -- EVIDENCE
-- Witness Interview - Event 76
(76, 11), (76, 1), -- WITNESS, INTERVIEW
-- Location Analysis - Event 77
(77, 8), -- LOCATION
-- Dream Log - Event 78
(78, 15), -- DREAM
-- Suspect Surveillance - Event 79
(79, 9), (79, 4), -- SUSPECT, SURVEILLANCE
-- Evidence Processing - Event 80
(80, 2), -- EVIDENCE
-- Official Document - Event 81
(81, 12), -- OFFICIAL
-- Forensic Report - Event 82
(82, 3), -- FORENSICS
-- Theory Development - Event 83
(83, 6), -- THEORY
-- Personal Reflection - Event 84
(84, 13), -- PERSONAL
-- Official Report - Event 85
(85, 12), -- OFFICIAL
-- Official Report - Event 86
(86, 12); -- OFFICIAL

INSERT INTO events (display_timestamp, title, input_text, project_id) VALUES
('2024-11-01 09:00:00', 'Field Investigation', 'Multiple tracks found in snow, evidence suggests three suspects', 1),
('2024-11-15 14:30:00', 'Witness Statement', 'Store clerk reports suspicious activity near closing time', 1),
('2024-12-01 11:00:00', 'Surveillance Report', 'Target observed meeting unknown contacts at cafe', 1),
('2024-12-15 16:45:00', 'Personal Notes', 'Something doesn''t add up about the timeline', 1),
('2024-12-24 20:00:00', 'Weather Impact', 'Heavy snowfall may affect evidence preservation', 1),
('2025-01-02 08:15:00', 'Theory Development', 'New patterns emerging from recent surveillance data', 1),
('2025-01-15 13:00:00', 'Evidence Collection', 'Retrieved security footage from nearby buildings', 1);

INSERT INTO events_tags (event_id, tag_id) VALUES
(97, 2),
(98, 2),
(99, 3),
(100, 2),
(101, 4);

INSERT INTO events (display_timestamp, title, input_text, project_id) VALUES
('2024-11-01 09:00:00', 'Field Investigation', 'Multiple tracks found in snow, evidence suggests three suspects', 1),
('2024-11-03 14:30:00', 'Witness Statement A', 'Store clerk reports suspicious activity near closing time', 1),
('2024-11-05 11:00:00', 'Surveillance Report #1', 'Target observed meeting unknown contacts at cafe', 1),
('2024-11-08 16:45:00', 'Personal Notes', 'Something doesn''t add up about the timeline', 1),
('2024-11-10 20:00:00', 'Weather Impact', 'Heavy snowfall may affect evidence preservation', 1),
('2024-11-12 08:15:00', 'Theory Development', 'New patterns emerging from recent surveillance data', 1),
('2024-11-15 13:00:00', 'Evidence Collection A', 'Retrieved security footage from nearby buildings', 1),
('2024-11-17 15:30:00', 'Witness Statement B', 'Local resident reports unusual sounds late at night', 1),
('2024-11-20 10:00:00', 'Surveillance Setup', 'New cameras installed at key locations', 1),
('2024-11-22 14:45:00', 'Evidence Analysis', 'Initial lab results from collected samples', 1),
('2024-11-25 09:30:00', 'Field Report Update', 'Additional tracks found in new location', 1),
('2024-11-28 16:00:00', 'Witness Statement C', 'Delivery driver provides crucial timeline information', 1),
('2024-12-01 11:15:00', 'Surveillance Report #2', 'Suspicious vehicle spotted multiple times', 1),
('2024-12-03 13:45:00', 'Evidence Collection B', 'Found discarded items near original scene', 1),
('2024-12-05 15:20:00', 'Weather Update', 'Incoming storm may complicate investigation', 1),
('2024-12-08 10:40:00', 'Theory Revision', 'New evidence suggests alternative scenario', 1),
('2024-12-10 14:15:00', 'Field Investigation B', 'Secondary location shows similar patterns', 1),
('2024-12-12 09:00:00', 'Surveillance Report #3', 'Night activity increased in target area', 1),
('2024-12-15 16:30:00', 'Evidence Processing', 'Lab confirms unusual material composition', 1),
('2024-12-17 11:45:00', 'Witness Statement D', 'Anonymous tip provides new lead', 1),
('2024-12-20 13:20:00', 'Field Assessment', 'Area mapping reveals potential pattern', 1),
('2024-12-22 15:00:00', 'Evidence Review', 'Comparing collected samples with database', 1),
('2024-12-24 10:15:00', 'Surveillance Summary', 'Week compilation of observed activities', 1),
('2024-12-26 14:40:00', 'Weather Impact Report', 'Snow preservation of key evidence', 1),
('2024-12-28 09:45:00', 'Theory Development B', 'Connecting multiple witness accounts', 1),
('2024-12-30 16:15:00', 'Field Investigation C', 'New location identified through tips', 1),
('2025-01-02 11:30:00', 'Evidence Collection C', 'Retrieved items from secondary scene', 1),
('2025-01-04 13:50:00', 'Surveillance Report #4', 'Unusual patterns in foot traffic observed', 1),
('2025-01-06 15:25:00', 'Witness Statement E', 'Security guard provides overnight account', 1),
('2025-01-08 10:00:00', 'Weather Conditions', 'Freezing rain affects scene preservation', 1),
('2025-01-10 14:20:00', 'Theory Testing', 'Field verification of recent hypothesis', 1),
('2025-01-12 09:15:00', 'Evidence Analysis B', 'Secondary lab results received', 1),
('2025-01-14 16:45:00', 'Field Report Update B', 'Expanded search area findings', 1),
('2025-01-16 11:10:00', 'Surveillance Report #5', 'Vehicle pattern analysis complete', 1),
('2025-01-18 13:35:00', 'Witness Statement F', 'Business owner reports suspicious rental', 1),
('2025-01-20 15:00:00', 'Evidence Processing B', 'Digital forensics preliminary results', 1),
('2025-01-22 10:25:00', 'Theory Correlation', 'Linking multiple event sequences', 1),
('2025-01-24 14:50:00', 'Field Investigation D', 'Underground access point discovered', 1),
('2025-01-26 09:30:00', 'Surveillance Setup B', 'Additional coverage expansion complete', 1),
('2025-01-28 16:00:00', 'Evidence Review B', 'Cross-referencing with cold cases', 1);

INSERT INTO events_tags (event_id, tag_id) VALUES
(104, 1), (104, 2), (104, 3),
(105, 2), (105, 4),
(106, 3), (106, 5),
(107, 1), (107, 4),
(108, 2), (108, 5),
(109, 3), (109, 1),
(110, 4), (110, 2),
(111, 5), (111, 3),
(112, 1), (112, 4),
(113, 2), (113, 5),
(114, 3), (114, 1),
(115, 4), (115, 2),
(116, 5), (116, 3),
(117, 1), (117, 4),
(118, 2), (118, 5),
(119, 3), (119, 1),
(120, 4), (120, 2),
(121, 5), (121, 3),
(122, 1), (122, 4),
(123, 2), (123, 5),
(124, 3), (124, 1),
(125, 4), (125, 2),
(126, 5), (126, 3),
(127, 1), (127, 4),
(128, 2), (128, 5),
(129, 3), (129, 1),
(130, 4), (130, 2),
(131, 5), (131, 3),
(132, 1), (132, 4),
(133, 2), (133, 5),
(134, 3), (134, 1),
(135, 4), (135, 2),
(136, 5), (136, 3),
(137, 1), (137, 4),
(138, 2), (138, 5),
(139, 3), (139, 1),
(140, 4), (140, 2),
(141, 5), (141, 3),
(142, 1), (142, 4),
(143, 2), (143, 5),
(144, 3), (144, 1);