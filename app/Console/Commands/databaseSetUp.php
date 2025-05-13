<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class databaseSetUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->confirm('Do you want to run migrations?')) {
            $this->info('Continuing the migration file...');
            Artisan::call('migrate:fresh');
            $this->info('migrations completed...');
        }
        if ($this->confirm('Do you want to run master migrations?')) {
            Artisan::call('migrate --path=database/migrations/master');
            echo "migrations of master completed\n";
        }

        if ($this->confirm('Do you want to run seeders?')) {
            $this->info('Continuing the seeders file...');
            Artisan::call('db:seed');
            $this->info('seeders completed...');
        }

    }
}
