@extends('products.main', [
    'title' => $shop->name,
    'titleClasses' => ['app-cl-code'],
    'mainClasses' => ['app-ly-max-width'],
])

@section('header')
    <search>
        <form action="{{ route('shops.view-products', ['product' => $shop->code,]) }}" method="get" class="app-cmp-search-form">
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
                <a href="{{ route('shops.view-products',['product' =>$shop->code,]) }}">
                    <button type="button" class="accent">X</button>
                </a>
            </div>
        </form>
    </search>

<div class="app-cmp-links-bar">
        <nav>
<form action="{{ route('shops.remove-product', [
'product' => $shop->code,
]) }}" id="app-form-remove-product" method="post">
@csrf
</form>
<ul class="app-cmp-links">
<li><a href="{{ route('shops.view', [
'product' => $shop->code,
]) }}">&lt; Back</a></li>
<li><a href="{{ route('shops.add-products-form', [
'product' => $shop->code,
]) }}">&lt; Add Products</a></li>
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
                <th>Category</th>
                <th>Price</th>
                <th>No. of Shops</th>
                <th></th>
            </tr> 
        </thead>

        <tbody>

            @php
            session()->put('bookmarks.shops.view-products',url()->full());
            @endphp
            @php
            session()->put('bookmarks.categories.view',url()->full());
        @endphp
            @foreach ($shops as $product)
                <tr>
                    <td>
                        <a href="{{ route('products.view', [
                            'product' => $product->code,
                        ]) }}"
                            class="app-cl-code">
                            {{ $product->code }}
                        </a>
                    </td>
                    <td>{{ $product->name }}</td>
                    <td class="app-cl-number"><a href="{{ route('categories.view', [
                            'product' => $product->category->code,
                        ]) }}"
                            class="app-cl-code">{{ $product->category->name }}</a></td>
                    <td class="app-cl-number">{{ number_format($product->price, 2) }}</td>
                    <td class="app-cl-number">{{ $product->shops_count }}</td>
                    <td>
                        <button type="submit" form="app-form-remove-product" name="shop" value="{{ $product->code }}">Remove</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection