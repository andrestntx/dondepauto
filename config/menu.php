<?php
/**
 * Created by PhpStorm.
 * Users: andrestntx
 * Date: 12/04/16
 * Time: 5:52 PM
 */

return [
    'sidebar'   => [
        // All users
        'home'          => ['url' => '/', 'i' =>  'fa fa-th-large', 'title' => 'Inicio'],
        'directors'     => ['url' => 'directores', 'i' =>  'fa fa-user', 'title' => 'Directores', 'roles' => ['admin', 'director']],
        'advisers'      => ['url' => 'asesores', 'i' =>  'fa fa-slideshare', 'title' => 'Asesores', 'roles' => ['admin', 'director']],
        'advertisers'   => ['url' => 'anunciantes', 'i' =>  'fa fa-users', 'title' => 'Anunciantes', 'roles' => ['admin', 'director']],
        'mediums'       => ['url' => 'medios', 'i' =>  'fa fa-twitch', 'title' => 'Medios', 'roles' => ['admin', 'director', 'adviser']],
        'adviser_advertisers'   => ['route' => ['asesores.anunciantes.index', ':user_id'], 'i' =>  'fa fa-users', 'title' => 'Anunciantes', 'roles' => ['adviser']],
        'spaces'        => ['url' => 'espacios', 'i' =>  'fa fa-newspaper-o', 'title' => 'Espacios', 'roles' => ['admin', 'director']],
        'intentions'    => ['url' => 'intenciones', 'i' =>  'fa fa-rocket', 'title' => 'Intenciones', 'roles' => ['admin', 'director', 'adviser']],
        'proposals'    => ['url' => 'propuestas', 'i' =>  'fa fa-calculator', 'title' => 'Propuestas', 'roles' => ['admin', 'director', 'adviser']],

        // Publishers
        'account'           => ['route' => ['medios.account', ':user_platform_id'], 'i' => 'fa fa-user', 'title' => 'Mi cuenta', 'roles' => ['publisher']],
        'inventory'         => ['route' => ['medios.inventory', ':user_platform_id'], 'i' => 'fa fa-user', 'title' => 'Inventario', 'roles' => ['publisher']],
    ]
];