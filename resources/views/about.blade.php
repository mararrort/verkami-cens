@extends('base')

@section('body')
<h1>Sobre esta web</h1>
<p>La intención de esta web es mantener un registro sobre el estado de las preventas
de rol en españa, de forma que ayude a les consumidores a valorar si confían en sumarse.</p>
<p>La web se encuentra actualmente en estado Beta. El feedback es muy importante. Puedes escribirme
a través de <a href="https://twitter.com/roltrasos">mi cuenta de Twitter</a>

@auth
    @if(count($privateTodo) > 0)
    <h2 dusk="privateTodo">Características privadas de implementar</h2>
    <ul>
        @foreach($privateTodo as $todo)
        <li>
            {{$todo->text}}        
            <a dusk="editTodo" href="{{route('todo.edit', ['todo' => $todo])}}"><i class="bi bi-pencil"></i></a>
            <form method="POST" action="{{route('todo.destroy', ['todo' => $todo])}}">@csrf @method('DELETE')<input type="submit" value="Eliminar" dusk="deleteTodo"></form>
        </li>
        @endforeach
    </ul>
    @endif
@endauth

@if(count($publicTodo) > 0)
<h2 dusk="publicTodo">Características pendientes de implementar</h2>
<ul>
    @foreach($publicTodo as $todo)
    <li>
        {{$todo->text}}
        @auth
        <a dusk="editTodo" href="{{route('todo.edit', ['todo' => $todo])}}"><i class="bi bi-pencil"></i></a>
        <form method="POST" action="{{route('todo.destroy', ['todo' => $todo])}}">@csrf @method('DELETE')<input type="submit" value="Eliminar" dusk="deleteTodo"></form>
        @endauth
    </li>    
    @endforeach
</ul>
@endif

@if(count($undefinedTodo) > 0)
<h2 dusk="undecidedTodo">Características que se debaten sobre si implementar</h2>
<ul>
    @foreach($undefinedTodo as $todo)
    <li>
        {{$todo->text}}
        @auth
        <a dusk="editTodo" href="{{route('todo.edit', ['todo' => $todo])}}"><i class="bi bi-pencil"></i></a>
        <form method="POST" action="{{route('todo.destroy', ['todo' => $todo])}}">@csrf @method('DELETE')<input type="submit" value="Eliminar" dusk="deleteTodo"></form>
        @endauth
    </li>
    @endforeach
</ul>
@endif

<h2>Condiciones para que se contemple añadir una Característica</h2>
<p>Mi filosofía es "Simplicidad". Que las herramientas hagan el mínimo y de la mejor forma.
No se valorará añadir ninguna característica que viole este principio. Por ejemplo, esto no es
una red social y no se implementará un foro ni un chat.</p>

<p>Para que se valore añadir algo o modificar algo existente debe cumplir estas condiciones:
<ul>
    <li><b>La complejidad de la web no aumenta.</b> En caso de que aumente, el aumento debe
        ser menor que la ganancia. Un cambio que implique un gran aumento de complejidad a
        cambio de una leve mejora será descartado. <em>Ejemplo: Añadir una IA que monitorice
        todas las preventas y mantenga la web automáticamente actualizada sin necesidad de 
        rellenar formularios aumenta levemente la ganancia, pero enormemente la complejidad, 
        por lo que no se haría.</em></li>
    <li><b>Está directamente relacionado con el propósito de la página.</b> El mundo del rol 
    es muy extenso, pero esta web es únicamente para mantener seguimiento de las preventas.
    <em>Ejemplo: Añadir un apartado de noticias sobre las preventas añadiría más información,
    pero no estaría realmente relacionada. Nos importa saber cuantas preventas hay pendientes de
    entregar, no guardar las publicaciones en Twitter del editor en las que enseña partidas de prueba</em>
</ul>

@auth
<a href="{{route('todo.create')}}">Añadir TODO</a>
@endauth
@endsection