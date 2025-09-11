<?php

namespace App\Traits;




/**
 * @method array toArray()
 */
trait EnumFunctions
{
    /**
     * toArray
     *
     * Transforma valores(value) em único array
     * @return array
     */
    public static function toArray(): array
    {
        $cases = self::cases();
        $array = [];
        foreach ($cases as $value) {
            $array[] = $value->value;
        }
        return $array;
    }

    /**
     * Pega valores do enum e traduz para o português para visualização do cliente,
     * caso não tenha tradução, retorna array vazio
     * @method toArrayPortuguese
     * @return array
     */
    public static function toArrayPortuguese(): array
    {
        $english_portuguese = [
            'pay' => 'pagar',
            'paid' => 'paga',
            'late' => 'atrasada',
            'overdue' => 'vencida',
        ];
        $array = self::toArray();
        $array_translated = [];
        foreach ($array as $value) {
            in_array($value, $array, true) ? $array_translated[$value] = $english_portuguese[$value] : null;
        }
        return $array_translated;
    }
}
