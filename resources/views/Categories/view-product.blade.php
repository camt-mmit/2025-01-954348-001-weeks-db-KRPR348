@extends('categories.main',[
'title' => $category->code,
'titleClasses' => ['app-cl-code'],
])

@section('header')
<nav>
    <search class="app-cmp-search-form">
        <form action="{{route('categories.view-products',['product' =>$category->code,]) }}" method="get">
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
            <a href="{{route('categories.view',['product' =>$category->code,]) }}">&lt; Back</a>
        </ul>
    </nav>
</div>

@endsection
@section('content')
<table class="app-cmp-data-list">
    <thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Price</th>
            <th>No. of Shops</th>
        </tr>
    </thead>
    @foreach($shops as $product)
    <tr>
        <td>
            <a href="{{route('shops.view',[
            'product' => $product->code,]) }}">
                {{ $product->code }}
            </a>
        </td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->price }}</td>
        <td>{{ $product->shops_count,0}}</td>
    </tr>
    @endforeach
    <tbody>

    </tbody>
</table>
@endsection