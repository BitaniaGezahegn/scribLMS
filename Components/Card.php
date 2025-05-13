<link rel="stylesheet" href="Components/CSS/reset.css">
<link rel="stylesheet" href="Components/CSS/Card.css">
<!-- <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" /> -->
 
<?php
function Card(array $atts) {
    if (!isset($atts['card'])) {
        return;
    }
    
    $ISBN = $atts['isbn'];
    $title = $atts['title'];
    $genre = $atts['genre'];
    $bookCover = $atts['bookCover'];
    $author = $atts['author'];
    $status = $atts['status'];
    $description = $atts['description'];
    
    return ('
<div class="card">
    <div class="top-section">
        <h4>' . $title . '</h4>
        <p class="sub">' . $genre . '</p>
    </div>

    <img src="' . $bookCover . '">

    <div class="bottom-section">
        <div class="author-bookstatus">
            <p class="author"><span class="by">by </span>' . $author . '</p>
            <div class="status ' . $status . '">
                <span></span>
            </div>
        </div>
        <div class="description">
            <p class="sub">' . $description . '</p>
        </div>
        <div class="action-buttons">
            <div class="edit action" title="Edit book" data-isbn=' . $ISBN . ' onclick="redirectToEdit(this)">
                <span class="material-symbols-outlined">
                    edit_square
                </span>
            </div>
            <div class="delete action" title="Delete book" data-isbn=' . $ISBN . ' onclick="redirectToDelete(this)">
                <span class="material-symbols-outlined">
                    delete
                </span>
            </div>
            <div class="view action" title="View book details" data-isbn=' . $ISBN . ' onclick="redirectToView(this)">
                <span class="material-symbols-outlined">
                    visibility
                </span>
            </div>
        </div>

    </div>
</div>
<script src="Components/JS/Card.js"></script>
    ');
}
?>