@extends('layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.pagenotfound') }}
@endsection

@section('contentheader_title')
    {{ trans('adminlte_lang::message.404error') }}
@endsection

@section('$contentheader_description')
@endsection

@section('main-content')

<div class="error-page">
    <h2 class="headline text-yellow"> 404</h2>
    <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> Oops! {{ trans('adminlte_lang::message.pagenotfound') }}.</h3>
        <p>
            {{ trans('adminlte_lang::message.notfindpage') }}
            {{ trans('adminlte_lang::message.mainwhile') }} <a href='{{ url('/dashboard') }}'>{{ trans('adminlte_lang::message.returndashboard') }}</a> {{ trans('adminlte_lang::message.usingsearch') }}
        </p>
       
    </div><!-- /.error-content -->
</div><!-- /.error-page -->
@endsection