<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title> 
    <!-- Styles -->
    <link href="{{CSS}}app.css" rel="stylesheet">
    <link href="{{CSS}}common.css" rel="stylesheet">
 

</head>
<body class="hold-transition login-page">
<div class="login-box">
   @yield('content')  
</div> 
<!-- Scripts -->
<script src="{{JS}}app.js"></script>
</body>
</html>
