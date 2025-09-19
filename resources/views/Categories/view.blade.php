@extends('categories.main',[
'title' => $product->name,
])
@section('header')
<nav>
    <form action="{{route('categories.delete',[
        'product' => $product->code,
    ])}}" method="post" id="app-form-delete">
        @csrf
    </form>
    <ul class="app-cmp-links">
        <li >
            <a href="{{route('categories.update-form',[
            'product' => $product->code,
            ])}}">Update</a>
        </li>

        <li >
            <a href="{{ route('categories.view-products', [
            'product' => $product->code,
            ]) }}">View Products</a></li>
        <li class="app-cl-warn">
            <button type="submit" form="app-form-delete" class="app-cl-link">Delete</button>
        </li>
    </ul>
</nav>
@endsection
@section('content')
<dl class="app-cmp-data-detail">
    <dt>Code</dt>
    <dd>
        {{ $product->code }}
    </dd>

    <dt>Name</dt>
    <dd>
        {{ $product->name }}
    </dd>


    <dt>Description</dt>
    <dd>
        <pre>{{ $product->description }}</pre>
    </dd>
</dl>

@endsection