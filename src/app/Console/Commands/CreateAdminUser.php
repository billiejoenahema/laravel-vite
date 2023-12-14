<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

final class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:admin-user {userName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an admin user';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $userName = $this->argument('userName');
        $password = str()->random(16);

        $user = DB::transaction(static function () use ($userName, $password) {
            $user = User::create([
                'name' => $userName,
                'email' => $userName . '@example.com',
                'password' => bcrypt($password),
            ]);

            return $user;
        });

        $user->role = Role::ADMIN->value;
        $user->save();

        $this->info("email: {$user->email}");
        $this->info("password: {$password}");
    }
}
