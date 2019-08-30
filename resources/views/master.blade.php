<!-- master.blade.php -->

<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CRUD Operations</title>

        <!-- Fonts -->
        <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
		<link href="{{asset('css/chosen.min.css')}}" rel="stylesheet" type="text/css">
    </head>
    <body>
        <br><br>
        @yield('content')
    </body>
	<script type="text/javascript" src="{{ asset('js/chosen.jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min') }}"></script>
</html>