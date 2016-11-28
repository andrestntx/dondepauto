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
        //'directors'     => ['url' => 'directores', 'i' =>  'fa fa-user', 'title' => 'Directores', 'roles' => ['admin', 'director']],
        'advisers'      => ['url' => 'asesores', 'i' =>  'fa fa-slideshare', 'title' => 'Asesores', 'roles' => ['admin', 'director']],
        'advertisers'   => ['url' => 'anunciantes', 'i' =>  'fa fa-users', 'title' => 'Anunciantes', 'roles' => ['admin', 'director']],
        'mediums'       => ['url' => 'medios', 'i' =>  'fa fa-twitch', 'title' => 'Medios', 'roles' => ['admin', 'director', 'adviser']],
        'adviser_advertisers'   => ['route' => ['asesores.anunciantes.index', ':user_id'], 'i' =>  'fa fa-users', 'title' => 'Anunciantes', 'roles' => ['adviser']],
        'spaces'        => ['url' => 'espacios', 'i' =>  'fa fa-newspaper-o', 'title' => 'Espacios', 'roles' => ['admin', 'director']],
        'intentions'    => ['url' => 'intenciones', 'i' =>  'fa fa-rocket', 'title' => 'Intenciones', 'roles' => ['admin', 'director', 'adviser']],
        'proposals'    => ['url' => 'propuestas', 'i' =>  'fa fa-calculator', 'title' => 'Propuestas', 'roles' => ['admin', 'director', 'adviser']],
    ],
    'publishers' => [
        
        
        // Publishers
        'account'       => [
                            'route' => ['medios.account', ':publisher'], 
                            'i' => 'fa fa-user', 
                            'title' => 'Mi cuenta', 
                            'allows' => ['account', ':publisher']
                        ],
        'inventory'     => [
                            'route' => ['medios.espacios.index', ':publisher'], 
                            'i' => 'fa fa-shopping-cart', 
                            'title' => 'Inventario', 
                            'allows' => ['inventory', ':publisher']
                        ],
        'new_offert'     => [
                            'route' => ['medios.espacios.first-create', ':publisher'], 
                            'i' => 'fa fa-plus-circle', 
                            'title' => 'Crear oferta', 
                            'allows' => ['inventory', ':publisher']
                        ],
        'agreement'     => [
                            'route' => ['medios.agreement.complete', ':publisher'], 
                            'i' => 'fa fa-file-text-o', 
                            'title' => 'Activación Proveedor', 
                            'allows' => ['agreement', ':publisher']
                        ],
        'faqs'          => [
                            'route' => ['medios.faqs', ':publisher'], 
                            'i' => 'fa fa-question-circle', 
                            'title' => 'Preguntas frecuentes',
                            'roles' => ['publisher', 'admin', 'director']
                        ],
        'service'       => [
                            'full_url' => 'http://www.dondepauto.co/modelo-de-negocio-medios-publicitarios', 
                            'i' => 'fa fa-lightbulb-o', 
                            'title' => 'Servicio DóndePauto',
                            'roles' => ['publisher', 'admin', 'director']
                        ],
        'tyc'          => [
                            'full_url' => 'http://www.dondepauto.co/terminos-y-condiciones-de-servicio-medios-publicitarios', 
                            'i' => 'fa fa-exclamation-circle', 
                            'title' => 'Términos y condiciones',
                            'roles' => ['publisher', 'admin', 'director']
                        ],
    ]
];