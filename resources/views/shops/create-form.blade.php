@extends('products.main', [
    'title' => 'Create',
])

@section('content')
    <form action="{{ route('shops.create') }}" method="post">
        @csrf

        <div class="app-cmp-form-detail">
            <label for="app-inp-code">Code</label>
            <input type="text" id="app-inp-code" name="code" required />

            <label for="app-inp-name">Name</label>
            <input type="text" id="app-inp-name" name="name" required />

            <label for="app-inp-price">Owner</label>
            <input type="text" id="app-inp-price" name="owner" required />

            <label for="app-inp-price">Latitude</label>
            <input type="number" id="app-inp-price" name="latitude" step="any" required />

            <label for="app-inp-price">Longitude</label>
            <input type="number" id="app-inp-price" name="longitude" step="any" required />

            <label for="app-inp-address">Address</label>
            <textarea id="app-inp-address" name="address" cols="80" rows="10" required></textarea>
        </div>

        <div class="app-cmp-form-actions">
            <button type="submit">Create</button>
        </div>
    </form>
@endsection