<?php
require_once "../../Data/dbFunctions.inc.php";

$isbn = $_GET['ISBN'];

deleteBook($isbn);

// Add to Warehouse
// mysqli_close($conn);
// require_once "../../Data/warehousecon.inc.php";

// function addBookToWArehouse($isbn, $authorIDs, $title, $publicationYear, $coverImage, $description, $publisher, $copiesOwned, $genreIDs) {
//     global $whConn;

//     // 1. Insert into BookDetail
//     $sqlDetail = 'INSERT INTO BookDetail (title, publication_year, cover_image, description, publisher, copies_owned) VALUES (?, ?, ?, ?, ?, ?)';
//     $stmtDetail = mysqli_prepare($whConn, $sqlDetail);
//     if (!$stmtDetail) {
//         die('Error preparing BookDetail statement: ' . mysqli_error($whConn));
//     }
//     mysqli_stmt_bind_param($stmtDetail, 'ssssss', $title, $publicationYear, $coverImage, $description, $publisher, $copiesOwned);
//     if (!mysqli_stmt_execute($stmtDetail)) {
//         die('Error executing BookDetail statement: ' . mysqli_error($whConn));
//     }
//     $bookDetailID = mysqli_insert_id($whConn);
//     mysqli_stmt_close($stmtDetail);
//     $status = 2;
//     if ($copiesOwned > 0) {
//         $status = 1;
//     }

//     // 2. Insert into Books
//     $sqlBooks = 'INSERT INTO Books (ISBN, bookDetails, statusID) VALUES (?, ?, ?)';
//     $stmtBooks = mysqli_prepare($whConn, $sqlBooks);
//     if (!$stmtBooks) {
//         die('Error preparing Books statement: ' . mysqli_error($whConn));
//     }
//     mysqli_stmt_bind_param($stmtBooks, 'sii', $isbn, $bookDetailID, $status);
//     if (!mysqli_stmt_execute($stmtBooks)) {
//         die('Error executing Books statement: ' . mysqli_error($whConn));
//     }
//     mysqli_stmt_close($stmtBooks);

//     // 3. Insert into BookAuthor (Loop through authorIDs)
//     $authorIdArray = explode(',', $authorIDs);
//     foreach ($authorIdArray as $authorId) {
//         $authorId = trim($authorId);
//         $sqlAuthor = 'INSERT INTO BookAuthor (bookID, authorID) VALUES (?, ?)';
//         $stmtAuthor = mysqli_prepare($whConn, $sqlAuthor);
//         if (!$stmtAuthor) {
//             die('Error preparing BookAuthor statement: ' . mysqli_error($whConn));
//         }
//         mysqli_stmt_bind_param($stmtAuthor, 'si', $isbn, $authorId);
//         if (!mysqli_stmt_execute($stmtAuthor)) {
//             die('Error executing BookAuthor statement: ' . mysqli_error($whConn));
//         }
//         mysqli_stmt_close($stmtAuthor);
//     }

//     // 4. Insert into BookGenre (Loop through genreIDs)
//     $genreIdArray = explode(',', $genreIDs);
//     foreach ($genreIdArray as $genreId) {
//         $genreId = trim($genreId);

//         // Insert the BookGenre relationship
//         $sqlBookGenre = 'INSERT INTO BookGenre (bookID, categoryID) VALUES (?, ?)';
//         $stmtBookGenre = mysqli_prepare($whConn, $sqlBookGenre);
//         if (!$stmtBookGenre) {
//             die('Error preparing BookGenre statement: ' . mysqli_error($whConn));
//         }
//         mysqli_stmt_bind_param($stmtBookGenre, 'si', $isbn, $genreId);
//         if (!mysqli_stmt_execute($stmtBookGenre)) {
//             die('Error executing BookGenre statement: ' . mysqli_error($whConn));
//         }
//         mysqli_stmt_close($stmtBookGenre);
//     }
// }

// // Add the book to the warehouse
// addBookToWArehouse($isbn, $authorIDs, $title, $publicationYear, $coverImage, $description, $publisher, $copiesOwned, $categories);
// mysqli_close($whConn);
// echo "Successfully Added To Warehouse";
// 
header('location: ../../../index.php?popup=success&message=2');
?>