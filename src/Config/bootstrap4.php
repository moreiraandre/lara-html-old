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
            'action',
            'method' => 'post',
        ],

        'Text' => [
            'name',
            'meta.label' => 'eval..ucfirst($this->getAttr()["name"])',
            'value',
            'placeholder' => 'eval.."-> " . ucfirst($this->getAttr()["name"])',
            'class' => 'form-control form-control-sm',
        ],

        'Button' => [
            'meta.label',
            'class' => 'btn btn-danger btn-sm',
        ],

    ],

];
