<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class setupImageTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-image-types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make the image type records ( 1 => GameImage , 2 => CompanyImage)';

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
        return 0;
    }
}
