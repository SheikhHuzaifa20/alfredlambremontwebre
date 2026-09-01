<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Alfred Lambremont Webre — Books, Exopolitics &amp; the Omniverse</title>
    <meta name="description"
        content="Official site of Alfred Lambremont Webre, JD, MEd — founder of Exopolitics and author of The Omniverse.">

    @include('layouts.front.css')
    @yield('css')
</head>

<body class="responsive">

    @include('layouts.front.header')

    @yield('content')

    @include('layouts.front.footer')

    @include('layouts.front.scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
    @yield('js')

</body>

</html>
