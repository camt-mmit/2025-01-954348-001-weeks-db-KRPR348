@extends('shops.main', [
    'title' => $product->code,
    'titleClasses' => ['app-cl-code'],

    'mainClasses' => ['app-ly-max-width'],
])

@section('header')
    <search>
        <form action="{{ route('products.view-shops', ['product' => $product->code,]) }}" method="get" class="app-cmp-search-form">
            <div class="app-cmp-form-detail">
                <label for="app-criteria-term">Search</label>
                <input type="text" id="app-criteria-term" name="term" value="{{ $criteria['term'] }}" />
            </div>

            <div class="app-cmp-form-actions">
                <button type="submit" class="primary">Search</button>
                <a href="{{ route('products.view-shops', ['product' => $product->code,]) }}">
<button type="button" class="app-cl-accent">X</button></a>
            </div>
        </form>
    </search>

    <div class="app-cmp-links-bar">
        <nav>
<form action="{{ route('products.remove-shop', [
'product' => $product->code,
]) }}" id="app-form-remove-shop" method="post">
@csrf
</form>
<ul class="app-cmp-links">
<li><a href="{{ route('products.view', [
'product' => $product->code,
]) }}">&lt; Back</a></li>
<li><a href="{{ route('products.add-shops-form', [
'product' => $product->code,
]) }}">&lt; Add Shops</a></li>
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
                <th>Owner</th>
                <th>No. of Products</th>
            </tr>
        </thead>

        <tbody>
            @php
            session()->put('bookmarks.products.view-shops',url()->full());
            session()->put('bookmarks.shops.view',url()->full());
        @endphp

            @foreach ($shops as $shop)
                <tr>
                    <td><b>
                        <a href="{{ route('shops.view', [
                            'product' => $shop->code,
                        ]) }}"
                            class="app-cl-code">
                            {{ $shop->code }}
                        </b></a>
                    </td>
                    <td>{{ $shop->name }}</td>
                    <td>{{ $shop->owner }}</td>
                    <td class="app-cl-number">{{  number_format($shop->products_count,0) }}</td>
                    <td>
                        <button type="submit" form="app-form-remove-shop" name="shop" value="{{ $shop->code }}">Remove</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection