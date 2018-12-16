<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'Fifteen hundred Consulting',

    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>Sistema de Gestão</b><br><b>1500</b>',

    'logo_mini' => '<b>Sistema de Gestão</b><br><b>1500</b>',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'blue',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        'REGISTROS DE HORAS',

        [
            'text'    => 'Registro de Horas',
            'icon' => 'hourglass-half',
            'submenu' => [
                [
                    'text' => 'Listagem de Registros',
                        // 'url'  => '/cadastrar-usuario',
                    'icon' => 'list-ul',
                ],

                [
                    'text' => 'Registrar Horas',
                    'url'  => '/registro-horas',
                    'icon'    => 'registered',
                ],
            ],
        ],


        'BUSINESS',

        [
            'text' => 'Escopo Orçamento',
            'url'  => '/escopo-orcamento',
            'icon'    => 'object-group',
        ],


        [
            'text'        => 'Projetos',
            'url'         => '/projetos',
            'icon'        => 'cloud',
            // 'label'       => 4,
            'label_color' => 'success',
        ],

        [
            'text'    => 'Gestão',
            'icon' => 'balance-scale',
            'submenu' => [
                [
                    'text' => 'Semanal',
                    'url'  => '/cadastrar-usuario',
                    'icon' => 'list-ul',
                ],

                [
                    'text' => 'Gestão por Projeto',

                    'icon' => 'list-ul',
                    'url'  => '/listar-usuarios',
                ],

                [
                    'text'        => 'Gestão de Escopos',
                    'url'         => '/adicionar-consultor',
                    'icon'        => 'list-ul',
                    // 'label'       => 4,
                    'label_color' => 'success',
                ],
                [
                    'text'        => 'Validações',
                    'url'         => '/gerenciar-gestores',
                    'icon'        => 'list-ul',
                    // 'label'       => 4,
                    'label_color' => 'success',
                ],




            ],

        ],
        'CADASTROS',
       // [
       //     'text' => 'Sistema de Gestão 1500FH',
       //     'url'  => '#',
       //     'can'  => 'manage-blog',
       // ],


        [
            'text'    => 'Staff',
            'icon'    => 'users',
            'submenu' => [
                [
                    'text' => 'Usuários',
                    'url'  => '/cadastrar-usuario',
                    'icon' => 'plus-square',
                ],

                [
                    'text' => 'Gerenciar Usuários',

                    'icon' => 'list-ul',
                    'url'  => '/listar-usuarios',
                ],

                [
                    'text'        => 'Consultores',
                    'url'         => '/adicionar-consultor',
                    'icon'        => 'user-circle',
                    // 'label'       => 4,
                    'label_color' => 'success',
                ],
                [
                    'text'        => 'Gestores',
                    'url'         => '/gerenciar-gestores',
                    'icon'        => 'user-circle',
                    // 'label'       => 4,
                    'label_color' => 'success',
                ],




            ],

        ],

//        [
//            'text'        => 'Tipos de Atividade',
//            'url'         => '/atividades',
//            'icon'        => 'briefcase',
//            // 'label'       => 4,
//            'label_color' => 'success',
//        ],

        [
            'text'        => 'Tipos de Atividade',
            'icon'        => 'briefcase',
            'submenu' => [
                    [
                        'text' => 'Unitários',
                        'url'  => '/atividades',
                        'icon' => 'plus-square',
                    ],
                [
                    'text' => 'Grupo de Tipos',
                    'url'  => '/grupo-atividades',
                    'icon' => 'plus-square',
                ],
                ]
        ],




//        [
//            'text'        => 'Clientes',
//            'url'         => '/clientes',
//            'icon'        => 'book',
//            // 'label'       => 4,
//            'label_color' => 'success',
//        ],
//
//        [
//            'text'        => 'Projetos',
//            'url'         => '/projetos',
//            'icon'        => 'cloud',
//            // 'label'       => 4,
//            'label_color' => 'success',
//        ],




        'RELATÓRIOS',
        [
            'text' => 'Horas',
            'url'  => '',
            'icon' => 'info-circle',
        ],
        [
            'text' => 'Consultores',
            'url'  => 'admin/settings',
            'icon' => 'info-circle',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
        'chartjs'    => true,
    ],
];
