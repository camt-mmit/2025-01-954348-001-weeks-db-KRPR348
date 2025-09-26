@extends('products.main',[
'title' => $category->name,
'titleClasses' => ['app-cl-code'],
])

@section('header')
<nav>
    <search >
        <form action="{{route('categories.view-products',['product' =>$category->code,]) }}" method="get" class="app-cmp-search-form">
            <div class="app-cmp-form-detail">
                <label for="app-criteria-term">Search</label>
                <input type="text" id="app-criteria-term" name="term" value="{{ $criteria['term'] }}" />

                <label for="app-criteria-min-price">Min Price</label>
                <input type="number" id="app-criteria-min-price" name="minPrice" value="{{ $criteria['minPrice'] }}"
                    step="any" />

                <label for="app-criteria-max-price">Max Price</label>
                <input type="number" id="app-criteria-max-price" name="maxPrice" value="{{ $criteria['maxPrice'] }}"
                    step="any" />
            </div>

            <div class="app-cmp-form-actions">
                <button type="submit" class="primary">Search</button>
                <a href="{{ route('categories.view-products',['product' =>$category->code,]) }}">
                    <button type="button" class="accent">X</button>
                </a>
            </div>
        </form>
    </search>

</nav>
<div class="app-cmp-links-bar">
    <nav>
<ul class="app-cmp-links">
<li><a href="{{ route('categories.view', [
'product' => $category->code,
]) }}">&lt; Back</a></li>
<li><a href="{{ route('categories.add-products-form', [
'product' => $category->code,
]) }}"> Add Products</a></li>
</nav>

{{ $shops->withQueryString()->links() }}
    </div>

@endsection
@section('content')
<table class="app-cmp-data-list">
    <colgroup>
            <col style="width: 5ch;" />
            <col />
            <col />
            <col style="width: 4ch"/>
        </colgroup>
    <thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Price</th>
            <th>No. of Shops</th>
        </tr>
    </thead>
    <tbody>

        @php
            session()->put('bookmarks.categories.view-product',url()->full());
        @endphp

    @foreach($shops as $product)
    <tr>
        <td>
            <a href="{{route('products.view',[
            'product' => $product->code,]) }}"class="app-cl-code">
                {{ $product->code }}
            </a>
        </td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->price }}</td>
        <td>{{ $product->shops_count}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
@endsection