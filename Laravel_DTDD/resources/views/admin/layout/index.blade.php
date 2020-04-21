<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Quản Lý - Đơn Hàng</title>

    <base href="{{ asset('') }}">

    <meta charset="utf-8">
    <script src="DiDongZin/assets/js/jquery-3.5.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="DiDongZin/assets/img/logo-min.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="DiDongZin/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="DiDongZin/assets/css/manage.css">
    <!--open lib animation...........................................................................-->
    <link rel="stylesheet" type="text/css" href="DiDongZin/assets/css/animate.css">
</head>

<body>
    
    @include('admin.layout.header')
    
    @include('admin.layout.menu')

    @yield('content')

    @yield('script')
    
</body>
<script src="DiDongZin/assets/js/manage.js"></script>

</html>
