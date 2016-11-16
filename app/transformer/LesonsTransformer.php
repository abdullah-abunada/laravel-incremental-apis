<?php
/**
 * Created by PhpStorm.
 * User: abdullah
 * Date: 10/30/2016
 * Time: 5:21 PM
 */

namespace App\transformer;


class LesonsTransformer extends Transformer
{

    public function transform($lesson)
    {
        return [
            'lesson_title' => $lesson['title'],
            'lesson_description' => $lesson['body'],
            'lesson_tags'=> array_map([$this,'tagTransform']
            , $lesson['tags']->toArray())
        ];
    }

    //Todo:: refactoring
    private function tagTransform($tags){
        return [
            'name'=>$tags['name']
        ];
    }
}