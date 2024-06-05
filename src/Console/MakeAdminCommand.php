<?php

namespace CeddyG\Clara\Console;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\Hash;

class MakeAdminCommand extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add admin';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {
        $user = User::create([
            'name'      => $this->ask('Name : '),
            'email'     => $this->ask('E-mail : '),
            'password'  => Hash::make($this->secret('Password : '))
        ]);
        
        $role = Role::firstOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Admin']
        );
        
        $user->roles()->save($role);

        $this->line('');
        $this->components->info('New admin added.');
    }
}
