<?php

namespace App\Http\Controllers;

use App\Classes\ERHelper;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DBController extends Controller
{
    public function index(){
        $erHelper = new ERHelper();
        $mermaidCode = $erHelper->generateMermaid();

        return Inertia::render('ERDB', ['mermaidCode' => $mermaidCode]);
    }
}
