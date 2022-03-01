@extends('core::admin.master')

@section('title', __('New downloadcategory'))

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'downloadcategories'])
        <h1 class="header-title">@lang('New downloadcategory')</h1>
    </div>

    {!! BootForm::open()->action(route('admin::index-downloadcategories'))->multipart()->role('form') !!}
        @include('downloads::admin.category._form')
    {!! BootForm::close() !!}

@endsection
