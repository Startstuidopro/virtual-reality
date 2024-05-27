@extends('layouts.app')
@section('content')
@if(Session::has('error'))
    <h1  style="color:rgb(188, 46, 46); font-size:20px">{{session('error')}}</h1>
    {{ Session::forget('error') }}
@endif

    <div class="container">
        <div class="row">
            <div class="col-2">
                <a href="{{ route('students.create') }}" class="btn btn-primary btn_1">Add</a>
            </div>

        </div>
        <div
            class="row relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker dark:bg-dots-lighter
            dark:bg-gray-900 selection:bg-white-500 selection:text-white transparent-background">
            @foreach ($students as $category)
                <div class="card col-3">
                    <div class="card-body ">
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <p class="card-text">{{ $category->notes }}</p>
                        <p class="card-text">{{ $category->grade }}</p>
                        <div class="ptn_parnt">
                            <a href="{{ route('students.edit', $category->id) }}" class="btn btn-success mx-2">Edit</a>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>




    {{-- <main class="main"> --}}



    </main>
@endsection
