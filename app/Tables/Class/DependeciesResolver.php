<?php

namespace App\Tables\Class;

/* import any missing dependencies found */


final class DependeciesResolver
{
    static function resolve($table): array
    {
        $dependencies = $table->getDependencies();
        $resolved = [];
        foreach ($dependencies as $dependency) {
            $fullClassName = 'App\\Models\\' . $dependency;
            if (class_exists($fullClassName)) {
                $resolved[$dependency] = $fullClassName::all();
            } else {
                throw new \Exception("Class {$fullClassName} not found");
            }
        }
        return $resolved;
    }
}
