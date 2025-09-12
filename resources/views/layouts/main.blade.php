<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}" />
    <title>DB - {{ $title }} </title>
</head>

<body>
    <header id="app-cmp-main-header">
        <h1>DB - <span @class($titleclasses ?? [])>{{ $title }}</span></h1>
        <nav>
            <ul class="app-cmp-links">
                <li><a href="{{ route('products.list') }}">Products</a>
                </li>
                <li >
                    <a href="{{route('categories.list')}}">Category</a>
                </li>
                <li><a href="{{ route('shops.list') }}">Shops</a>
                </li>
            </ul>
        </nav>
    </header>


    <main id="app-cmp-main-content">
        <header>
            <h1>{{ $title }}</h1>
            @yield('header')
        </header>
        @yield('content')
    </main>

    <footer id="app-cmp-main-footer">
        &#xA9; Copyright Week-07, 2025 Krittapol's DB.
    </footer>
</body>

</html>