<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CommandService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create module service ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //         $path = './app/Services/Modules';
        //         $nameGet = $this->argument('name');
        //         if(!file_exists($path.'/M'.$nameGet)) mkdir($path.'/M'.$nameGet,0777,true);
        //         $pathFile = $path.'/M'.$nameGet.'/'.$nameGet.'.php';
        //         if(!file_exists($pathFile))
        //         {
        //             $myfile = fopen($pathFile, "w");
        //             $data =
        // "<?php
        // namespace App\Services\M$nameGet;

        // class $nameGet{

        // }";
        //             fwrite($myfile, $data);
        //             fclose($myfile);
        //             $this->line('🆗 Running');
        //             $this->info("✅ Create service $nameGet successful!");
        //         }else{
        //             $this->line("❌ $nameGet already exists");
        //         }
    }
}