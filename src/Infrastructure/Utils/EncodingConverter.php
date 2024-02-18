<?php

namespace Infrastructure\Utils;

class EncodingConverter
{

    public static function convertNestedArrayToUtf8($data){
        $typeConversion = 'utf8';
        if(is_array($data)) {
            return self::convertNestedArrays($data, $typeConversion);
        }else{
            return self::encodingValue($data, $typeConversion);
        }
    }

    public static function convertNestedArrayToIso88591($data){
        $typeConversion = 'iso88591';
        if(is_array($data)) {
            return self::convertNestedArrays($data, $typeConversion);
        }else{
            return self::encodingValue($data, $typeConversion);
        }
    }

    private static function convertNestedArrays(array $data, $typeConversion)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = self::convertNestedArrays($value, $typeConversion);
            }
        }

        return self::convertArray($data, $typeConversion);
    }

    private static function convertArray(array $data, $typeConversion)
    {
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $data[$key] = self::encodingValue($value, $typeConversion);
            }
        }

        return $data;
    }

    private static function encodingValue($value, $typeConversion){
        switch ($typeConversion){
            case 'utf8' :
                return mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1');
            case 'iso88591' :
                return utf8_decode($value);
        }

        return $value;
    }
}