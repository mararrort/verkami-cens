Se ha {{$petition->isUpdate() ? 'actualizado' : 'creado'}} un registro.

@if($petition->isUpdate())
El registro de la preventa {{$presale->getMarkdown()}} de la editorial {{ $editorial->getMarkdown()}} ha tenido estos cambios:
@if($petition->state != $presale->state)
\* El estado ha pasado de {{$presale->state}} a {{$petition->state}}
@endif
@if($petition->late != $presale->late)
\* Se ha marcado como {{$petition->late ? 'impuntual' : 'puntual'}}
@endif
@if($petition->start != $presale->start)
\* Se ha indicado como fecha de inicio {{$petition->start->format('Y-m')}}
@endif
@if($petition->announced_end != $presale->announced_end)
\* Se ha indicado como fecha final anunciada {{$petition->announced_end->format('Y-m')}}
@endif
@if($petition->end != $presale->end)
\* Se ha indicado como fecha final {{$petition->end->format('Y-m')}}
@endif
@else
Se ha registrado la preventa {{$presale->getMarkdown()}} de la editorial {{ $editorial->getMarkdown()}} con esta información:
\* Estado: {{$petition->state}}
@if($petition->late)
\* Impuntual
@endif
@if($petition->start)
\* Se ha indicado como fecha de inicio {{$petition->start->format('Y-m')}}
@endif
@if($petition->announced_end)
\* Se ha indicado como fecha final anunciada {{$petition->announced_end->format('Y-m')}}
@endif
@if($petition->end)
\* Se ha indicado como fecha final {{$petition->end->format('Y-m')}}
@endif
@endif

Con esta información, el registro de la editorial {{$editorial->getMarkdown()}} ha pasado a ser el siguiente:
\* Juegos pendientes de entregar: {{ $petition->isNewNotFinished() ? count($editorial->getNotFinishedPresales()) + 1 : count($editorial->getNotFinishedPresales()) }}
\* Juegos pendientes de entregar y con retraso: {{ ($petition->isNewNotFinished() && $petition->isNewLate()) ? count($editorial->getNotFinishedLatePresales()) + 1 : count($editorial->getNotFinishedLatePresales()) }}
