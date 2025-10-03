@extends('layouts.main', [
    'title' => "Shops: {$title}" . (isset($subTitle) ? " {$subTitle}" : ''),
])

@section('title')
    Shops:
    <span @class($titleClasses ?? [])>{{ $title }}</span>
    @isset($subTitle)
        <span @class($subTitleClasses ?? [])>{{ $subTitle }}</span>
    @endisset
@endsection