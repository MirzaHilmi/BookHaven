CREATE TABLE Users
(
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255),
    Email VARCHAR(255) UNIQUE,
    Password VARCHAR(255),
    CreatedAt DATETIME DEFAULT (NOW()),
    UpdatedAt DATETIME DEFAULT (NOW())
);