<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class admin extends Command
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
    protected $description = 'Create Admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user=User::where('is_admin',1)->first();
        if($user){
            $this->info("Email : {$user->email}");
            $this->info("Password : inventosoftware");
        }else{
            User::create([
                'name' => 'admin',
                'email' => 'admin@invento.soft',
                'email_verified_at' => now(),
                'password' => Hash::make('inventosoftware'),
                'is_admin' => 1,
            ]);
            $this->info("Creating Admin");
            $this->info("Email : admin@invento.soft");
            $this->info("Password : inventosoftware");
        }
        
    }
}
