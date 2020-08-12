<?php

namespace App\Http\Controllers\Install;

use Illuminate\Routing\Controller as BaseController;
use Drc\AutoMaker\MakeForm;
use Drc\AutoMaker\MakeControl;
use Illuminate\Support\Facades\Artisan;

class InstallController extends BaseController
{
    public function index()
    {
        echo "InitDB start ...<br>";
        Artisan::call('migrate:reset');
        Artisan::call('migrate');
        Artisan::call('db:seed');
        echo "InitDB end ！<br>";

        return view("home.index");
    }

    public function create()
    {
        echo "create user start ...<br>";
        MakeForm::CreateAll();
        MakeControl::CreateAll();
        echo "create user end<br>";

        return view("home.index");
    }
}
