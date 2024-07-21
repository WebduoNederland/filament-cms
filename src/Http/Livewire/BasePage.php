<?php

namespace WebduoNederland\FilamentCms\Http\Livewire;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Livewire\Component;
use WebduoNederland\FilamentCms\Data\Navigation;
use WebduoNederland\FilamentCms\Enums\PageStatusEnum;
use WebduoNederland\FilamentCms\Models\FilamentCmsPage;

class BasePage extends Component
{
    protected ?FilamentCmsPage $page;

    public string $lang;

    public function mount(Request $request): void
    {
        $this->lang = getFilamentCmsLang();

        $segments = $request->segments();

        if (count($segments) > 0 && $segments[0] === $this->lang) {
            array_shift($segments);
        }

        $slug = implode('/', $segments);

        if (blank($slug)) {
            $slug = '/';
        }

        $this->page = FilamentCmsPage::query()
            ->where('slug->'.$this->lang, '=', $slug)
            ->where('status', '=', PageStatusEnum::Published)
            ->first();

        if (! $this->page) {
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
                'lang' => $this->lang,
                'navigation' => Navigation::get(),
                'meta_title' => $this->page?->meta_title[$this->lang],
                'meta_description' => $this->page?->meta_description[$this->lang],
                'meta_robots' => $this->page?->meta_robots,
            ]);
    }
}
