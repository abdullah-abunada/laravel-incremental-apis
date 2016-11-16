<?php
/**
 * Created by PhpStorm.
 * User: abdullah
 * Date: 10/30/2016
 * Time: 5:18 PM
 */

namespace App\transformer;


abstract class Transformer
{

    public function transformCollection(array $items){
        return  array_map([$this, 'transform'], $items);
    }

    public abstract function transform ($item);
}