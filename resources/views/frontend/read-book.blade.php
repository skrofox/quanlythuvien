@extends('frontend.layout.app')

@section('title', 'Đọc Sách - ' . $book->name)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $book->name }}</h1>
            </div>
        </div>
    </div>
@endsection
