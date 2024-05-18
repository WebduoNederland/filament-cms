<?php

namespace WebduoNederland\FilamentCms\Http\Livewire;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Livewire\Component;
use WebduoNederland\FilamentCms\Enums\PageStatusEnum;
use WebduoNederland\FilamentCms\Models\FilamentCmsPage;

class BasePage extends Component
{
    protected ?FilamentCmsPage $page;

    public function mount(Request $request): void
    {
        $path = $request->path();

        $this->page = FilamentCmsPage::query()
            ->where('slug', '=', $path)
            ->where('status', '=', PageStatusEnum::Published)
            ->first();

        if (! $this->page) {
            // TODO: Check if it's a redirect. For this a redirect resource in the Filament Panel has to be created.
            abort(404);
        }
    }

    public function render(): View
    {
        /** @var string $layout */
        $layout = config('filament-cms.layout', 'filament-cms::layouts.app');

        return view('filament-cms::livewire.base-page', [
            'page' => $this->page,
        ])
            ->layout($layout)
            ->layoutData([
                'meta_title' => $this->page?->meta_title,
                'meta_description' => $this->page?->meta_description,
                'meta_robots' => $this->page?->meta_robots,
            ]);
    }
}
