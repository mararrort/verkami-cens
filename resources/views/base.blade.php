<html>
    <head>
        <title>@section('title')Censo de Preventas @show</title>
        <meta name="author" content="Mar Arribas">
        <meta name="description" content="@section('description')Censo de preventas de editoriales de rol españolas @show">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('editoriales.index')}}">Editoriales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('preventas.index')}}">Preventas</a>
                    </li>
                </ul>
            </nav>
            @yield('body')
        </div>
    </body>
</html>