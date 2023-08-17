
{{-- Injected variables $record, $styles --}}
<p class="font-bold cursor-pointer"
    @if($recordClickEnabled)
        wire:click="onRecordClick('{{ $record['id'] }}')"
    @endif
>
    {{ $record['title'] }}
</p>

<p>
    {{ $record['start_date_time'] }}
</p>
