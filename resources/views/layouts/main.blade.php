<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Alfred Lambremont Webre — Books, Exopolitics &amp; the Omniverse</title>
    <meta name="description" content="Official site of Alfred Lambremont Webre, JD, MEd — founder of Exopolitics and author of The Omniverse.">

    @include('layouts.front.css')
    @yield('css')
</head>
<body class="responsive">

    @include('layouts.front.header')

    @yield('content')

    @include('layouts.front.footer')

    @include('layouts.front.scripts')
    @yield('js')

</body>
</html>
