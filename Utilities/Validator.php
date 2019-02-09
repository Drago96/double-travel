<?php

class Validator
{
    public static function length($validatee, $minLength, $maxLength, $entity)
    {
        $length = strlen($validatee);

        if ($length < $minLength || $length > $maxLength) {
            return "${entity} must be between ${minLength} and ${maxLength} characters long.";
        }

        return null;
    }

    public static function validDate($dateString, $entity) {
      if(!(bool)strtotime($dateString)) {
        return "${entity} must be a valid date.";
      }

      return null;
    }
}
