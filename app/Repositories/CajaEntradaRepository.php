<?php

namespace App\Repositories;

use App\Models\CajaEntrada;
use InfyOm\Generator\Common\BaseRepository;

class CajaEntradaRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return CajaEntrada::class;
    }

    public function getEntriesByRange($initdate, $enddate)
    {
        return CajaEntrada::where('fecha', '>=', $initdate)->where('fecha', '<=', $enddate)->get();
    }
}
