<?php
namespace Application;

use Http\Request;
use Infrastructure\Utils\ValidationRules;
use Infrastructure\Utils\ValidationUtils;

class RequestHandler
{

    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getParameter($name, $validations = [], $default = null){
        if(!empty($name)) {
            $value = $this->request->getParameter($name, $default);
            $this->validateParameter($name, $value, $validations);
            return $value;
        }else{
            return $this->request->getAllParameters();
        }
    }

    public function getAllParameter(){
        return $this->request->getAllParameters();
    }

    private function validateParameter($fieldName, $value, $validations)
    {
        if (!empty($validations)) {
            foreach ($validations as $validation) {
                $this->applyValidation($fieldName, $validation, $value);
            }
        }
    }

    private function applyValidation($fieldName, $validation, $value)
    {
        $validationParts = explode(':', $validation);

        $validationName = $validationParts[0];
        $validationParams = isset($validationParts[1]) ? $validationParts[1] : null;

        switch ($validationName) {
            case ValidationRules::NOT_EMPTY:
                ValidationUtils::notEmpty($value, $fieldName);
                break;
            case ValidationRules::LENGTH:
                ValidationUtils::applyLengthValidation($value, $fieldName, $validationParams);
                break;
        }
    }
}