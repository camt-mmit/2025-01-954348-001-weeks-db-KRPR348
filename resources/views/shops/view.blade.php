@extends('shops.main', [
    'title' => $product ->name,
])

@section('header')
    <nav>
        <form action="{{ route('shops.delete', [
            'product' => $product->code,
        ]) }}" method="post"
            id="app-form-delete">
            @csrf
        </form>

        <ul class="app-cmp-links">
            <li>
                <a href="{{ session()->get('bookmarks.shops.view' ,route('shops.list')) }}">&lt; Back </a>
            </li>

            <li>
            <a href="{{ route('shops.view-products', [
            'product' => $product->code,
            ]) }}">View Products</a></li>
        <li>
            <li>
                <a
                    href="{{ route('shops.update-form', [
                        'product' => $product->code,
                    ]) }}">Update</a>
            </li>
            <li class="app-cl-warn">
                <button type="submit" form="app-form-delete" class="app-cl-link">Delete</button>
            </li>
        </ul>
    </nav>
@endsection

@section('content')
    <dl class="app-cmp-data-detail">
        <dt>Code</dt>
        <dd style="color: blue;"><b>
            <span class="app-cl-code">{{ $product->code }}</span>
</b></dd>

        <dt>Name</dt>
        <dd>
            {{ $product->name }}
        </dd>

        <dt>Owner</dt>
        <dd>
            {{ $product->owner }}
        </dd>

        <dt>Location</dt>
        <dd>
            <span class="app-cl-number">{{ $product->latitude }}, {{ $product->longitude }}</span>
        </dd>

        <dt>Address</dt>
        <dd>
            <pre  style="margin: 0px;">{{ $product->address }}</pre>
        </dd>
    </dl>

@endsection