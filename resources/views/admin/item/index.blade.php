@extends('core::admin.master')

@section('title', __('Downloads'))

@section('content')

<item-list
    url-base="/api/downloads"
    locale="{{ config('typicms.content_locale') }}"
    fields="id,status,title,position,updated_at,show_date"
    table="downloads"
    title="downloads"
    include=""
    appends=""
    :exportable="false"
    :searchable="['title']"
    :sorting="['position']">

    <template slot="add-button" v-if="$can('create downloads')">
        @include('core::admin._button-create', ['module' => 'downloads'])
    </template>

    <template slot="columns" slot-scope="{ sortArray }">
        <item-list-column-header name="checkbox" v-if="$can('update downloads')||$can('delete downloads')"></item-list-column-header>
        <item-list-column-header name="edit" v-if="$can('update downloads')"></item-list-column-header>
        <item-list-column-header name="status_translated" sortable :sort-array="sortArray" :label="$t('Status')"></item-list-column-header>
        <item-list-column-header name="position" sortable :sort-array="sortArray" :label="$t('Position')"></item-list-column-header>
        <item-list-column-header name="show_date" sortable :sort-array="sortArray" :label="$t('顯示日期')"></item-list-column-header>
        <item-list-column-header name="title_translated" sortable :sort-array="sortArray" :label="$t('Title')"></item-list-column-header>
        <item-list-column-header :label="$t('Last Update Time')"></item-list-column-header>
    </template>

    <template slot="table-row" slot-scope="{ model, checkedModels, loading }">
        <td class="checkbox" v-if="$can('update downloads')||$can('delete downloads')"><item-list-checkbox :model="model" :checked-models-prop="checkedModels" :loading="loading"></item-list-checkbox></td>
        <td v-if="$can('update downloads')">@include('core::admin._button-edit', ['module' => 'downloads'])</td>
        <td><item-list-status-button :model="model"></item-list-status-button></td>
        <td><item-list-position-input :model="model"></item-list-position-input></td>
        <td>@{{ getDate(model.show_date) }}</td>
        <td v-html="model.title_translated"></td>
        <td>@{{ getMoment(model.updated_at ) }}</td>
    </template>

</item-list>

@endsection
