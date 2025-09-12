@extends('layouts.main',[
    'title' => "Products: {$title}", (isset($subTitle) ? " {$subTitle}" : ''),
    ])

@section('title')
    Products:
    <span @class($titleClasses ?? [])>{{ $title }}</span>
    @isset($subTitle)
    <span @class($titleClasses ?? [])>{{ $subTitle }}</span>
    @endisset
@endsection