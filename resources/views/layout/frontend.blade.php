<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Car Rental Navbar</title>
        @vite('resources/css/app.css')
    </head>

    <body class="bg-gray-100">
        @include('components.frontend.navbar')
        @yield('content')

        @include('pages.frontend.footer')
    </body>
    <script src="http://unpkg.com/turbolinks"></script>

</html>
