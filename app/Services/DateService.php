<?php
/**
 * Created by PhpStorm.
 * User: andrestntx
 * Date: 7/25/16
 * Time: 11:07 AM
 */

namespace App\Services;


use Carbon\Carbon;

class DateService
{

    /**
     * @return string
     */
    public function  getLangDateToday()
    {
        $date = Carbon::now();
        $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        return $date->day . ' de ' . $months[$date->month - 1] . ' de ' .$date->year;
    }
}