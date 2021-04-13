Se ha {{$petition->isUpdate() ? 'actualizado' : 'creado'}} un registro.

@if($petition->isUpdate())
El registro de la preventa {{$presale->getMarkdown()}} de la editorial {{ $editorial->getMarkdown()}} ha tenido estos cambios:
    @if($petition->state != $presale->state)
\* El estado ha pasado de {{$petition->state}} a {{$presale->state}}
    @endif
    @if($petition->late != $presale->late)
\* Se ha marcado como {{$presale->late ? 'impuntual' : 'puntual'}}
    @endif
    @if($petition->start != $presale->start)
\* Se ha indicado como fecha de inicio {{$presale->start->format('Y-m')}}
    @endif
    @if($petition->announced_end != $presale->announced_end)
\* Se ha indicado como fecha final anunciada {{$presale->announced_end->format('Y-m')}}
    @endif
    @if($petition->end != $presale->end)
\* Se ha indicado como fecha finak {{$presale->end->format('Y-m')}}
    @endif
@else
Se ha registrado la preventa {{$presale->getMarkdown()}} de la editorial {{ $editorial->getMarkdown()}} con esta información:
\* Estado: {{$presale->state}}
    @if($presale->late)
\* Impuntual
    @endif
    @if($presale->start)
\* Se ha indicado como fecha de inicio {{$presale->start->format('Y-m')}}
    @endif
    @if($presale->announced_end)
\* Se ha indicado como fecha final anunciada {{$presale->announced_end->format('Y-m')}}
    @endif
    @if($presale->end)
\* Se ha indicado como fecha final {{$presale->end->format('Y-m')}}
    @endif
@endif

Con esta información, el registro de la editorial {{$editorial->getMarkdown()}} ha pasado a ser el siguiente:
\* Juegos pendientes de entregar: {{count($editorial->getNotFinishedPresales())}}
\* Juegos pendientes de entregar y con retraso: {{count($editorial->getNotFinishedLatePresales())}}
