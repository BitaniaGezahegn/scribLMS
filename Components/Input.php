<link rel="stylesheet" href="Components/CSS/reset.css">
<link rel="stylesheet" href="Components/CSS/Input.css">
<link rel="stylesheet" href="Assets/CSS/Add_Book.css">
<!-- <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" /> -->
 
<?php

use function PHPSTORM_META\type;

function Input(array $atts) {
    if (!isset($atts['input'])) {
        return;
    }

    $label = $atts['label'];
    $placeholder = $atts['placeholder'];

    if (isset($atts['type'])) {
        $type = $atts['type'];
    } else {
        $type = 'text';
    }

    if (isset($atts['name'])) {
        $name = $atts['name'];
    } else {
        $name = $label;
    }

    if (isset($atts['size'])) {
        $size = $atts['size'];
        $cols = $atts['size']['cols'];
        $rows = $atts['size']['rows'];
    } else {
        $size = ['cols' => 30, 'rows' => 5];
        $cols = 30;
        $rows = 5;
    }

    if (isset($atts['multiselect_search'])) {
        $multiselect_search = $atts['multiselect_search'];
    } else {
        $multiselect_search = 'true';
    }

    if (isset($atts['multiselect_max_items'])){
        $multiselect_max_items = $atts['multiselect_max_items'];
    } else {
        $multiselect_max_items = 2;
    }

    if (isset($atts['value'])){
        $value = $atts['value'];
    } else {
        $value = '';
    }
    
    if (isset($atts['selecetdOptions'])){
        $selecetdOptions = $atts['selecetdOptions'];
        $selectedIDs = [];
        if (gettype($selecetdOptions) == 'array') {
            foreach ($selecetdOptions as $key => $value) {
                $selectedIDs[] = $value[1];
            }
        } else {
            $selectedIDs[] = $selecetdOptions;
        }
    } else {
        $selecetdOptions = [[]];
        $selectedIDs = [];
    }

    $focus = $atts['focus'] ?? '';

    
    if (isset($atts['options'])) {
        $options = $atts['options'];
        $options_container = [];

        foreach ($options as $key => $value) {
            if (in_array($value['value'], $selectedIDs)) {
                $options_container[] = '<option value="' . $value['value'] . '" selected>' . $value['option'] . '</option>';
            } else {

                $options_container[] = '<option value="' . $value['value'] . '">' . $value['option'] . '</option>';
            }
        }
    }



    if ($atts['input'] == 'regular') {
        return ('
<div class="input">
    <label for="' . $name . '">
        <h4>' . $label . '</h4>
    </label>
    <input type="' . $type . '" placeholder="' . $placeholder . '" name="' . $name . '" value="' . $value . '" ' . $focus . '>
</div>
        ');
    } else if ($atts['input'] == 'textarea') {
        return ('
<div class="input description">
    <label for="' . $name . '">
        <h4>' . $label . '</h4>
    </label>
    <textarea cols="' . $cols . '" rows="' . $rows . '" name="' . $name . '" placeholder="' . $placeholder . '">' . $value . '</textarea>
</div>
        ');
    } else if ($atts['input'] == 'multiselect') {
        
    $result = '
    <label for="' . $name . '">
        <h4>' . $label . '</h4>
    </label>
    <select name="' . $name . '[]" multiple multiselect-search="' . $multiselect_search . '" multiselect-max-items="' . $multiselect_max_items . '">';

    for ($i=0; $i < count($options_container); $i++) { 
        $result .= $options_container[$i];
    }
    return ($result . '</select>');
    } else if ($atts['input'] == 'select') {
        
        $result = '
        <label for="' . $name . '">
            <h4>' . $label . '</h4>
        </label>
        <select name="' . $name . '">';
    
        for ($i=0; $i < count($options_container); $i++) { 
            $result .= $options_container[$i];
        }
        return ($result . '</select>');
        }
}
?>


<script src="Components/JS/Input.js"></script>