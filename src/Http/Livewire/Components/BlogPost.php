<?php

namespace WebduoNederland\FilamentCms\Http\Livewire\Components;

use Illuminate\View\View;
use Livewire\Attributes\Locked;
use WebduoNederland\FilamentCms\Models\FilamentCmsBlog;

class BlogPost extends FilamentCmsComponent
{
    #[Locked]
    public FilamentCmsBlog $blog;

    public function render(): View
    {
        return view('filament-cms::livewire.components.blog-post');
    }
}
