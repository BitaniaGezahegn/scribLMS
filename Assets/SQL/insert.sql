-- Sample Data for locallibrary Database

-- BookDetail
INSERT INTO BookDetail (title, publication_year, cover_image, description, publisher, copies_owned) VALUES
    ('Atomic Habits', 2018, 'Assets/Images/Book Covers/Atomic Habits.jpg', 'A comprehensive guide to understanding how habits work and how to change them. James Clear, one of the worlds leading experts on habit formation, reveals practical strategies that will teach you exactly how to form good habits, break bad ones, and master the tiny behaviors that lead to remarkable results.', 'Avery', 3),
    ('Dune', 1965, 'Assets/Images/Book Covers/Dune.jpg', 'A science fiction epic set on the desert planet Arrakis, where the only source of the valuable spice melange is guarded by giant sandworms. The story follows Paul Atreides, whose family is betrayed and must fight for survival in a complex political and ecological landscape.', 'Chilton Books', 3),
    ('Educated', 2018, 'Assets/Images/Book Covers/Educated.jpg', 'Tara Westovers memoir about her unconventional upbringing in a survivalist Mormon family in Idaho and her journey to overcome adversity and earn a PhD from Cambridge University.', 'Random House', 3),
    ('Pride and Prejudice', 1813, 'Assets/Images/Book Covers/Pride and Prejudice.jpg', 'A classic romantic novel set in 19th-century England, exploring themes of love, class, and social prejudice through the witty and engaging story of Elizabeth Bennet and Mr. Darcy.', 'T. Egerton (originally) / Penguin Classics (modern edition)', 3),
    ('Project Hail Mary', 2021, 'Assets/Images/Book Covers/Project Hail Mary.jpg', 'A science fiction thriller about Ryland Grace, an amnesiac astronaut who wakes up alone on a spaceship with no memory of his mission or how he got there. He must piece together the clues to save himself and humanity from an extinction-level event.', 'Ballantine Books', 3),
    ('Sapiens: A Brief History of Humankind', 2011, 'Assets/Images/Book Covers/Sapiens- A Brief History of Humankind.jpg', 'A sweeping exploration of the history of humankind from the Stone Age to the present day, examining the key events and forces that have shaped our species and our world.', 'Harper', 3),
    ('The Great Gatsby', 1925, 'Assets/Images/Book Covers/The Great Gatsby.png', 'A classic American novel set in the Roaring Twenties, following the story of Jay Gatsby, a self-made millionaire who throws lavish parties in hopes of reuniting with his lost love, Daisy Buchanan.', 'Charles Scribners Sons', 3),
    ('The House in the Cerulean Sea', 2020, 'Assets/Images/Book Covers/The House in the Cerulean Sea.jpg', 'A heartwarming and magical story about Linus Baker, a social worker who is sent to investigate an orphanage for magical children and discovers a found family in the most unexpected place.', 'Tor Books', 3),
    ('The Midnight Library', 2020, 'Assets/Images/Book Covers/The Midnight Library.jpg', 'Nora Seed finds herself in a library between life and death, where each book offers a chance to live a different version of her life. She must decide what truly makes life worth living.', 'Viking', 3),
    ('The Seven Husbands of Evelyn Hugo', 2017, 'Assets/Images/Book Covers/The Seven Husbands of Evelyn Hugo.jpg', 'Reclusive Hollywood legend Evelyn Hugo chooses unknown reporter Monique Grant to write her life story. Evelyn recounts her time in the Golden Age of Hollywood, her rise to fame, and her seven marriages, revealing shocking truths along the way.', 'Atria Books', 3);

-- BookCategory
INSERT INTO BookCategory (category) VALUES
    ('Self-help'),
    ('Personal Development'),
    ('Science Fiction'),
    ('Memoir'),
    ('Romance'),
    ('Historical Fiction'),
    ('Non-fiction'),
    ('History'),
    ('Anthropology'),
    ('Classic Literature'),
    ('Fiction'),
    ('Fantasy'),
    ('Contemporary'),
    ('Magical Realism');

-- BookStatus
INSERT INTO BookStatus (status) VALUES
    ('available'),
    ('unavailable');

-- Authors
INSERT INTO Authors (firstName, lastName, biography) VALUES
    ('James', 'Clear', 'Author and speaker focused on habits, decision-making, and continuous improvement. Known for "Atomic Habits," which explores the science of small habits.'),
    ('Frank', 'Herbert', 'American science fiction author best known for the "Dune" series. His novels explored themes of ecology, politics, and religion.'),
    ('Tara', 'Westover', 'American memoirist, essayist, and historian. Her memoir "Educated" tells the story of her unconventional upbringing and journey to earn a PhD.'),
    ('Jane', 'Austen', 'English novelist known for social commentary and witty observations of 19th-century English society. Novels include "Pride and Prejudice," "Sense and Sensibility," and "Emma."'),
    ('Andy', 'Weir', 'American science fiction novelist best known for "The Martian." His writing is characterized by scientific accuracy and attention to detail.'),
    ('Yuval Noah', 'Harari', 'Israeli historian, philosopher, and professor. Known for "Sapiens: A Brief History of Humankind," "Homo Deus," and "21 Lessons for the 21st Century."'),
    ('F. Scott', 'Fitzgerald', 'American novelist and short story writer of the Jazz Age. Known for "The Great Gatsby," a cautionary tale about the American Dream.'),
    ('TJ', 'Klune', 'American fantasy, science fiction, and romance novelist. His books often feature LGBTQ+ characters and explore themes of found family and acceptance.'),
    ('Matt', 'Haig', 'English novelist and childrens author. His books explore themes of mental health, identity, and the meaning of life. Known for "The Midnight Library."'),
    ('Taylor Jenkins', 'Reid', 'American novelist known for historical fiction and romance novels. Her books often feature strong female characters and explore themes of love, ambition, and fame.');
-- Books
INSERT INTO Books (ISBN, bookDetails, statusID) VALUES
    ('978-0735211292', 1, 1), 
    ('0-441-17271-7', 2, 1), 
    ('978-0399590504', 3, 1), 
    ('978-0141439518', 4, 1), 
    ('978-0593135204', 5, 1), 
    ('978-0062316097', 6, 1), 
    ('978-0743273565', 7, 1), 
    ('978-1250217295', 8, 1), 
    ('978-0525559474', 9, 1), 
    ('978-1524798635', 10, 1);

-- BookAuthor
INSERT INTO BookAuthor (bookID, authorID) VALUES
    ('978-0735211292', 1), 
    ('0-441-17271-7',  2),
    ('978-0399590504', 3), 
    ('978-0141439518', 4), 
    ('978-0593135204', 5), 
    ('978-0062316097', 6), 
    ('978-0743273565', 7), 
    ('978-1250217295', 8), 
    ('978-0525559474', 9), 
    ('978-1524798635', 10);


-- BookGenre
-- First, we need to know the IDs of the categories. Let's create a subquery for that.
INSERT INTO BookGenre (bookID, categoryID) VALUES
    -- Atomic Habits: Self-help, Personal Development
    ('978-0735211292', (SELECT id FROM BookCategory WHERE category = 'Self-help')),
    ('978-0735211292', (SELECT id FROM BookCategory WHERE category = 'Personal Development')),

    -- Dune: Science Fiction
    ('0-441-17271-7', (SELECT id FROM BookCategory WHERE category = 'Science Fiction')),

    -- Educated: Memoir
    ('978-0399590504', (SELECT id FROM BookCategory WHERE category = 'Memoir')),

    -- Pride and Prejudice: Romance, Historical Fiction
    ('978-0141439518', (SELECT id FROM BookCategory WHERE category = 'Romance')),
    ('978-0141439518', (SELECT id FROM BookCategory WHERE category = 'Historical Fiction')),

    -- Project Hail Mary: Science Fiction
    ('978-0593135204', (SELECT id FROM BookCategory WHERE category = 'Science Fiction')),

    -- Sapiens: A Brief History of Humankind: Non-fiction, History, Anthropology
    ('978-0062316097', (SELECT id FROM BookCategory WHERE category = 'Non-fiction')),
    ('978-0062316097', (SELECT id FROM BookCategory WHERE category = 'History')),
    ('978-0062316097', (SELECT id FROM BookCategory WHERE category = 'Anthropology')),

    -- The Great Gatsby: Classic Literature, Fiction
    ('978-0743273565', (SELECT id FROM BookCategory WHERE category = 'Classic Literature')),
    ('978-0743273565', (SELECT id FROM BookCategory WHERE category = 'Fiction')),

    -- The House in the Cerulean Sea: Fantasy, Contemporary
    ('978-1250217295', (SELECT id FROM BookCategory WHERE category = 'Fantasy')),
    ('978-1250217295', (SELECT id FROM BookCategory WHERE category = 'Contemporary')),

    -- The Midnight Library: Fantasy, Magical Realism
    ('978-0525559474', (SELECT id FROM BookCategory WHERE category = 'Fantasy')),
    ('978-0525559474', (SELECT id FROM BookCategory WHERE category = 'Magical Realism')),

    -- The Seven Husbands of Evelyn Hugo: Historical Fiction, Romance
    ('978-1524798635', (SELECT id FROM BookCategory WHERE category = 'Historical Fiction')),
    ('978-1524798635', (SELECT id FROM BookCategory WHERE category = 'Romance'));


-- UserRole
INSERT INTO UserRole (role) VALUES
('Admin'),
('Librarian');

-- UserStatus
INSERT INTO UserStatus (status) VALUES
('approved'),
('unapproved'),
('suspended');

-- UserDetail
INSERT INTO UserDetail (username, firstName, lastName, password) VALUES
('admin', 'Admin', 'User', 'password123'),
('librarian', 'Librarian', 'One', 'securepass'),
('libraryan2', 'Librariyan', 'Two', 'mysecret');

-- Users
INSERT INTO Users (roleID, detailsID) VALUES
(1, 1),
(2, 2),
(2, 3);