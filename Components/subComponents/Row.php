<link rel="stylesheet" href="Components/CSS/reset.css">
<link rel="stylesheet" href="Components/CSS/Actions.css">
<link rel="stylesheet" href="Components/CSS/Row.css">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
 
<?php
function Data(array $atts) {
    if (!isset($atts['Data'])) {
        return;
    }
    if ($atts['Data'] == 'head') {
        $beforeIcon = $atts['beforeIcon'];
        $afterIcon = $atts['afterIcon'];
        $th = $atts['th'];

        return ('
    <th>
        <div>
            <h4>
                <span class="material-symbols-outlined">' . $beforeIcon . '</span>
                ' . $th . '
                <span class="material-symbols-outlined">' . $afterIcon . '</span>
            </h4>
        </div>
    </th>    
        ');
    } else if ($atts['Data'] == 'body') {
        $h4 = $atts['h4'];
        $p = $atts['p'];
        $h4Classes = $atts['h4Classes'];
        $pClasses = $atts['pClasses'];
        return ('
<td>
    <h4 class="' . $h4Classes . '">' . $h4 . '</h4>
    <p class="sub ' . $pClasses . '">' . $p . '</p>
</td>
        ');
    } else if ($atts['Data'] == 'actions' && $atts['type'] == 'book') {
        $ISBN = $atts['isbn'];
        return (
            '
<td class="actions">
    <div>
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
</td>
            '
        );
    } elseif ($atts['Data'] == 'actions' && $atts['type'] == 'author') {
        $ID = $atts['id'];
        return (
            '
<td class="actions">
    <div>
        <div class="edit action" title="Edit author\'s details" data-id=' . $ID . ' onclick="redirectToEdit(this)">
            <span class="material-symbols-outlined">
                edit_square
            </span>
        </div>
    </div>
</td>
            '
        );
    } elseif ($atts['Data'] == 'actions' && $atts['type'] == 'user') {
        $ID = $atts['id'];
        return (
            '
<td class="actions">
    <div>
        <div class="edit action" title="Edit user\'s details" data-id=' . $ID . ' onclick="redirectToEdit(this)">
            <span class="material-symbols-outlined">
                edit_square
            </span>
        </div>
    </div>
</td>
            '
        );
    }
}
?>
<?php

function Row(array $atts) {
    if (!isset($atts['row'])) {
        return;
    }

    if ($atts['row'] == 'bookHead') {
        $headtr = []; 
        $heads = [
            ['', 'ISBN', ''],
            ['menu_book', 'Title', ''],
            ['status-indicator', 'Title', ''],
            ['', 'Actions', ''],
        ];
    

        foreach ($heads as $key => $value) {
            $bIcon =  $value[0];
            $th =  $value[1];
            $aIcon = $value[2];

            $headtr[] = Data(
                atts: [
                    'Data' => 'head',
                    'beforeIcon' => $bIcon,
                    'afterIcon' => $aIcon,
                    'th' => $th
                    ]
                );
            }
        return $headtr;
    } else if ($atts['row'] == 'bookBody') {
        $bodytr = [];
        $ISBN = $atts['isbn'];
        $Title = $atts['title'];
        $Author = $atts['author'];
        $Status = $atts['status'];
        
        $bodytr[] = Data(atts: [
            'Data' => 'body',
            'h4' => '',
            'p' => $ISBN,
            'h4Classes' => '',
            'pClasses' => ''
        ]);
        $bodytr[] = Data(atts: [
            'Data' => 'body',
            'h4' => $Title,
            'p' => $Author,
            'h4Classes' => '',
            'pClasses' => ''
        ]);
        $bodytr[] = Data(atts: [
            'Data' => 'body',
            'h4' => '<span></span><p class="sub">' . $Status .'</p>',
            'p' => '',
            'h4Classes' => 'status-container ' . $Status,
            'pClasses' => ''
        ]);
        $bodytr[] = Data(atts: [
            'Data' => 'actions',
            'isbn' => $ISBN,
            'type' => 'book'
        ]);
        return $bodytr;
    }



    // Author Rows
    if ($atts['row'] == 'authorHead') {
        $headtr = []; 
        $heads = [
            ['', 'ID', ''],
            ['', 'Name', ''],
            ['', 'Biography', ''],
            ['', 'Actions', ''],
        ];
    

        foreach ($heads as $key => $value) {
            $bIcon =  $value[0];
            $th =  $value[1];
            $aIcon = $value[2];

            $headtr[] = Data(
                atts: [
                    'Data' => 'head',
                    'beforeIcon' => $bIcon,
                    'afterIcon' => $aIcon,
                    'th' => $th
                    ]
                );
            }
        return $headtr;
    } else if ($atts['row'] == 'authorBody') {
        $bodytr = [];
        $ID = $atts['ID'];
        $Name = $atts['Name'];
        $Biography = $atts['Biography'];
        
        $bodytr[] = Data(atts: [
            'Data' => 'body',
            'h4' => '',
            'p' => $ID,
            'h4Classes' => '',
            'pClasses' => ''
        ]);
        $bodytr[] = Data(atts: [
            'Data' => 'body',
            'h4' => $Name,
            'p' => '',
            'h4Classes' => '',
            'pClasses' => ''
        ]);
        $bodytr[] = Data(atts: [
            'Data' => 'body',
            'h4' => '<span></span><p class="sub">' . $Biography .'</p>',
            'p' => '',
            'h4Classes' => 'status-container ' . $Biography,
            'pClasses' => ''
        ]);
        $bodytr[] = Data(atts: [
            'Data' => 'actions',
            'id' => $ID,
            'type' => 'author'
        ]);
        return $bodytr;
    }

        // Author Rows
    if ($atts['row'] == 'authorHead') {
        $headtr = []; 
        $heads = [
            ['', 'ID', ''],
            ['', 'Name', ''],
            ['', 'Biography', ''],
            ['', 'Actions', ''],
        ];
    

        foreach ($heads as $key => $value) {
            $bIcon =  $value[0];
            $th =  $value[1];
            $aIcon = $value[2];

            $headtr[] = Data(
                atts: [
                    'Data' => 'head',
                    'beforeIcon' => $bIcon,
                    'afterIcon' => $aIcon,
                    'th' => $th
                    ]
                );
            }
        return $headtr;
    } else if ($atts['row'] == 'authorBody') {
        $bodytr = [];
        $ID = $atts['ID'];
        $Name = $atts['Name'];
        $Biography = $atts['Biography'];
        
        $bodytr[] = Data(atts: [
            'Data' => 'body',
            'h4' => '',
            'p' => $ID,
            'h4Classes' => '',
            'pClasses' => ''
        ]);
        $bodytr[] = Data(atts: [
            'Data' => 'body',
            'h4' => $Name,
            'p' => '',
            'h4Classes' => '',
            'pClasses' => ''
        ]);
        $bodytr[] = Data(atts: [
            'Data' => 'body',
            'h4' => '<span></span><p class="sub">' . $Biography .'</p>',
            'p' => '',
            'h4Classes' => 'status-container ' . $Biography,
            'pClasses' => ''
        ]);
        $bodytr[] = Data(atts: [
            'Data' => 'actions',
            'id' => $ID,
            'type' => 'author'
        ]);
        return $bodytr;
    }
    // User Rows
    if ($atts['row'] == 'userHead') {
        $headtr = []; 
        $heads = [
            ['', 'ID', ''],
            ['', 'Username', ''],
            ['', 'Status', ''],
            ['', 'Actions', ''],
        ];
    

        foreach ($heads as $key => $value) {
            $bIcon =  $value[0];
            $th =  $value[1];
            $aIcon = $value[2];

            $headtr[] = Data(
                atts: [
                    'Data' => 'head',
                    'beforeIcon' => $bIcon,
                    'afterIcon' => $aIcon,
                    'th' => $th
                    ]
                );
            }
        return $headtr;
    } else if ($atts['row'] == 'userBody') {
        $bodytr = [];
        $ID = $atts['ID'];
        $username = $atts['username'];
        $status = $atts['userStatus'];
        
        $bodytr[] = Data(atts: [
            'Data' => 'body',
            'h4' => '',
            'p' => $ID,
            'h4Classes' => '',
            'pClasses' => ''
        ]);
        $bodytr[] = Data(atts: [
            'Data' => 'body',
            'h4' => $username,
            'p' => '',
            'h4Classes' => '',
            'pClasses' => ''
        ]);
        $bodytr[] = Data(atts: [
            'Data' => 'body',
            'h4' => '<span></span><p class="sub">' . $status .'</p>',
            'p' => '',
            'h4Classes' => 'status-container ' . $status,
            'pClasses' => ''
        ]);
        $bodytr[] = Data(atts: [
            'Data' => 'actions',
            'id' => $ID,
            'type' => 'user'
        ]);
        return $bodytr;
    }
}


?>
<script defer src="Components/JS/Row.js"></script>