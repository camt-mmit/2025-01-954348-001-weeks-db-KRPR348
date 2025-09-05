@extends('products.main', [
    'title' => $product->code,
])

@section('content')
    <form action="{{ route('shops.update',[
    'product' => $product->code,
    ]) }}" method="post">
        @csrf

        <div class="app-cmp-form-detail">
            <label for="app-inp-code">Code</label>
            <input type="text" id="app-inp-code" name="code" required value="{{$product->code}}"/>

            <label for="app-inp-name">Name</label>
            <input type="text" id="app-inp-name" name="name" required value="{{$product->name}}"/>

            <label for="app-inp-price">Owner</label>
            <input type="text" id="app-inp-price" name="owner" required value="{{$product->owner}}"/>

            <label for="app-inp-price">Latitude</label>
            <input type="number" id="app-inp-price" name="latitude" required value="{{$product->latitude}}"/>

            <label for="app-inp-price">Longitude</label>
            <input type="number" id="app-inp-price" name="longitude" required value="{{$product->longitude}}"/>

            <label for="app-inp-address">Address</label>
            <textarea id="app-inp-address" name="address" cols="80" rows="10" required >{{$product->address}}</textarea>
        </div>

        <div class="app-cmp-form-actions">
            <button type="submit">Create</button>
        </div>
    </form>
@endsection