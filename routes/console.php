<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('app:setup-admin', function () {
    $user = new App\Models\User();
    $user->password = Hash::make('12341234');
    $user->email = 'findthegame@findthegame';
    $user->name = 'Admin';

    try {
        $user->save();
        $saved = true;
    } catch (Exception $e) {
        $user->delete();
        $saved = false;
    }

    if ($saved) {
        echo "New administrator has been created.\n";
    } else {
        echo "Administrator already exists.\n";
    }
    
})->purpose('Setup new administrator user for the application');