<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:admin-user {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an admin user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = str()->random(16);

        $validator = Validator::make(['email' =>$email], [
            'email' => ['required', 'string', 'max:255', 'email:filter,rfc,spoof'],
        ]);
        if ($validator->fails()) {
            $this->error('Invalid email address');
            return 1;
        }

        $user = DB::transaction(function () use ($email, $password) {
            $user = User::create([
                'name' => explode('@', $email)[0],
                'email' => $email,
                'password' => bcrypt($password),
            ]);
            return $user;
        });

        $user->role = User::ROLE_ADMIN;
        $user->save();

        $this->info("email: {$user->email}");
        $this->info("password: {$password}");
    }
}
