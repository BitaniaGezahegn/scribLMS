<?php
require_once '../Includes/Data/dbcon.inc.php';

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

function exportBooksToCSV($filePath) {
    $books = getAllBooks();
    if (!empty($books)) {
        $file = fopen($filePath, 'w');
        if ($file === false) {
            die("Error opening the file " . $filePath);
        } 

        $header = array('id', 'ISBN', 'Title', 'Authors', 'Description', 'Publication Year', 'Publisher', 'Copies Owned', 'Genre', 'Status', 'Cover Image');
        fputcsv($file, $header);

        $id = 1;
        foreach ($books as $book) {
            $authors = implode(', ', $book['Authors']);
            $coverImage = $book['bookCover'];
            $genres = implode(', ', $book['Genres']);

            $csvRow = array(
                $id,
                $book['isbn'] ?? '',
                $book['title'] ?? '',
                $authors ?? '',
                $book['description'] ?? '',
                $book['publicationyear'] ?? '',
                $book['publisher'] ?? '',
                $book['copiesowned'] ?? '',
                $genres ?? '',
                $book['status'] ?? '',
                $coverImage ?? ''
            );

            fputcsv($file, $csvRow);
            $id++;
        }

        fclose($file);
        echo "Data exported to CSV successfully!";
    } else {
        echo "No books found to export.";
    }
}

// Example usage:
$csvFilePath = 'sampleBooks.csv';
// exportBooksToCSV($csvFilePath);


function getCSVData($filePath, $delimiter = ',', $enclosure = '"', $escape = '\\') {
    $data = [];
    if (($handle = fopen($filePath, "r")) !== FALSE) {
        $header = fgetcsv($handle, 0, $delimiter, $enclosure, $escape);
        while (($row = fgetcsv($handle, 0, $delimiter, $enclosure, $escape)) !== FALSE) {
            if (count($header) == count($row)) {
                $data[] = array_combine($header, $row);
            } else {
                echo "Warning: Mismatched header and row count. Skipping row.<br>";
            }
        }
        fclose($handle);
    }
    return $data;
}

function displayCSVData($filePath) {
    $data = getCSVData($filePath);
    if (!empty($data)) {
        echo "<table border='1'>";
        echo "<thead><tr>";
        foreach (array_keys($data[0]) as $header) {
            echo "<th>" . htmlspecialchars($header) . "</th>";
        }
        echo "</tr></thead>";
        echo "<tbody>";
        foreach ($data as $row) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "No data found in the CSV file.";
    }
}

$csvFilePath = 'sampleBooks.csv'; 
displayCSVData($csvFilePath);

// print_r(getCSVData($csvFilePath)[0]['ISBN']);
foreach (getCSVData($csvFilePath) as $key => $value) {
    $isbn = $value['ISBN'] ?? '';
    $title = $value['Title'] ?? '';
    $coverImage = $value['Cover Image'] ?? '';
    $publicationYear = $value['Publication Year'] ?? '';
    $description = $value['Description'] ?? '';
    $publisher = $value['Publisher'] ?? '';
    $copiesOwned = $value['Copies Owned'] ?? '';
    $authorIDs = $value['Authors'] ?? [];
    $categories = $value['Genre'] ?? [];

    addBook($isbn, $authorIDs, $title, $publicationYear, $coverImage, $description, $publisher, $copiesOwned, $categories);
}
?>
