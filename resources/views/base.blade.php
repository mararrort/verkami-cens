<html>
    <head>
        <title>@section('title')Censo de Preventas @show</title>
        <meta name="author" content="Mar Arribas">
        <meta name="description" content="@section('description')Censo de preventas de editoriales de rol españolas @show">
        <link href="/css/app.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
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
            </nav>
            @yield('body')
        </div>
    </body>
    @yield('js')
</html>