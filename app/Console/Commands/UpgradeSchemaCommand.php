<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SchemaUpgradeService;

class UpgradeSchemaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:upgrade-schema';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrade database schema and seed default data from extracted_schemas.json';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting database schema upgrade...');

        $service = new SchemaUpgradeService();
        $service->upgrade(function ($percent, $step, $status, $details, $changes, $seedsSummary) {
            $this->line(sprintf('[%3d%%] Step %d: %s', $percent, $step, $details));
        });

        $this->info('Database schema upgrade completed successfully!');
        return 0;
    }
}
