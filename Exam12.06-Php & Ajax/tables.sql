-- Database name: avatars

CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50),
  password VARCHAR(50)
);


CREATE TABLE avatars (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(60),
  age INT,
  powers VARCHAR(100),
  rank INT
);

CREATE TABLE logs (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    log_date DATETIME,
    log_text VARCHAR(100),
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

