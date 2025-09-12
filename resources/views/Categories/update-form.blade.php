@extends('categories.main',[
'title' => $product->code,
])

@section('content')
    <form action="{{route('categories.update',[
        'product' => $product->code,
    ])}}" method="post">
        @csrf

        <label for="">
            <b>Code</b>
            <input type="text" name="code" require value="{{$product->code}}">
        </label><br>

        <label for="">
            <b>Name</b>
            <input type="text" name="name" require value="{{$product->name}}">
        </label><br>


        <label for="">
            <b>Description</b>
            <textarea name="description" id="" require cols="80" rows="10">{{$product->description}}</textarea>
        </label><br>

        <button type="submit">Update</button>
    </form>
@endsection