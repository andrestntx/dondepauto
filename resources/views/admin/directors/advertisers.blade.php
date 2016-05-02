@extends('admin.advertisers.lists')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('directors.director.advertisers', $director) !!}
@endsection

@section('urlSearch') {{ $urlSearch }}@endsection