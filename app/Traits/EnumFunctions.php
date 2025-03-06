<?php
namespace App\Traits;
/**
 * @method array toArray()
 */
trait EnumFunctions {
    /**
     * toArray
     *
     * Transforma valores(value) em único array
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
