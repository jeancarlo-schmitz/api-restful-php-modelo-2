<?php
namespace Infrastructure\Utils;

use Exception;

class ValidationUtils
{
    public static function notEmpty($value, $fieldName)
    {
        if (empty($value)) {
            throw new Exception("O campo " . $fieldName . " não pode ser vazio");
        }
    }

    public static function applyLengthValidation($value, $fieldName, $validationParams)
    {
        $params = explode(',', $validationParams);
        $minLength = null;
        $maxLength = null;

        foreach ($params as $param) {
            $paramParts = explode('=', $param);
            $paramName = $paramParts[0];
            $paramValue = $paramParts[1];

            if ($paramName === 'min') {
                $minLength = (int) $paramValue;
            } elseif ($paramName === 'max') {
                $maxLength = (int) $paramValue;
            }
        }

        self::length($value, $fieldName, $minLength, $maxLength);
    }

    private static function length($value, $fieldName, $minLength = null, $maxLength = null)
    {
        $length = strlen($value);

        if ($minLength !== null && $length < $minLength) {
            throw new Exception("O campo '$fieldName' deve ter pelo menos $minLength caracteres.");
        }

        if ($maxLength !== null && $length > $maxLength) {
            throw new Exception("O campo '$fieldName' deve ter no máximo $maxLength caracteres.");
        }
    }
}