

CREATE TABLE url (
                     id INT AUTO_INCREMENT PRIMARY KEY,
                     url TEXT NOT NULL,
                     short VARCHAR(10) NOT NULL UNIQUE,
                     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
