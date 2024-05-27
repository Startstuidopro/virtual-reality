@extends('layouts.app')

@section('content')


@if(Session::has('error'))
    <h1  style="color:red; font-size:20px">{{session('error')}}</h1>
    {{ Session::forget('error') }}
@endif


<main class="main">
<br>
<div class="card">
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card text-dark bg-info mb-3">
                    <h2>   Eidit The Grade  </h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('students.update',$temp->id) }}" method="POST">

                        @csrf
                        <div class="form-group">
                            <label for="grade">Grade</label>
                            <input type="text" name="grade" id="grade" class="form-control"  value="{{$temp->grade}}">
                            @error('grade') <span class="text-danger">{{$message}}</span>@enderror

                        </div>

                        <br>
                        <div class="mb-3">
                            <button type="submit"class="btn btn-primary">update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

