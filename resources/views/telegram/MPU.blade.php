Se tiene registrado que la preventa {{ $presale->getMarkdown() }} se encuentra en estado "{{ $presale->state }}". ¿Es correcto?

La información puede actualizarse a través de este enlace: {{route('petition.create', ['presale' => $presale->id])}}