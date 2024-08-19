<?php

namespace WebduoNederland\FilamentCms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Stringable;

use function Laravel\Prompts\info;
use function Laravel\Prompts\text;

class CreateComponentCommand extends Command
{
    protected $signature = 'filament-cms:create-component';

    protected $description = 'Create a new Filament CMS component';

    public function handle(): int
    {
        $name = text(
            'Component name',
            required: true,
            validate: [
                'regex:/^[a-z_]+$/',
            ],
            hint: 'For example: simple_text OR blog_post OR navigation. Only alphabetical characters and underscores.',
        );

        $this->createMissingDirectories();

        info('Creating Livewire component...');

        $this->createLivewireComponent($name);

        info('Livewire component created!');

        info('Creating Livewire blade view...');

        $this->createLivewireBladeView($name);

        info('Livewire blade view created!');

        info('Creating Filament block...');

        $this->createFilamentBlock($name);

        info('Filament block created!');

        info("Component successfully created! Make sure to register the component in the filament-cms.php config file as follows:
'".$name."' => [
    'filament_block' => App\FilamentCmsBlocks\\".str($name)->studly()."Block::class,
    'livewire_component' => '".$name."',
],
        ");

        return self::SUCCESS;
    }

    protected function createLivewireComponent(string $name): void
    {
        $stub = $this->getStub('livewire_component.stub')
            ->replace('{{ class_name }}', str($name)->studly())
            ->replace('{{ view_name }}', str($name)->snake());

        file_put_contents(app_path('Livewire/'.str($name)->studly().'.php'), $stub->toString());
    }

    protected function createLivewireBladeView(string $name): void
    {
        $stub = $this->getStub('livewire_component_blade.stub');

        file_put_contents(resource_path('views/livewire/'.str($name)->snake().'.blade.php'), $stub->toString());
    }

    protected function createFilamentBlock(string $name): void
    {
        $stub = $this->getStub('filament_block.stub')
            ->replace('{{ class_name }}', str($name)->studly())
            ->replace('{{ lowercase_name }}', str($name)->snake())
            ->replace('{{ label }}', str($name)->replace('_', ' ')->title()->ucfirst());

        file_put_contents(app_path('FilamentCmsBlocks/'.str($name)->studly().'Block.php'), $stub->toString());
    }

    protected function createMissingDirectories(): void
    {
        if (! is_dir($dir = app_path('Livewire'))) {
            (new Filesystem)->makeDirectory($dir);
        }

        if (! is_dir($dir = resource_path('views/livewire'))) {
            (new Filesystem)->makeDirectory($dir);
        }

        if (! is_dir($dir = app_path('FilamentCmsBlocks'))) {
            (new Filesystem)->makeDirectory($dir);
        }
    }

    protected function getStub(string $name): Stringable
    {
        return str(File::get(__DIR__.'/../../../stubs/'.$name));
    }
}
