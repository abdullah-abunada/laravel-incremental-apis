<?php
/**
 * Created by PhpStorm.
 * User: abdullah
 * Date: 10/30/2016
 * Time: 5:21 PM
 */

namespace App\transformer;


class TagsTransformer extends Transformer
{

    public function transform($tag)
    {
        return [
            'name' => $tag['name']
        ];
    }
}