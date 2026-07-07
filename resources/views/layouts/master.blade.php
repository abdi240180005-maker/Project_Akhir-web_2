<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Global Supply Chain Risk Intelligence</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="bg-light">

<div class="wrapper">

    @include('layouts.sidebar')

    <div class="main-content">

        @include('layouts.navbar')

        <div class="content-area">

            @yield('content')

        </div>

    </div>

</div>

@stack('scripts')

</body>

</html>