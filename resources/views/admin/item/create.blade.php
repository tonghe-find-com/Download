@extends('core::admin.master')

@section('title', __('New download'))

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'downloads'])
        <h1 class="header-title">@lang('New download')</h1>
    </div>

    {!! BootForm::open()->action(route('admin::index-downloads'))->multipart()->role('form') !!}
        @include('downloads::admin.item._form')
    {!! BootForm::close() !!}

@endsection
