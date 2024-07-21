<?php

namespace WebduoNederland\FilamentCms\Http\Livewire;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Livewire\Component;
use WebduoNederland\FilamentCms\Data\Navigation;
use WebduoNederland\FilamentCms\Enums\PageStatusEnum;
use WebduoNederland\FilamentCms\Models\FilamentCmsBlog;
use WebduoNederland\FilamentCms\Models\FilamentCmsPage;

class BasePage extends Component
{
    protected ?FilamentCmsPage $page = null;

    protected ?FilamentCmsBlog $blog = null;

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

        if (config('filament-cms.blogs_enabled', false) && count($segments) === 2 && $segments[0] === config('filament-cms.blog_route_prefix')) {
            $this->blog = FilamentCmsBlog::query()
                ->where('slug->'.$this->lang, '=', $segments[1])
                ->where('published', '=', true)
                ->first();
        } else {
            $this->page = FilamentCmsPage::query()
                ->where('slug->'.$this->lang, '=', $slug)
                ->where('status', '=', PageStatusEnum::Published)
                ->first();
        }

        if (! $this->page && ! $this->blog) {
            abort(404);
        }
    }

    public function render(): ?View
    {
        /** @var string $layout */
        $layout = config('filament-cms.layout', 'filament-cms::layouts.app');

        if ($this->page) {
            return view('filament-cms::livewire.base-page', [
                'page' => $this->page,
            ])
                ->layout($layout)
                ->layoutData([
                    'lang' => $this->lang,
                    'navigation' => Navigation::get(),
                    'meta_title' => $this->page->meta_title[$this->lang],
                    'meta_description' => $this->page->meta_description[$this->lang],
                    'meta_robots' => $this->page->meta_robots,
                ]);
        } elseif ($this->blog) {
            return view('filament-cms::livewire.base-blog-page', [
                'blog' => $this->blog,
            ])
                ->layout($layout)
                ->layoutData([
                    'lang' => $this->lang,
                    'navigation' => Navigation::get(),
                    'meta_title' => $this->blog->name[$this->lang],
                    'meta_description' => null,
                    'meta_robots' => 'index, follow',
                ]);
        }

        return null;
    }
}
