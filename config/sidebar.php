<?php

return [
    'menu' => [
        [
            'role' => 'Admin|Consulta',
            'permission' =>  ['home'],
			'icon' => 'fa-solid fa-gauge-simple bg-gradient-orange',
			'BG' => 'bg-gradient-blue',
			'url' => '/dashboard',
			'WN' => 'wire:navigate',
			'title' => 'Dashboard',
			'route-name' => 'dashboard.index',
            'caret' => false,
        ],

        [
            'role' => 'Admin|Admin_ambiental',
            'permission' =>  ['modulo_registros_cantidades'],
            'BG' => 'bg-gradient-indigo',
            'title' => 'Registros',
            'url' => '#',
            'WN' => '',
            'caret' => true,
            'sub_menu' => [[
                'permission' => ['modulo_registros_cantidades'],
                'icon' => 'fas fa-compress-arrows-alt bg-gradient-blue',
                'BG' => 'bg-gradient-indigo',
                'url' => 'unidades_produccion',
                'title' => 'Unidades de Produccion',
                'route-name' => 'unidades_produccion.index'
            ]/* , [
                'permission' => ['modulo_registros_cantidades'],
                'icon' => 'fas fa-water bg-gradient-blue',
                'BG' => 'bg-gradient-light-blue-special',
                'url' => '#',
                'title' => 'Consumos de Agua',
                'route-name' => 'roles.index'
            ] */]
        ],
        [
            'role' => 'Admin|Admin_ambiental',
            'permission' =>  ['modulo_registros_cantidades'],
            'BG' => 'bg-gradient-green',
            'title' => 'Tablas %',
            'url' => '#',
            'WN' => '',
            'caret' => true,
            'sub_menu' => [[
                'permission' => ['modulo_registros_cantidades'],
                'icon' => 'fas fa-percent ',
                'BG' => 'bg-gradient-green',
                'url' => 'percentage_tables',
                'title' => '% por empresa',
                'route-name' => 'percentage_tables.index'
            ]]
        ],

        [
            'role' => 'Admin|Consulta',
            'permission' =>  ['modulo_usuarios', 'modulo_roles', 'modulo_permisos'],
            'BG' => 'bg-gradient-orange',
            'title' => 'Configuración',
            'url' => '#',
            'WN' => '',
            'caret' => true,
            'sub_menu' => [[
                'permission' => ['modulo_usuarios'],
                'icon' => 'fa-solid fa-users bg-gradient-orange',
                'BG' => 'bg-gradient-orange',
                'url' => 'usuarios',
                'title' => 'Usuarios',
                'route-name' => 'usuarios.index'
            ], [
                'permission' => ['modulo_roles'],
                'icon' => 'fa-solid fa-user-lock bg-gradient-green',
                'BG' => 'bg-gradient-orange',
                'url' => 'roles',
                'title' => 'Roles',
                'route-name' => 'roles.index'
            ], [
                'permission' => ['modulo_permisos'],
                'icon' => 'fa-solid fa-user-shield bg-gradient-red',
                'BG' => 'bg-gradient-orange',
                'url' => 'permisos',
                'title' => 'Permisos',
                'route-name' => 'permisos.index'
            ], [
                'permission' => ['modulo_procesos'],
                'icon' => 'fa-solid fa-user-tag bg-gradient-blue',
                'BG' => 'bg-gradient-orange',
                'url' => 'procesos',
                'title' => 'Procesos',
                'route-name' => 'procesos.index'
            ]]
        ],

        /* [
            'role' => '',
            'permission' => [],
            'icon' => '',
            'BG' => '',
            'title' => '',
            'url' => '',
            'WN' => '',
            'label' => '',
            'route-name' => '',
            'caret' => false,
        ], */

        /* [
            'role' => '',
            'permission' =>  [],
            'BG' => '',
            'title' => '',
            'url' => '#',
            'WN' => '',
            'caret' => true,
            'sub_menu' => [[
                'permission' => [],
                'icon' => '',
                'BG' => '',
                'url' => '',
                'WN' => '',
                'title' => '',
                'route-name' => ''
            ],[
                'permission' => [],
                'icon' => '',
                'BG' => '',
                'url' => '',
                'WN' => '',
                'title' => '',
                'route-name' => ''
            ],]
        ], */
    ]
];
