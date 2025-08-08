<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Exception;

class RecreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recreate-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recreate medify_rekrutmen database';

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
        try {
            $this->info('Starting database recreation process...');

            // Get database configuration
            $connection = Config::get('database.connections.mysql');
            $database = $connection['database'] ?? 'medify_rekrutmen';

            // Confirm action
            if (!$this->confirm("Are you sure you want to recreate the database '{$database}'? This will delete all existing data.")) {
                $this->info('Operation cancelled.');
                return 0;
            }

            $this->info("Dropping database '{$database}' if it exists...");
            DB::statement("DROP DATABASE IF EXISTS `{$database}`");

            $this->info("Creating database '{$database}'...");
            DB::statement("CREATE DATABASE `{$database}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

            $this->info("Database '{$database}' has been successfully recreated!");

            // Run migrations if they exist
            if ($this->confirm('Would you like to run migrations now?')) {
                $this->call('migrate');
            }

            return 0;
        } catch (Exception $e) {
            $this->error('An error occurred while recreating the database:');
            $this->error($e->getMessage());
            return 1;
        }
    }
}
