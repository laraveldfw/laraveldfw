<!doctype html>
<html>
<head>

    <meta charset="utf-8">

    <title>@yield('title', 'Laravel Dallas/Fort Worth')</title>
    <meta name="description" content="@yield('description', 'Laravel DFW is a community of application developers and designers that want to learn, communicate, and collaborate.')">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="google-site-verification" content="Oya4QNGKhL5X4zUOMDE1eFxAzosmSZS8dSq8L76kLVo" />

    {{-- Fonts and CSS --}}
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/css/angular-material.min.css" />
    @yield('css')

    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <script src="/js/angular.min.js"></script>
    @yield('headerScripts')

</head>
<body>

@yield('content')

<script src="{{ elixir('js/material.js') }}" type="text/javascript"></script>
@yield('footerScripts')
</body>
</html>