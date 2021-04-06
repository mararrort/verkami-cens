@extends('base')

@section('body')
<h1>Sobre esta web</h1>
<p>La intención de esta web es mantener un registro sobre el estado de las preventas
de rol en españa, de forma que ayude a les consumidores a valorar si confían en sumarse.</p>
<p>La web se encuentra actualmente en estado Beta. El feedback es muy importante. Puedes escribirme
a través de <a href="https://twitter.com/mararrort">mi cuenta de Twitter</a>

<h2>Características pendientes de implementar</h2>
<ul>
    <li>Vincular a cuenta de Twitter que envíe un tweet cada vez que haya una actualización.</li>
    <li>Añadir un campo de texto a las peticiones de actualización justificándola con enlaces a noticias, tweets o similares.</li>
    <li>Añadir un campo de texto a las peticiones de actualización o adición donde le peticionarie pueda introducir su alias de twitter para ser reconocide por el trabajo</li>
    <li>Cambiar el enlace de las editoriales para que dirija al listado de sus preventas en lugar de a su web</li>
</ul>

<h2>Características que se debaten sobre si implementar</h2>
<ul>
    <li>Unificar todas las preventas en una sola tabla y añadir una columna de estado</li>
    <li>Añadir columnas de fecha de entrega anunciada y fecha de entrega real</li>
    <li>Añadir una columna en las preentas indicando en que plataforma se ha realizado</li>
</ul>

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
@endsection