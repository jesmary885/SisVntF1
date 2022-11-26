<?php

namespace App\Console\Commands;

use App\Models\Producto_lote;
use Illuminate\Console\Command;

class tasa_venta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasa_venta:lotes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $productos_lotes = Producto_lote::all();

        foreach($productos_lotes as $producto_lote){
            $producto_lote->update([
                'tasa_venta' => 6.2
            ]);
        }
    }
}
