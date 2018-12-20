<?php
/**
 * Created by PhpStorm.
 * User: Glup
 * Date: 17/12/2018
 * Time: 15:09
 */

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class JsonToPrettyJsonTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return json_encode(json_decode($value), JSON_PRETTY_PRINT);
    }

    public function reverseTransform($value)
    {
        return json_encode(json_decode($value));
    }
}