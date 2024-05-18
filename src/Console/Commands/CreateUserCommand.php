<?php

namespace WebduoNederland\FilamentCms\Console\Commands;

use Illuminate\Console\Command;
use WebduoNederland\FilamentCms\Models\FilamentCmsAdmin;

use function Laravel\Prompts\info;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateUserCommand extends Command
{
    protected $signature = 'filament-cms:create-user';

    protected $description = 'Create a new Filament CMS user';

    public function handle(): int
    {
        $name = text(
            'Name',
            required: true,
        );

        $email = text(
            'E-mail',
            required: true,
            validate: [
                'email',
            ],
        );

        $password = password(
            'Password',
            hint: 'Minimum 8 characters',
            required: true,
            validate: [
                'min:8',
            ],
        );

        FilamentCmsAdmin::query()
            ->create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);

        info('Succesfully created an admin account for '.$email);

        return self::SUCCESS;
    }
}
