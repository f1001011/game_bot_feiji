<?php

namespace app\traits;
trait MessageTrait
{

    public function messageName(string $name = '')
    {
        if (empty($name)) {
            return '';
        }

        $messageArray = [
            'MSG' => '',
        ];

        if (!isset($messageArray[$name])) {
            return '';
        }

        return $messageArray[$name];
    }
}