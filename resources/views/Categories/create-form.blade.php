@extends('categories.main',[
'title' => 'Create',
])

@section('content')
    <form action="{{route('categories.create')}}" method="post">
        @csrf

        <label for="">
            <b>Code</b>
            <input type="text" name="code" required>
        </label><br>

        <label for="">
            <b>Name</b>
            <input type="text" name="name" required>
        </label><br>


        <label for="">
            <b>Description</b>
            <textarea name="description" id="" required cols="80" rows="10"></textarea>
        </label><br>

        <button type="submit">Create</button>
    </form>
@endsection