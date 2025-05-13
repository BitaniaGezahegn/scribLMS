-- Books CRUD Operations (Revised)

-- Create a new book (linking to existing category, status, and author)
INSERT INTO BookDetail (title, publication_year, description, publisher, copies_owned)
VALUES ('New Book Title', 2024, 'A brand new book.', 'New Publisher', 20);

INSERT INTO Books (ISBN, bookDetails, categoryID, statusID)
VALUES ('978-NEWISBN', LAST_INSERT_ID(), 1, 1);  -- Replace 1 with the actual category and status IDs

-- Add authors to the book (assuming you have author IDs)
INSERT INTO BookAuthor (bookID, authorID)
VALUES ('978-NEWISBN', 1),  -- Replace 1 with the actual author ID
       ('978-NEWISBN', 2);  -- Replace 2 with another author ID if needed

-- Read a book with all its details, category, status, and authors
SELECT b.ISBN, bd.title, bd.publication_year, bd.description, bd.publisher, bd.copies_owned, bc.category, bs.status, a.firstName, a.lastName
FROM Books b
JOIN BookDetail bd ON b.bookDetails = bd.id
JOIN BookCategory bc ON b.categoryID = bc.id
JOIN BookStatus bs ON b.statusID = bs.id
JOIN BookAuthor ba ON b.ISBN = ba.bookID
JOIN Authors a ON ba.authorID = a.id
WHERE b.ISBN = '978-NEWISBN'; -- Replace with the ISBN you want to read


-- Update a book and all its related information
UPDATE BookDetail bd
JOIN Books b ON bd.id = b.bookDetails
SET bd.title = 'Updated Book Title',
    bd.publication_year = 2025,
    bd.description = 'An updated description.',
    bd.publisher = 'Updated Publisher',
    bd.copies_owned = 25
WHERE b.ISBN = '978-NEWISBN';

-- Update category and status (using subqueries to get IDs)
UPDATE Books
SET categoryID = (SELECT id FROM BookCategory WHERE category = 'Updated Category'), -- Ensure category exists
    statusID = (SELECT id FROM BookStatus WHERE status = 'Checked Out') -- Ensure status exists
WHERE ISBN = '978-NEWISBN';


-- Update the authors (you'll likely need to delete the old ones and add new ones)
DELETE FROM BookAuthor WHERE bookID = '978-NEWISBN'; -- Remove old authors

INSERT INTO BookAuthor (bookID, authorID)  -- Add updated authors
VALUES ('978-NEWISBN', 3),  -- Replace 3 with the new author ID
       ('978-NEWISBN', 4);  -- Replace 4 with another new author ID if needed

-- Delete a book (cascade deletes will handle BookDetail and BookAuthor)
DELETE FROM Books WHERE ISBN = '978-NEWISBN';




-- Authors CRUD Operations (Comprehensive)

-- Create a new author
INSERT INTO Authors (firstName, lastName, biography)
VALUES ('New Author First', 'New Author Last', 'New author biography.');

-- Read an author with their books
SELECT a.id, a.firstName, a.lastName, a.biography, b.ISBN, bd.title
FROM Authors a
LEFT JOIN BookAuthor ba ON a.id = ba.authorID
LEFT JOIN Books b ON ba.bookID = b.ISBN
LEFT JOIN BookDetail bd ON b.bookDetails = bd.id
WHERE a.id = LAST_INSERT_ID(); -- Or a specific author ID

-- Update an author and their books (similar to the update book operation, may require deleting and re-inserting bookauthor entries)
UPDATE Authors
SET firstName = 'Updated Author First',
    lastName = 'Updated Author Last',
    biography = 'Updated author biography.'
WHERE id = LAST_INSERT_ID(); -- Or a specific author ID

-- Delete an author (cascade deletes will handle BookAuthor)
DELETE FROM Authors WHERE id = LAST_INSERT_ID(); -- Or a specific author ID

-- Users CRUD Operations (Comprehensive)

-- Create a new user (with role and details)
INSERT INTO UserDetail (username, firstName, lastName, joinedDate, password) -- Hash password in real app!
VALUES ('newuser', 'New', 'User', '2024-01-01', 'hashed_password');

INSERT INTO Users (roleID, statusID, detailsID)
VALUES (1, 1, LAST_INSERT_ID()); -- Replace 1 with the actual role and status IDs

-- Read a user with their role and details
SELECT u.id, ud.username, ud.firstName, ud.lastName, ur.role, us.status
FROM Users u
JOIN UserDetail ud ON u.detailsID = ud.id
JOIN UserRole ur ON u.roleID = ur.id
JOIN UserStatus us ON u.statusID = us.id
WHERE u.id = LAST_INSERT_ID(); -- Or a specific user ID

-- Update a user and their role/details
UPDATE UserDetail ud
JOIN Users u ON ud.id = u.detailsID
SET ud.username = 'updateduser',
    ud.firstName = 'Updated',
    ud.lastName = 'User',
    ud.password = 'new_hashed_password' -- Hash password in real app!
WHERE u.id = LAST_INSERT_ID(); -- Or a specific user ID

-- Update the role and status (using subqueries to get IDs)
UPDATE Users
SET roleID = (SELECT id FROM UserRole WHERE role = 'Updated Role'),  -- Ensure role exists
    statusID = (SELECT id FROM UserStatus WHERE status = 'Inactive') -- Ensure status exists
WHERE id = LAST_INSERT_ID(); -- Or a specific user ID



-- Delete a user (cascade deletes will handle UserDetail)
DELETE FROM Users WHERE id = LAST_INSERT_ID(); -- Or a specific user ID





















-- Update Book Details by updating all columns
UPDATE bookdetail
SET title = ?,
publication_year = ?,
cover_image = ?,
description = ?,
publisher = ?,
copies_owned = ?
WHERE id = (SELECT bookdetails FROM books WHERE ISBN = ?);


-- Update Status
UPDATE Books SET statusID = 1 WHERE ISBN = '978-0451524935';

-- UPDATE Genre by deleting all records with id and looping and adding the ids with their coresponding  values
DELETE FROM bookgenre
WHERE bookID = '978-0441172719';
INSERT INTO BookGenre (bookID, categoryID) VALUES 
('978-0441172719', 5),
('978-0441172719', 6);

-- Update Authors the same as Geners
DELETE FROM bookauthor
WHERE bookID = '978-0441172719';
INSERT INTO bookauthor (bookID, authorID) VALUES 
('978-0441172719', 1),
('978-0441172719', 2);


-- 1. Delete entries in BookAuthor
DELETE FROM BookAuthor WHERE bookID = '978-0441172719';

-- 2. Delete entries in BookGenre
DELETE FROM BookGenre WHERE bookID = '978-0441172719';

-- 3. Delete the entry in Books
DELETE FROM Books WHERE ISBN = '978-0441172719';

-- 4. Delete the entry in BookDetail
DELETE FROM BookDetail WHERE id = (SELECT bookDetails from Books where ISBN = '978-0441172719');