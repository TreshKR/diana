-- ESTO ES CLAUDE AI con una levísima revisión humana
-- Create projects table
CREATE TABLE projects (
    id SERIAL PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title VARCHAR(255) NOT NULL,
    description TEXT
);

-- Create events table
CREATE TABLE events (
  id SERIAL PRIMARY KEY,
  display_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  title VARCHAR(255) DEFAULT 'UNTITLED',
  icon VARCHAR(255) DEFAULT NULL,
  color VARCHAR(255) DEFAULT NULL,
  input_text TEXT,
  input_audio VARCHAR(255) DEFAULT NULL,
  input_image VARCHAR(255) DEFAULT NULL,
  project_id INTEGER REFERENCES projects(id) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create tags table
  CREATE TABLE tags (
  id SERIAL PRIMARY KEY,
  name VARCHAR(255) NOT NULL
);

-- Create events_tags table
CREATE TABLE events_tags (
  id SERIAL PRIMARY KEY,
  event_id INTEGER REFERENCES events(id),
  tag_id INTEGER REFERENCES tags(id)
);

-- Create config table
CREATE TABLE config (
  id SERIAL PRIMARY KEY,
  config_name VARCHAR(255) NOT NULL,
  config_value TEXT
);