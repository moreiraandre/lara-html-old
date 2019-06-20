<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Maximum number of columns per row
    |--------------------------------------------------------------------------
    |
    */

    'max_cols' => 12,

    /*
    |--------------------------------------------------------------------------
    | Grid CSS classes
    |--------------------------------------------------------------------------
    |
    */

    'grid-css' => [

        'screen' => 'container-fluid',
        'row' => 'no-gutters row',
        'col' => 'col-md-',

    ],

    /*
    |--------------------------------------------------------------------------
    | Custom plugins
    |--------------------------------------------------------------------------
    |
    | Case must respect the call of the plugin, example call: $this->addMeuForm();
    | plugin definition: 'MyForm' => []
    |
    */

    'plugins' => [

        'Form' => [
//            'aa',
            'method' => 'post',
        ],

        'Text' => [
            'name',
            'label' => 'ucfirst($this->getMeta()["name"])',
            'placeholder' => '"-> " . ucfirst($this->getMeta()["name"])',
            'class' => 'form-control form-control-sm',
        ],

        'Button' => [
            'label',
            'class' => 'btn btn-danger btn-sm',
        ],

    ],

];
