<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 25/05/2016
 * Time: 3:10 PM
 */

namespace App\Services;


class PasswordService
{
    /**
     * @return string
     */
    public function generate()
    {
        return 'secret';    
    }


    /**
     * @param array $data
     * @return array
     */
    public function generatePassword(array &$data)
    {
        $data['password'] = $this->generate();
        return $data;
    }
}