<link rel="stylesheet" href="CSS/reset.css">
<link rel="stylesheet" href="CSS/Actions.css">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
 
<?php
function Actions(array $atts) {
    if (!isset($atts['actions'])) {
        return;
    }

    if (isset($atts['actions'])) {
        if (!isset($atts['edit'])) {
            $edit = true;
        } else {$edit = $atts['edit'];}
        if (!isset($atts['delete'])) {
            $delete = true;
        } else {$delete = $atts['delete'];}
        if (!isset($atts['view'])) {
            $view = true;
        } else {$view = $atts['view'];}
        $result = [];
        $ISBN = $atts['isbn'];

        if ($edit == true) {
            $result[] = '
            <div class="edit action" title="Edit book" data-isbn=' . $ISBN . ' onclick="redirectToEdit(this)">
                <span class="material-symbols-outlined">
                    edit_square
                </span>
            </div>
            ';
        }
        if ($delete == true) {
            $result[] = '
        <div class="delete action" title="Delete book" data-isbn=' . $ISBN . ' onclick="redirectToDelete(this)">
            <span class="material-symbols-outlined">
                delete
            </span>
        </div>
            ';
        }
        if ($view == true) {
            $result[] = '
        <div class="view action" title="View book details" data-isbn=' . $ISBN . ' onclick="redirectToView(this)">
            <span class="material-symbols-outlined">
                visibility
            </span>
        </div>            
            ';
        }

        return $result;
    }
}
?>