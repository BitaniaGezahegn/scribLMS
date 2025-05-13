<?php
require_once '../../Data/dbFunctions.inc.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location: ../../../Users.php?popup=error&message=unauthorized');
    exit();
}

function isValidISBN($isbn) {
    // Remove hyphens and spaces
    $isbn = str_replace(['-', ' '], '', $isbn);

    // Check length and format
    if (strlen($isbn) == 10) {
        // ISBN-10 validation
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            if (!is_numeric($isbn[$i])) {
                return false;
            }
            $sum += (int)$isbn[$i] * (10 - $i);
        }
        $last = $isbn[9];
        if ($last == 'X') {
            $sum += 10;
        } elseif (is_numeric($last)) {
            $sum += (int)$last;
        } else {
            return false;
        }
        return ($sum % 11 == 0);
    } elseif (strlen($isbn) == 13) {
        // ISBN-13 validation
        $sum = 0;
        for ($i = 0; $i < 13; $i++) {
            if (!is_numeric($isbn[$i])) {
                return false;
            }
            $multiplier = ($i % 2 == 0) ? 1 : 3;
            $sum += (int)$isbn[$i] * $multiplier;
        }
        return ($sum % 10 == 0);
    } else {
        return false;
    }
}

// Sanitize and validate ALL inputs.
$title = htmlspecialchars($_POST['Title']);
$coverImage = htmlspecialchars($_POST['CoverImage']);
$publicationYear = filter_input(INPUT_POST, 'PublicationYear', FILTER_VALIDATE_INT);
$description = htmlspecialchars($_POST['Description']);
$publisher = htmlspecialchars($_POST['Publisher']);
$copiesOwned = filter_input(INPUT_POST, 'CopiesAvailable', FILTER_VALIDATE_INT);

$authorIDs =  implode(',' ,$_POST['Authors']);
if (!empty($authorIDs)) {
  $authorIDs = implode(',', array_map('intval', explode(',', $authorIDs))); //Sanitize author IDs
}


$categories =  implode(',' ,$_POST['Geners']);
if (!empty($categories)) {
  $categories = implode(',', array_map('intval', explode(',', $categories))); //Sanitize category IDs
}


$isbn = htmlspecialchars($_POST['ISBN']);
if (empty($isbn) || !isValidISBN($isbn)) { // Add isValidISBN function
    // header('location: ../../../index.php?popup=error&message=invalid_isbn');
    $postData = [
        'Title' => $title,
        'CoverImage' => $coverImage,
        'PublicationYear' => $publicationYear,
        'Description' => $description,
        'Publisher' => $publisher,
        'CopiesAvailable' => $copiesOwned,
        'Authors' => $_POST['Authors'],
        'Geners' => $_POST['Geners']
    ];

    $url = '../../../Add_Book.php?popup=error&message=invalid_isbn';

    echo '<form id="redirectForm" method="post" action="' . $url . '">';
    foreach ($postData as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $item) {
                echo '<input type="hidden" name="' . $key . '[]" value="' . htmlspecialchars($item) . '">';
            }
        } else {
            echo '<input type="hidden" name="' . $key . '" value="' . htmlspecialchars($value) . '">';
        }
    }
    echo '</form>';
    echo '<script type="text/javascript">document.getElementById("redirectForm").submit();</script>';

    exit;
}



// Use prepared statements in your addBook function (in dbFunctions.inc.php) to prevent SQL injection.


addBook($isbn, $authorIDs, $title, $publicationYear, $coverImage, $description, $publisher, $copiesOwned, $categories);
header('location: ../../../index.php?popup=success&message=1');
?>
