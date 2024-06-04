<?php

namespace App\Console\Commands;

use App\Classes\ERHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ERDiagram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:e-r-diagram';

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
        $erHelper = new ERHelper();
        $mermaidCode = $erHelper->generateMermaid();
        $this->info($mermaidCode);
    }
}
