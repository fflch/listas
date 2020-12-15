<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Utils\Mailman;
use App\Models\Lista;

class MailmanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailman {option?} {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mailman';

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
        # options: config and emails
        $options = ['config','emails'];
        $option = $this->argument('option');
        # se a option não for fornecida, escolhemos uma aleatoriamente
        if(!$option || !in_array($option,$options)) {
            $option = $options[array_rand($options)];
        }

        # list id
        $id = $this->argument('id');
        # se a lista não for fornecida, escolhemos uma aleatoriamente
        if(!$id) {
            $lista = Lista::inRandomOrder()->first();
        } else {
            $lista = Lista::findOrFail($id);
        }

        if($option == 'emails') {
            Mailman::emails($lista);
        }

        if($option == 'config') {
            Mailman::config($lista);
        }
    }
}
