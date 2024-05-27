@extends('layouts.app')

@section('content')


@if(Session::has('error'))
    <h1  style="color:rgb(254, 254, 254); font-size:20px">{{session('error')}}</h1>
    {{ Session::forget('error') }}
@endif

    <br>
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card text-dark bg-info mb-3">
                        <h2> Add A Questions </h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('category.store') }}" method="post">
                            @csrf
                            {{-- <input  accept="image/*" type='file' id="imgInp" />
                        <img id="blah" src="#" alt="your image" /> --}}
                            <div class="form-group">
                                <label for="name">  Question </label>
                                <input type="text" name="question" id="question" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="description">Answer</label>
                                <input type="text" name="answer" id="answer" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="description">Reselt</label>
                                <input type="number" name="reselt" id="reselt" class="form-control">
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
@endsection
<script>
    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
    }
</script>
