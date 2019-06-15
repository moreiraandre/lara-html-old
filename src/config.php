<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Template
    |--------------------------------------------------------------------------
    |
    */

//    'default' => env('LARA_HTML_DEFAULT', 'materialize'),
    'default' => env('LARA_HTML_DEFAULT', 'bootstrap4'),
    'extend_view' => env('LARA_HTML_EXTEND_VIEW', 'welcome'),

    /*
    |--------------------------------------------------------------------------
    | Available Templates
    |--------------------------------------------------------------------------
    |
    | Defination keys:
    |       max_cols: Maximum number of columns that a row can contain.
    |       screen: CSS class of the container that houses the rows.
    |       row: CSS class of the lines.
    |       xs: CSS class of columns of small size.
    |       md: CSS class of columns of medium size.
    |       lg: CSS class of large size columns.
    |       xl: CSS class of extra-large columns.
    |
    */

    'templates' => [

        'bootstrap4' => [
            'max_cols' => 12,
            'css' => [
                'screen' => 'container-fluid',
                'row' => 'row',
                'col' => [
                    'sm' => 'col-sm-',
                    'md' => 'col-md-',
                    'lg' => 'col-lg-',
                    'xl' => 'col-xl-',
                ],
            ]
        ],

        'bootstrap3' => [
            'max_cols' => 12,
            'css' => [
                'screen' => 'container',
                'row' => 'row',
                'col' => [
                    'sm' => 'col-sm-',
                    'md' => 'col-md-',
                    'lg' => 'col-lg-',
                    'xl' => 'col-xl-',
                ],
            ]
        ],

        'adminlte2' => [
            'max_cols' => 12,
            'css' => [
                'screen' => 'container',
                'row' => 'row',
                'col' => [
                    'sm' => 'sm-',
                    'md' => 'md-',
                    'lg' => 'lg-',
                    'xl' => 'xl-',
                ],
            ]
        ],

        'adminlte3' => [
            'max_cols' => 12,
            'css' => [
                'screen' => 'container',
                'row' => 'row',
                'col' => [
                    'sm' => 'sm-',
                    'md' => 'md-',
                    'lg' => 'lg-',
                    'xl' => 'xl-',
                ],
            ]
        ],

        'coreui' => [
            'max_cols' => 12,
            'css' => [
                'screen' => 'container',
                'row' => 'row',
                'col' => [
                    'sm' => 'sm-',
                    'md' => 'md-',
                    'lg' => 'lg-',
                    'xl' => 'xl-',
                ],
            ]
        ],

        'foundation' => [
            'max_cols' => 12,
            'css' => [
                'screen' => 'grid-container',
                'row' => 'grid-x',
                'col' => [
                    'sm' => 'sm',
                    'md' => 'cell',
                    'lg' => 'lg',
                    'xl' => 'xl',
                ],
            ]
        ],

        'materialize' => [
            'max_cols' => 12,
            'css' => [
                'screen' => 'container',
                'row' => 'row',
                'col' => [
                    'sm' => 'sm',
                    'md' => 'col m',
                    'lg' => 'lg',
                    'xl' => 'xl',
                ],
            ]
        ],

    ],

];
