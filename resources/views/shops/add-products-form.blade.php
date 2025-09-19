@extends('shops.main', [
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
            </div>

            <div class="app-cmp-form-actions">
                <button type="submit" class="primary">Search</button>
                <a href="{{ route('shops.view-products', ['product' => $shop->code,]) }}">
<button type="button" class="app-cl-accent">X</button></a>
            </div>
        </form>
    </search>
    <div >
<form action="{{ route('shops.add-product', [
'product' => $shop->code,
]) }}" id="app-form-add-product" method="post">
@csrf
</form></a>
    </div>
<ul class="app-cmp-links">
<li><a href="{{ route('shops.view-products', [
'product' => $shop->code,
]) }}">&lt; Back</a></li>

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
                    <td class="app-cl-number">{{ number_format($product->category_id, 0) }}</td>
                    <td class="app-cl-number">{{ number_format($product->price, 2) }}</td>
                    <td class="app-cl-number">{{ $product->shops_count }}</td>
                    <td>
                        <button type="submit" form="app-form-add-product" name="shop" 
                        value="{{ $product->code }}">Add</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection