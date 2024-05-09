{{-- @extends('layouts.app')
 @extends('frontend.inc.header')

@section('content') --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>profile </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>

{{-- <main class="main"> --}}



{{-- </main>
@endsection --}}
