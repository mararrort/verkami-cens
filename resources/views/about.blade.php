@extends('base')

@section('body')
<h1>Sobre esta web</h1>
<p>La intención de esta web es mantener un registro sobre el estado de las preventas
de rol en españa, de forma que ayude a les consumidores a valorar si confían en sumarse.</p>
<p>Puedes escribirme a través de <a href="https://twitter.com/roltrasos">mi cuenta de Twitter</a> o <a href="t.me/SafeForCrowdfunding">grupo de Telegram</a>.
<p>Puedes mantenerte al día de los cambios a través de <a href="t.me/roltrasos_bot">nuestro bot</a>.</p>
<p>El software de la web es código abierto bajo la licencia GPLv3 al que puedes acceder en <a href="https://github.com/mararrort/verkami-cens">GitHub</a></p>

<h2>Actualización sobre el estado "Tardío"</h2>
<p>El día 2021/04/12 se añadió la opción de configurar fechas de las preventas, 
incluyendo fecha de entrega anunciada y fecha de entrega (real). Dada esta 
actualización, indicar manualmente si una entrega ha sido tardía o no es 
redundante, pero a día de escribir esto (2021/04/14) no hay suficientes
preventas con esa información como para eliminarla completamente.</p>
<p>Cuando al menos dos tercios de las preventas dispongan de esa información,
se hará una actualización para eliminar el campo sobre si la preventa es o no
tardía. <b>Actualmente disponemos de esa información en {{$datedPresales}}
de {{$presales}} preventas. Faltan {{intval(($presales/3*2)-$datedPresales)}}
preventas con la información de fechas para hacer la actualización</b></p>

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