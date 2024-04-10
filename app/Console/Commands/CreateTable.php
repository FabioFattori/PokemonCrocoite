<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateTable extends Command
{
    protected $signature = 'make:table {name : The name of the table file}';

    protected $description = 'Create a new table file in the app\table folder';

    public function handle()
    {
        // Get the provided file name from the command argument
        $fileName = $this->argument('name');

        // Check if the file already exists
        $filePath = app_path('Tables/' . $fileName . '.php');
        if (File::exists($filePath)) {
            $this->error('File already exists!');
            return;
        }

        // Create the file with the provided name
        File::put($filePath, $this->getTemplateContent());

        $this->info('Table file created successfully! in' . $filePath);
    }

    protected function getTemplateContent()
    {
        // Template content for the table file
        return <<<EOT
<?php

namespace App\Tables;

use App\Tables\Table;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class {$this->argument('name')} extends Table
{
    
    public function __construct() {
        parent::__construct();
        \$this->setColumns([
            // Add your columns here            
        ]);
    }

    protected function getQuery():Builder|EloquentBuilder{
        // Implements the query to fetch data from the database
        throw new \Exception("Not implemented");
    }
}
EOT;
    }
}
