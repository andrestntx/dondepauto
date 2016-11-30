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

ini_set('upload_max_filesize', '40M');

use Carbon\Carbon;

Carbon::setLocale('es');

Route::auth();

Route::get('services/logos', [
    'as'   => 'services.logos',
    'uses' => 'ServicesController@logos'
]);

Route::get('medios/confirmar/{code}', [
    'as'   => 'medios.confirm',
    'uses' => 'Publisher\PublishersController@confirm'
]);

Route::get('test/{viewSpaces}', [
    'as'    => 'test.space',
    'uses'  => 'HomeController@spaces'
]);

Route::post('medios/login/{publishers}', [
    'uses' => 'Auth\PublisherController@platformLogin',
    'as' => 'medios.platform.login'
]);

Route::post('mailchimp/sync/{publishers}', [
    'uses' => 'Admin\UsersController@syncMailchimp',
    'as' => 'mailchimp.sync'
]);

Route::get('propuestas/{proposals}/preview/pdf', [
    'as'    => 'proposals.preview-pdf',
    'uses'  => 'Admin\ProposalsController@previewPdf'
]);

Route::get('propuestas/{proposals}/preview/all-pdf', [
    'as'    => 'proposals.preview-all-pdf',
    'uses'  => 'Admin\ProposalsController@previewAllPdf'
]);


Route::get('propuestas/{proposals}/preview/html', [
    'as'    => 'proposals.preview-html',
    'uses'  => 'Admin\ProposalsController@previewHtml'
]);

Route::post('propuestas/{proposals}/select', [
    'as'    => 'proposals.select',
    'uses'  => 'Admin\ProposalsController@select'
]);

Route::post('propuestas/{proposals}/spaces/{spaces}/select', [
    'as'    => 'proposals.spaces.select',
    'uses'  => 'Admin\ProposalsController@selectSpace'
]);

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

    Route::group(['middleware' => 'role:director;admin'], function() {
        Route::resource('directores', 'Admin\DirectorsController', ['parameters' => [
            'directores' => 'directors'
        ]]);

        Route::get('documentos', [
            'as'   => 'documents',
            'uses' => 'Admin\DocumentsController@index'
        ]);

        Route::post('documentos', [
            'as'   => 'documents.post',
            'uses' => 'Admin\DocumentsController@post'
        ]);

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

        Route::post('anunciantes/{advertiser}/contacts', [
            'as'    => 'anunciantes.contacts.store',
            'uses' => 'Admin\AdvertisersController@newContact'
        ]);

        Route::post('medios/{publishers}/agreement', [
            'as'    => 'medios.agreement',
            'uses' => 'Admin\PublishersController@checkAgreement'
        ]);
    });

    Route::group(['middleware' => 'role:director;admin;adviser'], function() {
        Route::get('asesores/{advisers}/anunciantes/search', [
            'as'    => 'asesores.anunciantes.search',
            'uses' => 'Admin\AdvisersAdvertisersController@search'
        ]);

        Route::get('anunciantes/{advertisers}/change', [
            'as'    => 'anunciantes.change',
            'uses' => 'Admin\AdvertisersController@changeRole'
        ]);

        Route::get('medios/{publishers}/change', [
            'as'    => 'medios.change',
            'uses' => 'Admin\PublishersController@changeRole'
        ]);

        Route::post('anunciantes/{publishers}/ajax', [
            'uses' => 'Admin\AdvertisersController@updateAjax',
            'as' => 'anunciantes.update.ajax'
        ]);

        Route::resource('asesores.anunciantes', 'Admin\AdvisersAdvertisersController',  ['parameters' => [
            'asesores' => 'advisers',
            'anunciantes' => 'advertisers'
        ]]);

        Route::get('medios/search', [
            'as'    => 'medios.search',
            'uses' => 'Admin\PublishersController@search'
        ]);

        Route::get('users/search/{publishers}', [
            'as'    => 'users.search',
            'uses' => 'Admin\UsersController@search'
        ]);

        Route::get('espacios/ajax', [
            'as'    => 'espacios.ajax',
            'uses' => 'Admin\SpacesController@ajax'
        ]);

        Route::get('espacios/{spaces}/show', [
            'as'    => 'espacios.space',
            'uses' => 'Admin\SpacesController@getSpace'
        ]);

        Route::get('espacios/search', [
            'as'    => 'espacios.search',
            'uses' => 'Admin\SpacesController@search'
        ]);

        Route::post('espacios/recomendar/{spaces}', [
            'as'    => 'espacios.suggest',
            'uses' => 'Admin\SpacesController@suggest'
        ]);

        Route::post('users/{publishers}/tag', [
            'as'    => 'users.tag',
            'uses' => 'Admin\UsersController@tag'
        ]);

        Route::resource('espacios', 'Admin\SpacesController', ['parameters' => [
            'espacios' => 'spaces'
        ]]);

        Route::get('medios/{publisher_id}/states', [
            'uses' => 'Admin\PublishersController@getStates',
            'as' => 'medios.states'
        ]);

        Route::post('medios/{publishers}/ajax', [
            'uses' => 'Admin\PublishersController@updateAjax',
            'as' => 'medios.update.ajax'
        ]);

        Route::resource('medios', 'Admin\PublishersController', [
            'parameters' => ['medios' => 'publishers']
        ]);

        Route::post('medios/{publishers}/change-documents', [
            'uses' => 'Admin\PublishersController@changeDocuments',
            'as' => 'medios.change-documents'
        ]);

        Route::get('admin/medios/{publishers}', [
            'as'    => 'medios.dashboard',
            'uses' => 'Admin\PublishersController@dashboard'
        ]);

        Route::get('propuestas', [
            'as'    => 'proposals.index',
            'uses'  => 'Admin\ProposalsController@index'
        ]);

        Route::get('propuestas/search', [
            'as'    => 'proposals.search',
            'uses'  => 'Admin\ProposalsController@search'
        ]);

        Route::post('propuestas/{proposals}/observation-file', [
            'as'    => 'proposals.observation-file',
            'uses'  => 'Admin\ProposalsController@observationFile'
        ]);

        Route::get('propuestas/{proposals}/search', [
            'as'    => 'proposals.spaces.search',
            'uses'  => 'Admin\ProposalsController@searchSpaces'
        ]);

        Route::post('propuestas/{proposals}/send', [
            'as'    => 'proposals.send',
            'uses'  => 'Admin\ProposalsController@send'
        ]);

        Route::put('propuestas/{proposals}', [
            'as'    => 'proposals.update',
            'uses'  => 'Admin\ProposalsController@update'
        ]);

        Route::delete('propuestas/{proposals}', [
            'as'    => 'proposals.delete',
            'uses'  => 'Admin\ProposalsController@delete'
        ]);

        Route::get('propuestas/{proposals}', [
            'as'    => 'proposals.show',
            'uses'  => 'Admin\ProposalsController@show'
        ]);

        Route::post('propuestas/agregar/{spaces}', [
            'as'    => 'proposals.spaces.add',
            'uses'  => 'Admin\ProposalsController@add'
        ]);

        Route::get('propuestas/{proposals}/spaces/{spaces}/edit', [
            'as' => 'proposals.spaces.edit',
            'uses' => 'Admin\ProposalSpacesController@edit'
        ]);

        Route::delete('propuestas/{proposals}/spaces/{spaces}', [
            'as' => 'proposals.spaces.delete',
            'uses' => 'Admin\ProposalSpacesController@delete'
        ]);

        Route::post('propuestas/{proposals}/spaces/{spaces}/duplicate', [
            'as' => 'proposals.spaces.duplicate',
            'uses' => 'Admin\ProposalSpacesController@postDuplicate'
        ]);

        Route::post('propuestas/{proposals}/discount/{spaces}', [
            'as'    => 'proposals.spaces.discount',
            'uses'  => 'Admin\ProposalsController@discount'
        ]);

        Route::post('anunciantes/{publishers}/quotes', [
            'as'    => 'quotes.store',
            'uses'  => 'Admin\QuotesController@store'
        ]);

        Route::put('propuestas/{proposals}/quotes', [
            'as'    => 'quotes.update',
            'uses'  => 'Admin\QuotesController@update'
        ]);
    });

    Route::group(['middleware' => 'role:director;admin;adviser;publisher'], function() {

        Route::get('medios/{publishers}/faqs', [
            'as'    => 'medios.faqs',
            'uses' => 'Publisher\PublishersController@faqs'
        ]);

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

        Route::post('medios/{publishers}/acuerdo/solicitar-cambio', [
            'uses' => 'Publisher\PublishersController@changeAgreement',
            'as' => 'medios.agreement.change'
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

        Route::post('medios/{publishers}/logo', [
            'uses' => 'Publisher\PublishersController@uploadLogo',
            'as' => 'medios.logo.upload'
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

        Route::get('medios/{publishers}/espacios/first-create', [
            'as' => 'medios.espacios.first-create',
            'uses' => 'Publisher\PublishersSpacesController@firstCreate'
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

        Route::post('medios/{publishers}/espacios/{spaces}/enable', [
            'as' => 'medios.espacios.enable',
            'uses' => 'Publisher\PublishersSpacesController@enable'
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

        Route::group(['prefix' => 'email'], function() {

            Route::get('completar-registro', function(){
               return redirect()->route('medios.account', auth()->user()->publisher);
            });

            Route::get('presentar-ofertas', function(){
                return redirect()->route('medios.espacios.create', auth()->user()->publisher);
            });

            Route::get('firmar-acuerdo', function(){
                return redirect()->route('medios.agreement.complete', auth()->user()->publisher);
            });
        });
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