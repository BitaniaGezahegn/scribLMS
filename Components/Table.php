<link rel="stylesheet" href="Components/CSS/reset.css">
<link rel="stylesheet" href="Components/CSS/Table.css">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
 
<?php
require_once 'subComponents/Row.php';

function Table(array $atts) {
    if (!isset($atts['table'])) {
        return;
    }


    if (empty($atts['rows'])) {
        return [["<h1>No records found.</h1>"], []];
    }

    if ($atts['table'] == 'books') {
        $thead = [];
        $tbody = [];
        // Table Head
        foreach (Row(atts: [
            'row' => 'bookHead'
            ]) as $key => $value) {
            $thead[] = $value;
        }
        // Table Body
        foreach ($atts['rows'] as $key => $value) {
            $tbody[] = Row(atts: $value); // Render Rows
        }
        return ([$thead, $tbody]);
    } else if ($atts['table'] == 'authors') {
        $thead = [];
        $tbody = [];
        // Author Head
        foreach (Row(atts: [
            'row' => 'authorHead'
            ]) as $key => $value) {
            $thead[] = $value;
        }
        // Author Body
        foreach ($atts['rows'] as $key => $value) {
            $tbody[] = Row(atts: $value); // Render Rows
        }
        return ([$thead, $tbody]);
    } else if ($atts['table'] == 'users') {
        $thead = [];
        $tbody = [];
        // User Head
        foreach (Row(atts: [
            'row' => 'userHead'
            ]) as $key => $value) {
                
            $thead[] = $value;
        }
        // User Body
        foreach ($atts['rows'] as $key => $value) {
            $tbody[] = Row(atts: $value); // Render Rows
        }
        return ([$thead, $tbody]);
    }
}
?>