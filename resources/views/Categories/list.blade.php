@extends('Categories.main', [
    'title' => 'List',
    'mainClasses' => ['app-ly-max-width'],
])

@section('header')

@section('header')
    <search>
        <form action="{{ route('categories.list') }}" method="get" class="app-cmp-search-form">
            <div class="app-cmp-form-detail">
                <label for="app-criteria-term">Search</label>
                <input type="text" id="app-criteria-term" name="term" value="{{ $criteria['term'] }}" />
            </div>




            <div class="app-cmp-form-actions">
                <button type="submit" class="primary">Search</button>
                <a href="{{ route('categories.list') }}">
                    <button type="button" class="accent">X</button>
                </a>
            </div>
        </form>
    </search>

    <div class="app-cmp-links-bar">
        @php
            session()->put('bookmarks.categories.create-form',url()->full());
        @endphp

        <nav>
            <ul class="app-cmp-links">
                <li>
                    <a href="{{ route('categories.create-form') }}">New Category</a>
                </li>
            </ul>
        </nav>

        {{ $category->withQueryString()->links() }}
    </div>
@endsection

@section('content')
    <table class="app-cmp-data-list">
        <colgroup>
            <col style="width: 5ch;" />
        </colgroup>

        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>No. of Shops</th>
            </tr>
        </thead>

        <tbody>
            @php
            session()->put('bookmarks.categories.view',url()->full());
        @endphp
            @foreach ($category as $product)
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
                    <td class="app-cl-number">{{ $product->products_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection