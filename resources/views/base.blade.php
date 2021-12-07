<html>

<head>
    <title>@section('title')Censo de Preventas @show</title>
    <meta name="author" content="Mar Arribas">
    <meta name="description" content="@section('description')Censo de preventas de editoriales de rol españolas @show">
    <link href="/css/app.css" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="/">
                <i class="bi bi-dice-1"></i>
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('editorial.index')}}">Editoriales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('presales.index')}}">Preventas</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('petition.index')}}">Peticiones</a>
                    </li>
                    @endauth
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('info')}}">Info</a>
                    </li>
                </ul>
            </div>
        </nav>
        @yield('body')
    </div>
</body>
@yield('js')

</html>