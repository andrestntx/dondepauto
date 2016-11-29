<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 13/04/2016
 * Time: 1:29 PM
 */

// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-home"></i>', url('/'));
});

// Home > advisers
Breadcrumbs::register('advisers', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Asesores', url('asesores'));
});

// Home > documents
Breadcrumbs::register('documents', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Documentos', url('documentos'));
});

// Home > advisers > {{ adviser }}
Breadcrumbs::register('advisers.adviser', function ($breadcrumbs, $adviser) {
    $breadcrumbs->parent('advisers');
    if ($adviser->exists) {
        $breadcrumbs->push($adviser->name, route('asesores.show', $adviser));
    } else {
        $breadcrumbs->push('Nuevo Asesor', route('asesores.create'));
    }
});

// Home > advisers > {{ adviser }} > advertisers
Breadcrumbs::register('advisers.adviser.advertisers', function ($breadcrumbs, $adviser) {
    $breadcrumbs->parent('advisers.adviser', $adviser);
    $breadcrumbs->push('Anunciantes', route('asesores.anunciantes.index', $adviser));
});

// Home > directors
Breadcrumbs::register('directors', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Directores', url('directores'));
});

// Home > directors > {{ director }}
Breadcrumbs::register('directors.director', function ($breadcrumbs, $director) {
    $breadcrumbs->parent('directors');
    if ($director->exists) {
        $breadcrumbs->push($director->name, route('anunciantes.show', $director));
    } else {
        $breadcrumbs->push('Nuevo Director', route('anunciantes.create'));
    }
});

// Home > directors > {{ director }} > advertisers
Breadcrumbs::register('directors.director.advertisers', function ($breadcrumbs, $director) {
    $breadcrumbs->parent('directors.director', $director);
    $breadcrumbs->push('Anunciantes', route('anunciantes.anunciantes.index', $director));
});

// Home > advertisers
Breadcrumbs::register('advertisers', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Anunciantes', url('anunciantes'));
});

// Home > advertisers > {{ $advertiser }}
Breadcrumbs::register('advertisers.advertiser', function ($breadcrumbs, $advertiser) {
    $breadcrumbs->parent('advertisers');
    if ($advertiser->exists) {
        $breadcrumbs->push($advertiser->name, route('anunciantes.show', $advertiser));
    } else {
        $breadcrumbs->push('Nuevo Anunciante', route('anunciantes.create'));
    }
});

// Home > publishers
Breadcrumbs::register('publishers', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Medios', url('medios'));
});

// Home > publishers > {{ $publisher }}
Breadcrumbs::register('publishers.publisher', function ($breadcrumbs, $publisher) {
    $breadcrumbs->parent('publishers');
    if ($publisher->exists) {
        $breadcrumbs->push($publisher->company, route('medios.show', $publisher));
    } else {
        $breadcrumbs->push('Nuevo Medio', route('medios.create'));
    }
});

// Home > publishers > {{ $publisher }} > spaces
Breadcrumbs::register('publishers.publisher.spaces', function ($breadcrumbs, $publisher) {
    $breadcrumbs->parent('publishers.publisher', $publisher);
    $breadcrumbs->push('Espacios', route('medios.show', $publisher));
});

// Home > publishers > {{ $publisher }} > spaces > {{ $space }}
Breadcrumbs::register('spaces.space', function ($breadcrumbs, $space) {
    $breadcrumbs->parent('publishers.publisher.spaces', $space->publisher);
    if ($space->exists) {
        $breadcrumbs->push($space->name, route('espacios.show', $space));
    } else {
        $breadcrumbs->push('Nuevo Espacio', route('espacios.create'));
    }
});

// Home > spaces
Breadcrumbs::register('spaces', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Espacios', url('espacios'));
});

// Home > proposals
Breadcrumbs::register('proposals', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Propuestas', url('propuestas'));
});

// Home > proposals
Breadcrumbs::register('proposals.show', function ($breadcrumbs, $proposal) {
    $breadcrumbs->parent('proposals');
    $breadcrumbs->push($proposal->title, route('proposals.show', $proposal));
});

