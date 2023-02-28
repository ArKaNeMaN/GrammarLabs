<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminCommand extends Command
{
    protected $signature = 'admin:create {--L|login=admin} {--N|name=Администратор} {--P|password=admin}';
    protected $description = 'Создание учётной записи администратора.';

    public function handle(): void
    {
        $pass = $this->option('password');

        $user = User::create([
            'name' => $this->option('name'),
            'login' => $this->option('login'),
            'password' => Hash::make($pass),
            'role' => UserRole::ADMIN,
            'group_name' => 'Преподаватель',
        ]);

        $this->info('Учётная запись администратора создана:');
        $this->info("\tИмя: $user->name");
        $this->info("\tЛогин: $user->login");
        $this->info("\tПароль: $pass");
    }
}
