@extends('layouts.app')
@section('content')

@if(Session::has('error'))
    <h1  style="color:rgb(188, 46, 46); font-size:20px">{{session('error')}}</h1>
    {{ Session::forget('error') }}
@endif
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card text-dark bg-info mb-3">
                        <h2> Student Detection</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('students.store') }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label for="name"> Name </label>
                                <input type="text" name="name" id="question" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="description">Notes</label>
                                <input type="text" name="notes" id="answer" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="description">Grade</label>
                                <input type="number" name="grade" id="reselt" class="form-control">
                            </div>

                            <br>
                            <div class="mb-3">
                                <button type="submit"class="btn btn-primary">save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>






    </main>
@endsection
