<div>
    @foreach($page->components as $index => $component)
        @livewire(config('filament-cms.components.'.$component['type'].'.livewire_component'), ['data' => $component['data']], key($index))
    @endforeach
</div>