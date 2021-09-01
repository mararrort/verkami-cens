La preventa sin finalizar de {{ $presale->getMarkdown() }} lleva sin actualizaciones registradas desde {{ $presale->updated_at }}.

¿La información es correcta?

Estado: {{ $presale->state }}

La información puede actualizarse a través de este enlace: {{route('petition.create', ['presale' => $presale->id])}}