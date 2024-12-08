CREATE TABLE user_accounts (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE,  
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    password TEXT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE albums (
    album_id INT AUTO_INCREMENT PRIMARY KEY,
    album_name VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (username) REFERENCES user_accounts(username) 
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE photos (
    photo_id INT AUTO_INCREMENT PRIMARY KEY,
    album_id INT NULL,  
    photo_name TEXT,
    username VARCHAR(255),
    description VARCHAR(255),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (album_id) REFERENCES albums(album_id) 
        ON DELETE SET NULL ON UPDATE CASCADE, 
    FOREIGN KEY (username) REFERENCES user_accounts(username) 
        ON DELETE CASCADE ON UPDATE CASCADE
);