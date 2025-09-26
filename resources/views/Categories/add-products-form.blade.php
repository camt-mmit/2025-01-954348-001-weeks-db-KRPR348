@extends('categories.main',[
'title' => $category->name,
'titleClasses' => ['app-cl-code'],
])



@section('header')
    <search>
        <form action="{{ route('categories.add-products-form', ['product' => $category->code,]) }}" method="get" class="app-cmp-search-form">
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
                <a href="{{ route('categories.view-products', ['product' => $category->code,]) }}">
<button type="button" class="app-cl-accent">X</button></a>
            </div>
        </form>
    </search>
    <div >
<form action="{{ route('categories.add-product', [
'product' => $category->code,
]) }}" id="app-form-add-product" method="post">
@csrf
</form></a>
    </div>
<ul class="app-cmp-links">
<li><a href="{{ session()->get('bookmarks.categories.view-product' 
,route('categories.list')) }}">&lt; Back </a></li>

{{ $categories->withQueryString()->links() }}
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
            session()->put('bookmarks.products.view',url()->full());
        @endphp

            @foreach ($categories as $product)
                <tr>
                    <td>
                        <a href="{{ route('categories.view', [
                            'product' => $product->code,
                        ]) }}"
                            class="app-cl-code">
                            {{ $product->code }}
                        </a>
                    </td>
                    <td>{{ $product->name }}</td>
                    <td >{{ $product->category->name }}</td>
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