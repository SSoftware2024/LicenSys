<?php
namespace App\Traits;
trait EnumFunctions {
    /**
     * toArray
     *
     * @return array
     */
    public static function toArray() : array {
        $cases = self::cases();
        $array = [];
        foreach ($cases as $value) {
            $array[] = $value->value;
        }
        return $array;
    }
}
