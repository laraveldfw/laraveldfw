<!doctype html>
<head>
    <meta charset="utf-8">

    <title>@yield('title', 'Laravel Dallas/Fort Worth')</title>
    <meta name="description" content="@yield('description', 'Laravel DFW is a community of application developers and designers that want to learn, communicate, and collaborate.')">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="google-site-verification" content="Oya4QNGKhL5X4zUOMDE1eFxAzosmSZS8dSq8L76kLVo" />

    {{-- Fonts and CSS --}}
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600,700' rel='stylesheet' type='text/css'>
    <link type="text/css" rel="stylesheet" href="css/main.css">

    {{-- Font Awesome --}}
    <link type="text/css" rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css">

    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    @yield('head')
</head>
<body>

@yield('content')

{{-- Remote jQuery with local fallback --}}
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script>
    if (typeof jQuery == 'undefined') {
        document.write(unescape("%3Cscript type='text/javascript' src='/js/jquery.min.js' %3E%3C/script%3E"));
    }
</script>

{{-- Bootstrap JavaScript --}}
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/backstretch.min.js"></script>
@yield('footer')
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-44363207-1', 'laraveldfw.com');
    ga('send', 'pageview');
</script>

</body>
</html>
