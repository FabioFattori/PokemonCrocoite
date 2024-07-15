<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;

class ERHelper{
    
    function getTables()
    {
        $tables = DB::select('SHOW TABLES');
        return array_map('current', $tables);
    }

    function getColumns($table)
    {
        $columns = DB::select("SHOW COLUMNS FROM $table");
        return $columns;
    }

    function getPrimaryKeys($table)
    {
        $database = env('DB_DATABASE');
        $query = "
            SELECT COLUMN_NAME 
            FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA = '$database' 
            AND TABLE_NAME = '$table' 
            AND COLUMN_KEY = 'PRI'
        ";
        return DB::select($query);
    }

    function getForeignKeys($table)
    {
        $database = env('DB_DATABASE');
        $query = "
            SELECT 
                COLUMN_NAME, 
                REFERENCED_TABLE_NAME, 
                REFERENCED_COLUMN_NAME 
            FROM 
                information_schema.KEY_COLUMN_USAGE 
            WHERE 
                TABLE_SCHEMA = '$database' 
                AND TABLE_NAME = '$table' 
                AND REFERENCED_COLUMN_NAME IS NOT NULL
        ";
        return DB::select($query);
    }

    function generateMermaid()
    {
        $tables = $this->getTables();
        $mermaid = "erDiagram\n";
        
        foreach ($tables as $table) {
            $columns = $this->getColumns($table);
            $mermaid .= "    $table {\n";
            foreach ($columns as $column) {
                $type = str_replace(' ', '_', $column->Type);
                $mermaid .= "        {$type} {$column->Field}\n";
            }
            $mermaid .= "    }\n";
            
            $foreignKeys = $this->getForeignKeys($table);
            foreach ($foreignKeys as $fk) {
                $mermaid .= "    $table ||--o| {$fk->REFERENCED_TABLE_NAME} : \"{$fk->COLUMN_NAME}\"\n";
            }
        }
        
        return $mermaid;
    }
}