@extends('layouts.app')

@section('content')
<main class="main">
<br>
<div class="card">
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card text-dark bg-info mb-3">
                    <h2>  تعديل الفئه  </h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('category.update',$temp->id) }}" method="POST">

                        @csrf


                        <div class="form-group">
                            <label for="name"> Question </label>
                            <input type="text" name="question" id="question" class="form-control" value="{{$temp->question}}">
                            @error('question') <span class="text-danger">{{$message}}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="answer">Answer</label>
                            <input type="text" name="answer" id="answer" class="form-control"  value="{{$temp->answer}}">
                            @error('answer') <span class="text-danger">{{$message}}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="reselt">Reselt</label>
                            <input type="text" name="reselt" id="reselt" class="form-control"  value="{{$temp->reselt}}">
                            @error('reselt') <span class="text-danger">{{$message}}</span>@enderror
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

