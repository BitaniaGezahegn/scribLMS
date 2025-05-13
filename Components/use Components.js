// Account
`<?=
Account(atts: [
    'owner' => 'Bitania Gezhegn',
    'id' => '330450595',
    'profile' => '../Assets/Images/Profile Pictures/profile picture.jpg'
]);
?>`

// Button
`<?= Button(atts: ['btnType' => 'viewby']); ?>` // viewby
`<?= Button(atts: ['btnType' => 'filterby']); ?>` // filterby
`<?=
Button(
    atts: [
        'btnType' => 'filled',
        'button' => 'Add Book',
        'symbol' => 'add_circle',
        'background' => 'var(--primary)',
        'color' => 'var(--background)',
        'url' => './Add_Book.php'
    ]
);
?>` // filled

// Filters
`<?= Filters(
    atts: 
    [
        'filters' => ['will', 'james', 'bond', 'come', '?']
    ]
); ?>`

// Card
`<div class="cards">
    <div class="wrapper">      
<?=
Card(
    atts: [
        'isbn' => '902-126797569',
        'card' => '',
        'title' => 'The Great Gatsby',
        'genre' => 'Fiction, Adventure',
        'bookCover' => './../Assets/Images/Book Covers/Dune.jpg',
        'author' => 'J.K Wiliams',
        'status' => 'available',
        'description' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quaerat, accusamus?',
    ]
);
?>
    </div>
</div>`

// Table
`
<?php
$data = [
    [
        'row' => 'bookBody',
        'isbn' => '908-142736189',
        'title' => 'The Yigachal',
        'author' => 'YAML',
        'status' => 'available',
    ],
    [
        'row' => 'bookBody',
        'isbn' => '908-142736189',
        'title' => 'The Yigachal',
        'author' => 'YAML',
        'status' => 'available',
    ],
];

$table = Table(atts: [
    'table' => 'books',
    'rows' => $data
]) ?>

<div class="list">
    <table>
        <thead>
            <tr><?php foreach ($table[0] as $key => $value) {
                echo $value;
            } ?></tr>
        </thead>
        </tbody>
        <?php foreach ($table[1] as $key => $value) {
                echo '<tr>';
                foreach ($value as $key => $value) {
                    echo $value;
                }
                echo '</tr>';
            } ?>
        </tbody>
    </table>
</div>
`
// Pagination
`
<?=
Pagination(atts: [
    'pagination' => 'grid',
    'page' => 9,
    'group' => 89
]);
?>
`

// Input
    // Regular
    `<?php echo Input(atts:[
        'input' => 'regular',
        'label' => 'Title',
        'placeholder' => 'Name of the Book'
    ]) ?>`
    // Textarea
    `<?php echo Input(atts:[
    'input' => 'textarea',
    'label' => 'Description',
    'placeholder' => 'Description of the Book'
    ]);
    ?>`
    // Multiselect
    `<?php 
$options = [
    [
        'option' => 'option1',
        'value' => 'value1'
    ],
    [
        'option' => 'option2',
        'value' => 'value2'
    ],
    [
        'option' => 'option3',
        'value' => 'value3'
    ]
];
echo Input(atts:[
    'input' => 'multiselect',
    'label' => 'select',
    'placeholder' => '',
    'options' => $options
]);
?>`

// Popup
`
<?=
Popup(
    atts: [
        'popup' => 'success',
        'message' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestiae assumenda.'
    ]);
?>
`