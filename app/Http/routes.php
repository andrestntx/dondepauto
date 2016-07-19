<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Carbon\Carbon;

Carbon::setLocale('es');

Route::auth();

Route::get('medios/confirmar/{code}', [
    'as'   => 'medios.confirm',
    'uses' => 'Publisher\PublishersController@confirm'
]);

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

    Route::group(['middleware' => 'role:director;admin'], function() {
        Route::resource('directores', 'Admin\DirectorsController', ['parameters' => [
            'directores' => 'directors'
        ]]);

        Route::get('directores/{advisers}/anunciantes/search', [
            'as'    => 'directores.anunciantes.search',
            'uses' => 'Admin\DirectorsAdvertisersController@search'
        ]);

        Route::post('directores/{directors}/unlink', [
            'as'    => 'directores.unlink',
            'uses' => 'Admin\DirectorsController@unlink'
        ]);

        Route::post('directores/{directors}/link', [
            'as'    => 'directores.link',
            'uses' => 'Admin\DirectorsController@link'
        ]);

        Route::resource('asesores', 'Admin\AdvisersController', ['parameters' => [
            'asesores' => 'advisers'
        ]]);

        Route::post('asesores/{advisers}/unlink', [
            'as'    => 'asesores.unlink',
            'uses' => 'Admin\AdvisersController@unlink'
        ]);

        Route::post('asesores/{advisers}/link', [
            'as'    => 'asesores.link',
            'uses' => 'Admin\AdvisersController@link'
        ]);

        Route::get('anunciantes/search', [
            'as'    => 'anunciantes.search',
            'uses' => 'Admin\AdvertisersController@search'
        ]);

        Route::get('anunciantes/unlinked', [
            'as'    => 'anunciantes.unlinked',
            'uses' => 'Admin\AdvertisersController@unlinked'
        ]);

        Route::get('anunciantes/{advertiser}/propuestas/search', [
            'as'    => 'anunciantes.propuestas.search',
            'uses' => 'Admin\AdvertisersController@searchProposals'
        ]);

        Route::resource('anunciantes', 'Admin\AdvertisersController',  ['parameters' => [
            'anunciantes' => 'advertisers'
        ]]);
    });

    Route::group(['middleware' => 'role:director;admin;adviser'], function() {
        Route::get('asesores/{advisers}/anunciantes/search', [
            'as'    => 'asesores.anunciantes.search',
            'uses' => 'Admin\AdvisersAdvertisersController@search'
        ]);

        Route::resource('asesores.anunciantes', 'Admin\AdvisersAdvertisersController',  ['parameters' => [
            'asesores' => 'advisers',
            'anunciantes' => 'advertisers'
        ]]);

        Route::get('medios/search', [
            'as'    => 'medios.search',
            'uses' => 'Admin\PublishersController@search'
        ]);

        Route::get('espacios/ajax', [
            'as'    => 'espacios.ajax',
            'uses' => 'Admin\SpacesController@ajax'
        ]);

        Route::get('espacios/search', [
            'as'    => 'espacios.search',
            'uses' => 'Admin\SpacesController@search'
        ]);

        Route::resource('espacios', 'Admin\SpacesController', ['parameters' => [
            'espacios' => 'spaces'
        ]]);

        Route::resource('medios', 'Admin\PublishersController', [
            'parameters' => ['medios' => 'publishers']
        ]);

    });

    Route::group(['middleware' => 'role:director;admin;adviser;publisher'], function() {
        Route::get('medios/{publisher}/espacios/search', [
            'as'    => 'medios.espacios.search',
            'uses' => 'Admin\PublishersController@searchSpaces'
        ]);

        Route::get('medios/{publishers}/cuenta', [
            'uses' => 'Publisher\PublishersController@account',
            'as' => 'medios.account'
        ]);

        Route::post('medios/{publishers}/complete', [
            'uses' => 'Publisher\PublishersController@complete',
            'as' => 'medios.complete'
        ]);

        Route::get('medios/{publishers}/inventario', [
            'uses' => 'Admin\PublishersController@show',
            'as' => 'medios.inventory'
        ]);

        Route::get('medios/{publishers}/acuerdo', [
            'uses' => 'Publisher\PublishersController@agreement',
            'as' => 'medios.agreement'
        ]);

        Route::get('medios/{publishers}/acuerdo/completar', [
            'uses' => 'Publisher\PublishersController@completeAgreement',
            'as' => 'medios.agreement.complete'
        ]);
        
        Route::post('medios/{publishers}/acuerdo/completar', [
            'uses' => 'Publisher\PublishersController@postCompleteAgreement',
            'as' => 'medios.agreement.complete.docs'
        ]);

        Route::post('medios/{publishers}/acuerdo/documentos', [
            'uses' => 'Publisher\PublishersController@uploadDocuments',
            'as' => 'medios.agreement.complete.upload'
        ]);

        Route::get('medios/{publishers}/acuerdo/carta', [
            'uses' => 'Publisher\PublishersController@getLetter',
            'as' => 'medios.agreement.letter'
        ]);

        Route::get('medios/{publishers}/publicar', [
            'uses' => 'Publisher\PublishersController@publish',
            'as' => 'medios.publish'
        ]);

        Route::get('actualizar-puntos', [
            'as' => 'medios.espacios.update-all-points',
            'uses' => 'Publisher\PublishersSpacesController@updateAllPoints'
        ]);

        Route::get('medios/{publishers}/espacios/actualizar-puntos', [
            'as' => 'medios.espacios.update-points',
            'uses' => 'Publisher\PublishersSpacesController@updatePoints'
        ]);

        Route::get('medios/{publishers}/espacios/{spaces}/duplicar', [
            'as' => 'medios.espacios.duplicate',
            'uses' => 'Publisher\PublishersSpacesController@duplicate'
        ]);

        Route::post('medios/{publishers}/espacios/{spaces}/duplicar', [
            'as' => 'medios.espacios.post-duplicate',
            'uses' => 'Publisher\PublishersSpacesController@postDuplicate'
        ]);

        Route::post('medios/{publishers}/espacios/{spaces}/active', [
            'as' => 'medios.espacios.active',
            'uses' => 'Publisher\PublishersSpacesController@active'
        ]);

        Route::post('medios/{publishers}/espacios/{spaces}/inactive', [
            'as' => 'medios.espacios.active',
            'uses' => 'Publisher\PublishersSpacesController@inactive'
        ]);

        Route::post('medios/{publishers}/espacios/{spaces}', [
            'as' => 'medios.espacios.update',
            'uses' => 'Publisher\PublishersSpacesController@update'
        ]);
        
        
        
        Route::resource('medios.espacios', 'Publisher\PublishersSpacesController',
            ['parameters' => [
                'medios'    => 'publishers',
                'espacios'  => 'spaces'
            ],
            'except' => 'update'
        ]);

        Route::post('medios/{publishers}/account', [
            'uses' => 'Publisher\PublishersController@updateAccount',
            'as' => 'medios.update-account'
        ]);
    });
});

Route::group(['prefix' => 'landing'], function(){
    Route::post('register/publisher', [
        'as'   => 'register.publisher',
        'uses' => 'Auth\PublisherController@registerLanding'
    ]);
});

Route::get('metricas/espacios', function(\Illuminate\Http\Request $request){
    return DB::table('view_spaces')
            ->select(\DB::raw("COUNT(*) as espacios_publicados"))
            ->where("created_at", ">=", $request->get('start'))
            ->where("created_at", "<=", $request->get('end'))
            ->get();
});