<?php
require_once "dbcon.inc.php";

// Database Queiries
function addBook($isbn, $authorIDs, $title, $publicationYear, $coverImage, $description, $publisher, $copiesOwned, $genreIDs) {
    global $conn;

    // 1. Insert into BookDetail
    $sqlDetail = 'INSERT INTO BookDetail (title, publication_year, cover_image, description, publisher, copies_owned) VALUES (?, ?, ?, ?, ?, ?)';
    $stmtDetail = mysqli_prepare($conn, $sqlDetail);
    if (!$stmtDetail) {
        die('Error preparing BookDetail statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmtDetail, 'ssssss', $title, $publicationYear, $coverImage, $description, $publisher, $copiesOwned);
    if (!mysqli_stmt_execute($stmtDetail)) {
        die('Error executing BookDetail statement: ' . mysqli_error($conn));
    }
    $bookDetailID = mysqli_insert_id($conn);
    mysqli_stmt_close($stmtDetail);
    $status = 2;
    if ($copiesOwned > 0) {
        $status = 1;
    }

    // 2. Insert into Books
    $sqlBooks = 'INSERT INTO Books (ISBN, bookDetails, statusID) VALUES (?, ?, ?)';
    $stmtBooks = mysqli_prepare($conn, $sqlBooks);
    if (!$stmtBooks) {
        die('Error preparing Books statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmtBooks, 'sii', $isbn, $bookDetailID, $status);
    if (!mysqli_stmt_execute($stmtBooks)) {
        die('Error executing Books statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_close($stmtBooks);

    // 3. Insert into BookAuthor (Loop through authorIDs)
    $authorIdArray = explode(',', $authorIDs);
    foreach ($authorIdArray as $authorId) {
        $authorId = trim($authorId);
        $sqlAuthor = 'INSERT INTO BookAuthor (bookID, authorID) VALUES (?, ?)';
        $stmtAuthor = mysqli_prepare($conn, $sqlAuthor);
        if (!$stmtAuthor) {
            die('Error preparing BookAuthor statement: ' . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmtAuthor, 'si', $isbn, $authorId);
        if (!mysqli_stmt_execute($stmtAuthor)) {
            die('Error executing BookAuthor statement: ' . mysqli_error($conn));
        }
        mysqli_stmt_close($stmtAuthor);
    }

    // 4. Insert into BookGenre (Loop through genreIDs)
    $genreIdArray = explode(',', $genreIDs);
    foreach ($genreIdArray as $genreId) {
        $genreId = trim($genreId);

        // Insert the BookGenre relationship
        $sqlBookGenre = 'INSERT INTO BookGenre (bookID, categoryID) VALUES (?, ?)';
        $stmtBookGenre = mysqli_prepare($conn, $sqlBookGenre);
        if (!$stmtBookGenre) {
            die('Error preparing BookGenre statement: ' . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmtBookGenre, 'si', $isbn, $genreId);
        if (!mysqli_stmt_execute($stmtBookGenre)) {
            die('Error executing BookGenre statement: ' . mysqli_error($conn));
        }
        mysqli_stmt_close($stmtBookGenre);
    }
}

function updateBook($isbn, $authorIDs, $title, $publicationYear, $coverImage, $description, $publisher, $copiesOwned, $genreIDs) {
    global $conn;

    // 1. Update Book Details
    $sqlDetail = 'UPDATE bookdetail
                    SET title = ?,
                    publication_year = ?,
                    cover_image = ?,
                    description = ?,
                    publisher = ?,
                    copies_owned = ?
                    WHERE id = (SELECT bookdetails FROM books WHERE ISBN = ?);';
    $stmtDetail = mysqli_prepare($conn, $sqlDetail);

    if (!$stmtDetail) {
        die('Error preparing BookDetail statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmtDetail, 'sssssss',  $title, $publicationYear, $coverImage, $description, $publisher, $copiesOwned, $isbn);
    
    if (!mysqli_stmt_execute($stmtDetail)) {
        die('Error executing BookDetail statement: ' . mysqli_error($conn));
    }

    $bookDetailID = mysqli_insert_id($conn);
    mysqli_stmt_close($stmtDetail);
    $status = 2;
    if ($copiesOwned > 0) {
        $status = 1;
    }

    // 2. Update Status
    $sqlBooks = 'UPDATE Books SET statusID = ? WHERE ISBN = ?;';
    $stmtBooks = mysqli_prepare($conn, $sqlBooks);
    
    if (!$stmtBooks) {
        die('Error preparing Books statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmtBooks, 'is', $status, $isbn);
    if (!mysqli_stmt_execute($stmtBooks)) {
        die('Error executing Books statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_close($stmtBooks);

    // 3. Delete all existing book authors
    $sqlBooks = 'DELETE FROM bookauthor WHERE bookID = ?;';
    $stmtBooks = mysqli_prepare($conn, $sqlBooks);
    
    if (!$stmtBooks) {
        die('Error preparing Books statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmtBooks, 's', $isbn);
    if (!mysqli_stmt_execute($stmtBooks)) {
        die('Error executing Books statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_close($stmtBooks);
    
    // 4. Insert authors
    $authorIdArray = explode(',', $authorIDs);
    foreach ($authorIdArray as $authorId) {
        $authorId = trim($authorId);
        $sqlAuthor = 'INSERT INTO BookAuthor (bookID, authorID) VALUES (?, ?)';
        $stmtAuthor = mysqli_prepare($conn, $sqlAuthor);

        if (!$stmtAuthor) {
            die('Error preparing BookAuthor statement: ' . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmtAuthor, 'si', $isbn, $authorId);
        if (!mysqli_stmt_execute($stmtAuthor)) {
            die('Error executing BookAuthor statement: ' . mysqli_error($conn));
        }
        mysqli_stmt_close($stmtAuthor);
    }

    // 5. Delete bookGeners
    $sqlBooks = 'DELETE FROM bookgenre WHERE bookID = ?;';
    $stmtBooks = mysqli_prepare($conn, $sqlBooks);
    
    if (!$stmtBooks) {
        die('Error preparing Books statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmtBooks, 's', $isbn);
    if (!mysqli_stmt_execute($stmtBooks)) {
        die('Error executing Books statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_close($stmtBooks);

    // 6. Add Authors
    $genreIdArray = explode(',', $genreIDs);
    foreach ($genreIdArray as $genreId) {
        $genreId = trim($genreId);

        // Insert the BookGenre relationship
        $sqlBookGenre = 'INSERT INTO BookGenre (bookID, categoryID) VALUES (?, ?)';
        $stmtBookGenre = mysqli_prepare($conn, $sqlBookGenre);
        
        if (!$stmtBookGenre) {
            die('Error preparing BookGenre statement: ' . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmtBookGenre, 'si', $isbn, $genreId);
        if (!mysqli_stmt_execute($stmtBookGenre)) {
            die('Error executing BookGenre statement: ' . mysqli_error($conn));
        }
        mysqli_stmt_close($stmtBookGenre);
    }
}

function deleteBook($isbn) {
    global $conn;

    // Delete Authors entries of the book.
    $sqlBooks = 'DELETE FROM BookAuthor WHERE bookID = ?;';
    $stmtBooks = mysqli_prepare($conn, $sqlBooks);
    
    if (!$stmtBooks) {
        die('Error preparing Books statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmtBooks, 's', $isbn);
    if (!mysqli_stmt_execute($stmtBooks)) {
        die('Error executing Books statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_close($stmtBooks);

    // Delete Genre entries of the book.
    $sqlBooks = 'DELETE FROM BookGenre WHERE bookID = ?;';
    $stmtBooks = mysqli_prepare($conn, $sqlBooks);
    
    if (!$stmtBooks) {
        die('Error preparing Books statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmtBooks, 's', $isbn);
    if (!mysqli_stmt_execute($stmtBooks)) {
        die('Error executing Books statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_close($stmtBooks);

    // Delete the entry in books.
    $sqlBooks = 'DELETE FROM Books WHERE ISBN = ?;';
    $stmtBooks = mysqli_prepare($conn, $sqlBooks);
    
    if (!$stmtBooks) {
        die('Error preparing Books statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmtBooks, 's', $isbn);
    if (!mysqli_stmt_execute($stmtBooks)) {
        die('Error executing Books statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_close($stmtBooks);

    // Delete the entry in BookDetail.
    $sqlBooks = 'DELETE FROM BookDetail WHERE id = (SELECT bookDetails from Books where ISBN = ?);';
    $stmtBooks = mysqli_prepare($conn, $sqlBooks);
    
    if (!$stmtBooks) {
        die('Error preparing Books statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmtBooks, 's', $isbn);
    if (!mysqli_stmt_execute($stmtBooks)) {
        die('Error executing Books statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_close($stmtBooks);
}

function getALLISBNs() {
    global $conn;

    $sql = "SELECT ISBN FROM books GROUP BY ISBN;";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $ISBNs = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $ISBNs[] = array(
                    "ISBN" => $row['ISBN'],
                );
            }
            return $ISBNs;
        } else {
            return array(); // Return empty array if no ISBNs
        }
    } else {
        echo "Error in query: " . mysqli_error($conn);
        return array(); // Return empty array on error
    }
}

// Authors
function getAuthors() {
    global $conn;

    $sql = "SELECT id, firstName, lastName, biography FROM Authors";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $authors = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $authors[] = array(
                    'row' => 'authorBody',                    
                    "ID" => $row['id'],
                    "Name" => $row['lastName'] ? $row['firstName'] . ' ' . $row['lastName'] : $row['firstName'], // Handles cases where lastName is null
                    "Biography" => $row['biography']
                );
            }
            return $authors;
        } else {
            return array(); // Return empty array if no authors
        }
    } else {
        echo "Error in query: " . mysqli_error($conn);
        return array(); // Return empty array on error
    }
}

// Genre
function getGeners() {
    global $conn;

    $sql = "SELECT id, category FROM BookCategory";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $genres = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $genres[] = array(
                    "ID" => $row['id'],
                    "Name" => $row['category']
                );
            }
            return $genres;
        } else {
            return array(); // Return empty array if no genres
        }
    } else {
        echo "Error in query: " . mysqli_error($conn);
        return array(); // Return empty array on error
    }
}


function getAllBooks() {
    global $conn;

    $sql = "SELECT b.ISBN, bd.title, bd.cover_image, bd.publication_year, bd.description, bd.publisher, bd.copies_owned, bs.status, GROUP_CONCAT(DISTINCT a.firstName, ' ' , a.lastName SEPARATOR ', ') as authors, GROUP_CONCAT(DISTINCT bc.category SEPARATOR ', ') AS categories
            FROM Books b
            JOIN BookDetail bd ON b.bookDetails = bd.id
            JOIN BookStatus bs ON b.statusID = bs.id
            JOIN BookAuthor ba ON b.ISBN = ba.bookID
            JOIN Authors a ON ba.authorID = a.id
            JOIN BookGenre bg ON b.ISBN = bg.bookID
            JOIN BookCategory bc ON bg.categoryID = bc.id
            GROUP BY b.ISBN;";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $books = array();
            $bookData = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $isbn = $row['ISBN'];

                if (!isset($bookData[$isbn])) {
                    $bookData[$isbn] = array(
                        'row' => 'bookBody',
                        'card' => '',
                        "isbn" => $isbn,
                        "title" => $row['title'],
                        "bookCover" => $row['cover_image'],
                        "status" => $row['status'],
                        "description" => $row['description'],
                        "publicationyear" => $row['publication_year'],
                        "publisher" => $row['publisher'],
                        "copiesowned" => $row['copies_owned'],
                        "genre" => $row['categories'],
                        "author" => $row['authors']
                    );
                }
            }

            foreach ($bookData as $book) {
                //Structure the authors and genres into strings.
                $book['Authors'] = explode(', ', $book['author']);
                $book['Genres'] = explode(', ', $book['genre']);

                $books[] = $book;
            }

            return $books;
        } else {
            return array();
        }
    } else {
        echo "Error in query: " . mysqli_error($conn);
        return array();
    }
}

function getBook($ISBN) {
    global $conn;

    $searchTerm = $ISBN;

    $sql = "SELECT b.ISBN, bd.title, bd.cover_image, bd.publication_year, bd.description, bd.publisher, bd.copies_owned, bs.status, GROUP_CONCAT(DISTINCT a.firstName, ' ' , a.lastName, '|', a.id SEPARATOR ', ') as authors, GROUP_CONCAT(DISTINCT bc.category, '|', bc.id SEPARATOR ', ') AS categories
            FROM Books b
            JOIN BookDetail bd ON b.bookDetails = bd.id
            JOIN BookStatus bs ON b.statusID = bs.id
            JOIN BookAuthor ba ON b.ISBN = ba.bookID
            JOIN Authors a ON ba.authorID = a.id
            JOIN BookGenre bg ON b.ISBN = bg.bookID
            JOIN BookCategory bc ON bg.categoryID = bc.id
            WHERE b.ISBN = ?
            GROUP BY b.ISBN;
            ";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return array('success' => false, 'message' => 'Error preparing statement: ' . mysqli_error($conn), 'books' => array());
    }

    mysqli_stmt_bind_param($stmt, "s", $searchTerm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $books = array();
            $bookData = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $isbn = $row['ISBN'];

                if (!isset($bookData[$isbn])) {
                    $bookData[$isbn] = array(
                        'row' => 'bookBody',
                        'card' => '',
                        "isbn" => $isbn,
                        "title" => $row['title'],
                        "bookCover" => $row['cover_image'],
                        "status" => $row['status'],
                        "description" => $row['description'],
                        "publicationyear" => $row['publication_year'],
                        "publisher" => $row['publisher'],
                        "copiesowned" => $row['copies_owned'],
                        "genre" => $row['categories'],
                        "author" => $row['authors']
                    );
                }
            }

            foreach ($bookData as $book) {
                //Structure the authors and genres into strings.
                $book['Authors'] = explode(', ', $book['author']);
                $book['Genres'] = explode(', ', $book['genre']);

                $books[] = $book;
            }

            return array('success' => true, 'books' => $books);
        } else {
            return array('success' => true, 'books' => array()); // Return empty array if no results
        }
    } else {
        return array('success' => false, 'message' => 'Error executing query: ' . mysqli_error($conn), 'books' => array()); // Return empty array on error
    }
}

function searchBooks($searchTerm) {
    global $conn;

    $searchTerm = "%" . $searchTerm . "%"; // Add wildcards for LIKE search

    $sql = "SELECT b.ISBN, bd.title, bd.cover_image, bd.publication_year, bd.description, bd.publisher, bd.copies_owned, bs.status, GROUP_CONCAT(DISTINCT a.firstName, ' ' , a.lastName SEPARATOR ', ') as authors, GROUP_CONCAT(DISTINCT bc.category SEPARATOR ', ') AS categories
            FROM Books b
            JOIN BookDetail bd ON b.bookDetails = bd.id
            JOIN BookStatus bs ON b.statusID = bs.id
            JOIN BookAuthor ba ON b.ISBN = ba.bookID
            JOIN Authors a ON ba.authorID = a.id
            JOIN BookGenre bg ON b.ISBN = bg.bookID
            JOIN BookCategory bc ON bg.categoryID = bc.id
            WHERE b.ISBN LIKE ? OR bd.title LIKE ? OR bd.description LIKE ? OR a.firstName LIKE ? OR a.lastName LIKE ? OR bc.category LIKE ?
            GROUP BY b.ISBN;
            ";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return array('success' => false, 'message' => 'Error preparing statement: ' . mysqli_error($conn), 'books' => array());
    }

    mysqli_stmt_bind_param($stmt, "ssssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $books = array();
            $bookData = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $isbn = $row['ISBN'];

                if (!isset($bookData[$isbn])) {
                    $bookData[$isbn] = array(
                        'row' => 'bookBody',
                        'card' => '',
                        "isbn" => $isbn,
                        "title" => $row['title'],
                        "bookCover" => $row['cover_image'],
                        "status" => $row['status'],
                        "description" => $row['description'],
                        "publicationyear" => $row['publication_year'],
                        "publisher" => $row['publisher'],
                        "copiesowned" => $row['copies_owned'],
                        "genre" => $row['categories'],
                        "author" => $row['authors']
                    );
                }
            }

            foreach ($bookData as $book) {
                //Structure the authors and genres into strings.
                $book['Authors'] = explode(', ', $book['author']);
                $book['Genres'] = explode(', ', $book['genre']);

                $books[] = $book;
            }

            return array('success' => true, 'books' => $books);
        } else {
            return array('success' => true, 'books' => array()); // Return empty array if no results
        }
    } else {
        return array('success' => false, 'message' => 'Error executing query: ' . mysqli_error($conn), 'books' => array()); // Return empty array on error
    }
}

function getBooksByCategoryIds(array $categoryIds) {
    global $conn;
  
    // Sanitize the input to prevent SQL injection
    $sanitizedCategoryIds = array_map('intval', $categoryIds);
    $categoryIdsString = implode(',', $sanitizedCategoryIds);
  
    $sql = "SELECT b.ISBN, bd.title, bd.cover_image, bd.publication_year, bd.description, bd.publisher, bd.copies_owned, bs.status, GROUP_CONCAT(DISTINCT a.firstName, ' ' , a.lastName SEPARATOR ', ') as authors, GROUP_CONCAT(DISTINCT bc.category SEPARATOR ', ') AS categories
            FROM Books b
            JOIN BookDetail bd ON b.bookDetails = bd.id
            JOIN BookStatus bs ON b.statusID = bs.id
            JOIN BookAuthor ba ON b.ISBN = ba.bookID
            JOIN Authors a ON ba.authorID = a.id
            JOIN BookGenre bg ON b.ISBN = bg.bookID
            JOIN BookCategory bc ON bg.categoryID = bc.id
            WHERE bg.categoryID IN (" . $categoryIdsString . ")
            GROUP BY b.ISBN;";
  
    $result = $conn->query($sql);
  
    if ($result) {
      if (mysqli_num_rows($result) > 0) {
          $books = array();
          $bookData = array();
  
          while ($row = mysqli_fetch_assoc($result)) {
              $isbn = $row['ISBN'];
  
              if (!isset($bookData[$isbn])) {
                  $bookData[$isbn] = array(
                      'row' => 'bookBody',
                      'card' => '',
                      "isbn" => $isbn,
                      "title" => $row['title'],
                      "bookCover" => $row['cover_image'],
                      "status" => $row['status'],
                      "description" => $row['description'],
                      "publicationyear" => $row['publication_year'],
                      "publisher" => $row['publisher'],
                      "copiesowned" => $row['copies_owned'],
                      "genre" => $row['categories'],
                      "author" => $row['authors']
                  );
              }
          }
  
          foreach ($bookData as $book) {
              //Structure the authors and genres into strings.
              $book['Authors'] = explode(', ', $book['author']);
              $book['Genres'] = explode(', ', $book['genre']);
  
              $books[] = $book;
          }
  
          return array('success' => true, 'books' => $books);
      } else {
          return array('success' => true, 'books' => array()); // Return empty array if no results
      }
  } else {
      return array('success' => false, 'message' => 'Error executing query: ' . mysqli_error($conn), 'books' => array()); // Return empty array on error
  }
}

function getBooksByAuthorIds(array $authorIDs) {
    global $conn;
  
    // Sanitize the input to prevent SQL injection
    $sanitizedAuthorIds = array_map('intval', $authorIDs);
    $authorIdsString = implode(',', $sanitizedAuthorIds);
  
    $sql = "SELECT b.ISBN, bd.title, bd.cover_image, bd.publication_year, bd.description, bd.publisher, bd.copies_owned, bs.status, GROUP_CONCAT(DISTINCT a.firstName, ' ' , a.lastName SEPARATOR ', ') as authors, GROUP_CONCAT(DISTINCT bc.category SEPARATOR ', ') AS categories
            FROM Books b
            JOIN BookDetail bd ON b.bookDetails = bd.id
            JOIN BookStatus bs ON b.statusID = bs.id
            JOIN BookAuthor ba ON b.ISBN = ba.bookID
            JOIN Authors a ON ba.authorID = a.id
            JOIN BookGenre bg ON b.ISBN = bg.bookID
            JOIN BookCategory bc ON bg.categoryID = bc.id
            WHERE ba.authorID IN (" . $authorIdsString . ")
            GROUP BY b.ISBN;";
  
    $result = $conn->query($sql);
  
    if ($result) {
      if (mysqli_num_rows($result) > 0) {
          $books = array();
          $bookData = array();
  
          while ($row = mysqli_fetch_assoc($result)) {
              $isbn = $row['ISBN'];
  
              if (!isset($bookData[$isbn])) {
                  $bookData[$isbn] = array(
                      'row' => 'bookBody',
                      'card' => '',
                      "isbn" => $isbn,
                      "title" => $row['title'],
                      "bookCover" => $row['cover_image'],
                      "status" => $row['status'],
                      "description" => $row['description'],
                      "publicationyear" => $row['publication_year'],
                      "publisher" => $row['publisher'],
                      "copiesowned" => $row['copies_owned'],
                      "genre" => $row['categories'],
                      "author" => $row['authors']
                  );
              }
          }
  
          foreach ($bookData as $book) {
              //Structure the authors and genres into strings.
              $book['Authors'] = explode(', ', $book['author']);
              $book['Genres'] = explode(', ', $book['genre']);
  
              $books[] = $book;
          }
  
          return array('success' => true, 'books' => $books);
      } else {
          return array('success' => true, 'books' => array()); // Return empty array if no results
      }
  } else {
      return array('success' => false, 'message' => 'Error executing query: ' . mysqli_error($conn), 'books' => array()); // Return empty array on error
  }
}

function addAuthor($firstName, $lastName = null, $biography = null) {
    global $conn;

    $sql = "INSERT INTO Authors (firstName, lastName, biography) VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return array('success' => false, 'message' => 'Error preparing statement: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "sss", $firstName, $lastName, $biography);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return array('success' => true, 'message' => 'Author added successfully.');
    } else {
        mysqli_stmt_close($stmt);
        return array('success' => false, 'message' => 'Error executing statement: ' . mysqli_error($conn));
    }
}

function updateAuthor($id, $firstName, $lastName = null, $biography = null) {
    global $conn;

    // 1. Update Author
    $sqlDetail = 'UPDATE authors
                    SET
                    firstName = ?,
                    lastName = ?,
                    biography = ?
                    WHERE id = ?;';
    $stmtDetail = mysqli_prepare($conn, $sqlDetail);

    if (!$stmtDetail) {
        die('Error preparing AuthorDetail statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmtDetail, 'ssss', $firstName, $lastName, $biography, $id);
    
    if (!mysqli_stmt_execute($stmtDetail)) {
        die('Error executing AuthorDetail statement: ' . mysqli_error($conn));
    }

    $authorDetailID = mysqli_insert_id($conn);
    mysqli_stmt_close($stmtDetail);
}

function searchAuthors($searchTerm) {
    global $conn;

    $searchTerm = "%" . $searchTerm . "%"; // Add wildcards for LIKE search

    $sql = "SELECT ID, GROUP_CONCAT(firstName, ' ' ,lastName SEPARATOR ' ') AS Name, biography AS Biography FROM authors
            WHERE ID LIKE ? OR firstName LIKE ? OR lastName LIKE ? OR biography LIKE ?
            GROUP BY ID;";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return array('success' => false, 'message' => 'Error preparing statement: ' . mysqli_error($conn), 'books' => array());
    }

    mysqli_stmt_bind_param($stmt, "ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $authors = array();
            $authorData = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['ID'];

                if (!isset($authorData[$id])) {
                    $authorData[$id] = array(
                        'row' => 'authorBody',
                        'ID' => $row['ID'],
                        'Name' => $row['Name'],
                        'Biography' => $row['Biography']
                    );
                }
            }
            $authors = $authorData;

            return array('success' => true, 'authors' => $authors);
        } else {
            return array('success' => true, 'authors' => array()); // Return empty array if no results
        }
    } else {
        return array('success' => false, 'message' => 'Error executing query: ' . mysqli_error($conn), 'authors' => array()); // Return empty array on error
    }
}

function getAuthor($id) {
    global $conn;

    $searchTerm = $id;

    $sql = "SELECT ID, firstName, lastName, biography AS Biography FROM authors WHERE id = ?;";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return array('success' => false, 'message' => 'Error preparing statement: ' . mysqli_error($conn), 'books' => array());
    }

    mysqli_stmt_bind_param($stmt, "s", $searchTerm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $authors = array();
            $authorData = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $ID = $row['ID'];

                if (!isset($authorData[$ID])) {
                    $authorData[$ID] = array(
                        'ID' => $row['ID'],
                        'firstName' => $row['firstName'],
                        'lastName' => $row['lastName'],
                        'Biography' => $row['Biography']
                    );
                }
            }

            $authors = $authorData;

            return array('success' => true, 'authors' => $authors);
        } else {
            return array('success' => true, 'authors' => array()); // Return empty array if no results
        }
    } else {
        return array('success' => false, 'message' => 'Error executing query: ' . mysqli_error($conn), 'authors' => array()); // Return empty array on error
    }
}

function getuser($username, $id = null) {
    global $conn;

    if ($id) {  // Get User by id

        $searchTerm = $id;

        $sql = "SELECT u.statusID statusID, u.roleID roleID, u.detailsID detailID, ud.id id, ud.username username, ud.firstName firstName, ud.lastName lastName, ud.joinedDate joinedDate, ud.password password
            FROM users AS u
            JOIN userdetail AS ud ON u.detailsID = ud.id
            WHERE u.id = ?;";
    } else {  // Get User by username

    $searchTerm = $username;

    $sql = "SELECT u.statusID statusID, u.roleID roleID, u.detailsID detailID, ud.id id, ud.username username, ud.firstName firstName, ud.lastName lastName, ud.joinedDate joinedDate, ud.password password
            FROM Users AS u
            JOIN UserDetail AS ud ON u.detailsID = ud.id
            WHERE username = ?;";
    }


    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return array('success' => false, 'message' => 'Error preparing statement: ' . mysqli_error($conn), 'books' => array());
    }

    mysqli_stmt_bind_param($stmt, "s", $searchTerm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $users = array();
            $userData = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];

                if (!isset($userData[$id])) {
                    $userData[$id] = array(
                        'statusID' => $row['statusID'],
                        'roleID' => $row['roleID'],
                        'detailID' => $row['detailID'],
                        'id' => $row['id'],
                        'username' => $row['username'],
                        'firstName' => $row['firstName'],
                        'lastName' => $row['lastName'],
                        'joinedDate' => $row['joinedDate'],
                        'password' => $row['password']
                    );
                }
            }

            $users = $userData;

            return array('success' => true, 'users' => $users);
        } else {
            return array('success' => true, 'users' => array()); // Return empty array if no results
        }
    } else {
        return array('success' => false, 'message' => 'Error executing query: ' . mysqli_error($conn), 'users' => array()); // Return empty array on error
    }
}

function checkUsernameExists($username) {
    global $conn; // Assuming you have a global database connection
    $count = 0;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM UserDetail WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    return $count > 0;
}

function addUserDetail($username, $firstName, $lastName, $hashedPassword) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO UserDetail (username, firstName, lastName, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $firstName, $lastName, $hashedPassword);
    $stmt->execute();
    $newUserDetailID = $conn->insert_id;
    $stmt->close();
    return $newUserDetailID;
}

function addUser($roleID, $detailsID) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO Users (roleID, detailsID) VALUES (?, ?)");
    $stmt->bind_param("ii", $roleID, $detailsID);
    $stmt->execute();
    $success = $stmt->affected_rows > 0;
    $stmt->close();
    return $success;
}

function getUsers() {
    global $conn;
    $sql = "SELECT ud.id id, ud.username username, ud.firstName firstName, ud.lastName lastName, ud.joinedDate joinedDate, us.status userStatus 
            FROM UserDetail ud 
             JOIN Users u ON ud.id = u.detailsID 
            JOIN UserStatus us ON u.statusID = us.id 
            ORDER BY ud.joinedDate DESC;";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $authors = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $authors[] = array(
                    'row' => 'userBody',                    
                    "ID" => $row['id'],
                    "username" => $row['username'],
                    "Name" => $row['lastName'] ? $row['firstName'] . ' ' . $row['lastName'] : $row['firstName'], // Handles cases where lastName is null
                    "userStatus" => $row['userStatus'],
                    'joinedDate' => $row['joinedDate']
                );
            }
            return $authors;
        } else {
            return array(); // Return empty array if no authors
        }
    } else {
        echo "Error in query: " . mysqli_error($conn);
        return array(); // Return empty array on error
    }
}

function searchUsers($searchTerm) {
    global $conn;
    
    $searchTerm = "%" . $searchTerm . "%";
    $sql = "SELECT ud.id id, ud.username username, ud.firstName firstName, ud.lastName lastName, ud.joinedDate joinedDate, us.status userStatus
    FROM UserDetail ud 
    JOIN Users u ON ud.id = u.detailsID 
    JOIN UserStatus us ON u.statusID = us.id 
    WHERE ud.username LIKE ? OR ud.firstName LIKE ? OR ud.lastName LIKE ? ORDER BY ud.joinedDate DESC";
    
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return array('success' => false, 'message' => 'Error preparing statement: ' . mysqli_error($conn), 'books' => array());
    }

    mysqli_stmt_bind_param($stmt, "sss", $searchTerm, $searchTerm, $searchTerm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $users = array();
            $userData = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];

                if (!isset($userData[$id])) {
                    $userData[$id] = array(
                        'row' => 'userBody',                    
                        "ID" => $row['id'],
                        "username" => $row['username'],
                        "Name" => $row['lastName'] ? $row['firstName'] . ' ' . $row['lastName'] : $row['firstName'], // Handles cases where lastName is null
                        "userStatus" => $row['userStatus'],
                        'joinedDate' => $row['joinedDate']
                    );
                }
            }
            $users = $userData;

            return array('success' => true, 'users' => $users);
        } else {
            return array('success' => true, 'users' => array()); // Return empty array if no results
        }
    } else {
        return array('success' => false, 'message' => 'Error executing query: ' . mysqli_error($conn), 'users' => array()); // Return empty array on error
    }
}

// Add this function for updating User Status
function updateUser($id, $username, $firstName, $lastName, $joinedDate, $statusID, $roleID) {
    global $conn;

    // 1. Update User Details
    $sqlDetail = 'UPDATE userdetail
                    SET
                    username = ?,
                    firstName = ?,
                    lastName = ?,
                    joinedDate = ?
                    WHERE id = ?;';
    $stmtDetail = mysqli_prepare($conn, $sqlDetail);

    if (!$stmtDetail) {
        die('Error preparing UserDetail statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmtDetail, 'sssss', $username, $firstName, $lastName, $joinedDate, $id);
    
    if (!mysqli_stmt_execute($stmtDetail)) {
        die('Error executing UserDetail statement: ' . mysqli_error($conn));
    }

    $userDetailID = mysqli_insert_id($conn);
    mysqli_stmt_close($stmtDetail);


    // 2. Update Status and Role
    $sqlUsers = 'UPDATE users SET  roleID = ?, statusID = ? WHERE id = ?;';
    $stmtUsers = mysqli_prepare($conn, $sqlUsers);
    
    if (!$stmtUsers) {
        die('Error preparing Users statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmtUsers, 'sss', $roleID, $statusID, $id);
    if (!mysqli_stmt_execute($stmtUsers)) {
        die('Error executing Users statement: ' . mysqli_error($conn));
    }
    mysqli_stmt_close($stmtUsers);
}

// MAIN
$books = getAllBooks();
$authors = getAuthors();
$genres = getGeners();


if (isset($_GET['book_count']) && $_GET['book_count'] == 'all-books') {
    print_r(searchBooks("192-168-1-1")['books']);
}

if (isset($_GET['book_count']) && $_GET['book_count'] == 'all-books') {
    echo count($books);
} else if (isset($_GET['searched-books']) && $_GET['searched-books'] == 'searched-books') {
    $searchTerm = $_GET['search_term'];
    $searchData = searchBooks($searchTerm);
    echo $_GET['search_term'];
    echo count($searchData['books']);
}