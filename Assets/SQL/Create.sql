-- CREATE DATABASE locallibrary;
-- BookDetail
CREATE TABLE BookDetail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    publication_year INT,
    cover_image VARCHAR(255),
    description TEXT,
    publisher VARCHAR(255),
    copies_owned INT DEFAULT 0
);

-- BookCategory
CREATE TABLE BookCategory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(255) UNIQUE NOT NULL
);

-- BookStatus
CREATE TABLE BookStatus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status VARCHAR(255) UNIQUE NOT NULL
);

-- Authors
CREATE TABLE Authors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(255) NOT NULL,
    lastName VARCHAR(255),
    biography TEXT
);

-- Books
CREATE TABLE Books (
    ISBN VARCHAR(20) PRIMARY KEY,
    bookDetails INT UNIQUE,
    statusID INT,
    FOREIGN KEY (bookDetails) REFERENCES BookDetail(id),
    FOREIGN KEY (statusID) REFERENCES BookStatus(id)
);

-- BookAuthor (Many-to-Many)
CREATE TABLE BookAuthor (
    bookID VARCHAR(20),
    authorID INT,
    PRIMARY KEY (bookID, authorID),
    FOREIGN KEY (bookID) REFERENCES Books(ISBN),
    FOREIGN KEY (authorID) REFERENCES Authors(id)
);

-- BookGenre(Many-to-Many)
CREATE TABLE BookGenre (
    bookID VARCHAR(20),
    categoryID INT,
    PRIMARY KEY (bookID, categoryID),
    FOREIGN KEY (bookID) REFERENCES Books(ISBN),
    FOREIGN KEY (categoryID) REFERENCES BookCategory(id)
);

-- UserRole
CREATE TABLE UserRole (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(255) UNIQUE NOT NULL
);

-- UserStatus
CREATE TABLE UserStatus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status VARCHAR(255) UNIQUE NOT NULL
);

-- UserDetail
CREATE TABLE UserDetail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    firstName VARCHAR(255),
    lastName VARCHAR(255),
    joinedDate DATE DEFAULT CURRENT_TIMESTAMP,
    password VARCHAR(255) NOT NULL
);

-- Users
CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    roleID INT,
    statusID INT DEFAULT 2,
    detailsID INT UNIQUE,
    FOREIGN KEY (roleID) REFERENCES UserRole(id),
    FOREIGN KEY (statusID) REFERENCES UserStatus(id),
    FOREIGN KEY (detailsID) REFERENCES UserDetail(id)
);