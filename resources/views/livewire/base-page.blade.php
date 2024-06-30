<div>
    @foreach($page->components as $index => $component)
        @livewire(config('filament-cms.components.'.$component['type'].'.livewire_component'), ['data' => $component['data'], 'lang' => $lang], key($index))
    @endforeach
</div>