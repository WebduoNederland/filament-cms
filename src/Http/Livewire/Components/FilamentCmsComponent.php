<?php

namespace WebduoNederland\FilamentCms\Http\Livewire\Components;

use Livewire\Attributes\Locked;
use Livewire\Component;

class FilamentCmsComponent extends Component
{
    #[Locked]
    public array $data;
}
