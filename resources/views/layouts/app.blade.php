<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Projects</title>
    @vite(['resources/hs/app.js'])
</head>
<body>
    <div class="d-flex">
        @include('layouts.partials.navbar')
    </div>
    
<main>
    <div class="container">
        <div class="d-flex justify-content-between align-items-start my-5">
            <h1>
                @yield('title')
            </h1>

            @yield('actions')


            @if (session('message'))
            <div class="alert alert-succes">
                {{ session('message')}}
            </div>
            @endif

            @yield('content')

        </div>
    </div>
</main>


@yield('modals')
</body>
</html>