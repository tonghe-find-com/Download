@push('js')
    <script src="{{ asset('components/ckeditor4/ckeditor.js') }}"></script>
    <script src="{{ asset('components/ckeditor4/config-full.js') }}"></script>
@endpush

@component('core::admin._buttons-form', ['model' => $model])
@endcomponent

{!! BootForm::hidden('id') !!}

<file-manager related-table="{{ $model->getTable() }}" :related-id="{{ $model->id ?? 0 }}"></file-manager>
<files-field :init-files="{{ $model->files }}"></files-field>

<div class="row gx-3">
    <div class="col-md-6">
        {!! TranslatableBootForm::text(__('Title'), 'title') !!}
    </div>
    <div class="col-sm-6">
        {!! BootForm::date(__('Show Date'), 'show_date')->value(old('show_date') ? : $model->present()->dateOrNow('show_date'))->addClass('datepicker')->required() !!}
    </div>
</div>

<div class="mb-3">
    {!! TranslatableBootForm::hidden('status')->value(0) !!}
    {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
</div>

{!! BootForm::select(__('Category'), 'category_id', Downloadcategories::allForSelect()) !!}
