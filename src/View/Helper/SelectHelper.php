<?php
namespace App\View\Helper;

use Cake\View\Helper;

class SelectHelper extends Helper
{
    public function options($objetos, $valor, $texto, $opciones = []) {
        $options = [];
        if ($opciones && $opciones['blank']) {
            $options[key($opciones['blank'])] = $opciones['blank'][key($opciones['blank'])];
        }
        foreach ($objetos as $objeto) {
            $options[$objeto[$valor]] = $objeto[$texto];
        }
        return $options;
    }
}
