@extends('admin.advertisers.lists')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('advisers.adviser.advertisers', $adviser) !!}
@endsection

@section('urlSearch') {{ $urlSearch }}@endsection