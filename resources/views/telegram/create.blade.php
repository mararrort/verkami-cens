Se ha creado una petición de {{$petition->isUpdate() ? 'actualización' : 'creación'}}.

@if ($petition->isUpdate())
 \* Preventa: {{$petition->presale->getMarkdown()}}
 \* Editorial: {{$petition->editorial->getMarkdown()}}
 \* Estado:
   \* Actual: {{$petition->presale->state}}
   \* Propuesto: {{$petition->state}}
 \* Tarde:
   \* Actual: {{$petition->presale->late}}
   \* Propuesto: {{$petition->late}}
 \* Fecha de financiación:
   \* Actual: {{$petition->presale->start ? $petition->presale->start->format('Y-m') : 'Ninguna'}}
   \* Propuesta: {{$petition->start ? $petition->start->format('Y-m') : 'Ninguna'}}
 \* Fecha de entrega anunciada:
   \* Actual: {{$petition->presale->announced_end ? $petition->presale->announced_end->format('Y-m') : 'Ninguna'}}
   \* Propuesta: {{$petition->announced_end ? $petition->announced_end->format('Y-m') : 'Ninguna'}}
 \* Fecha de entrega:
   \* Actual: {{$petition->presale->end ? $petition->presale->end->format('Y-m') : 'Ninguna'}}
   \* Propuesta: {{$petition->end ? $petition->end->format('Y-m') : 'Ninguna'}}
@else
 \* Preventa: [{{$petition->presale_name}}]({{$petition->presale_url}})
@if ($petition->editorial)
 \* Editorial: {{$petition->editorial->getMarkdown()}}
@else
 \* Editorial: [{{$petition->editorial_name}}]({{$petition->editorial_url}})
@endif
 \* Estado: {{$petition->state}}
 \* Tarde: {{$petition->late}}
 \* Fecha de financiación: {{$petition->start ? $petition->start->format('Y-m') : 'Ninguna'}}
 \* Fecha de entrega anunciada: {{$petition->announced_end ? $petition->announced_end->format('Y-m') : 'Ninguna'}}
 \* Fecha de entrega: {{$petition->end ? $petition->end->format('Y-m') : 'Ninguna'}}
@endif