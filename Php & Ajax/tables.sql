CREATE TABLE SoftwareDeveloper (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    age INT,
    skills VARCHAR(200)
);

CREATE TABLE Project (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ProjectManagerID INT,
    name VARCHAR(255),
    description VARCHAR(200),
    members VARCHAR(300),
    FOREIGN KEY (ProjectManagerID) REFERENCES SoftwareDeveloper(id)
);