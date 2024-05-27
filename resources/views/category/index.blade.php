@extends('layouts.app')
@section('content')


    <div class="container">
        <div class="row">
            <div class="col-2">
                <a href="{{ route('category.create') }}" class="btn btn-primary btn_1">Add</a>
            </div>

        </div>
        <div
            class="row relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker dark:bg-dots-lighter
            dark:bg-gray-900 selection:bg-white-500 selection:text-white transparent-background">
            @foreach ($categories as $category)
                <div class="card col-3">
                    <div class="card-body ">
                        <h5 class="card-title">{{ $category->question }}</h5>
                        <p class="card-text">{{ $category->answer }}</p>
                        <p class="card-text">{{ $category->reselt }}</p>
                        <div class="ptn_parnt">
                            <a href="{{ route('category.edit', $category->id) }}" class="btn btn-success mx-2">Edit</a>
                            <a href="{{ route('category.destroy', $category->id) }}" class="btn btn-danger"
                                onclick="return confirm('Are tou sure')">delete</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>




    {{-- <main class="main"> --}}



    </main>
@endsection
