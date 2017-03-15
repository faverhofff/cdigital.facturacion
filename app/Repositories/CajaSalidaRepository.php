<?php

namespace App\Repositories;

use App\Models\CajaSalida;
use InfyOm\Generator\Common\BaseRepository;

class CajaSalidaRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return CajaSalida::class;
    }

    public function getEntriesByRange($initdate, $enddate)
    {
        return CajaSalida::where('created_at', '>=', $initdate)->where('created_at', '<=', $enddate)->get();
    }
}
