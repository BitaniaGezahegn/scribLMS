-- BookCategory
INSERT INTO BookCategory (category) VALUES
('Science Fiction'),
('Romance'),
('Fantasy'),
('Dystopian'),
('Classic'),
('Adventure');

-- BookStatus
INSERT INTO BookStatus (status) VALUES
('available'),
('unavailable');

-- Authors
INSERT INTO Authors (firstName, lastName, biography) VALUES
('Douglas', 'Adams', 'British author known for The Hitchhiker''s Guide to the Galaxy.'),
('Jane', 'Austen', 'English novelist known for her romantic fiction.'),
('Frank', 'Herbert', 'American science fiction author.'),
('J.R.R.', 'Tolkien', 'English author and scholar.'),
('George', 'Orwell', 'English novelist and essayist.');

-- UserRole
INSERT INTO UserRole (role) VALUES
('Admin'),
('Librarian');

-- UserStatus
INSERT INTO UserStatus (status) VALUES
('active'),
('inactive'),
('suspended');