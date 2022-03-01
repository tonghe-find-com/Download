@foreach ($list as $item)
    @foreach ($item->files as $fileItem)
        {{ $item->show_date->format('Y/m/d') }}
        {{$item->category->title}}
        {{$item->title}}
        {{ Storage::url($fileItem->path) }}
    @endforeach
@endforeach