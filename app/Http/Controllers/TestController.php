<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Laravel\Octane\Facades\Octane;

class TestController extends Controller
{
    public function index()
    {
        Octane::table('table')->set('uuid', [
            'name' => 'Michal',
            'votes' => 2
        ]);

        return Octane::table('table')->get('uuid');
    }

    public function test()
    {
        return Octane::table('table')->get('uuid');
    }
}
