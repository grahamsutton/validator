<?php

namespace Validator;

/**
 * The Validation Registry
 *
 * This class is responsible for managing the list of commands
 * and the corresponding validation that a command should 
 * instantiate.
 */
class Registry
{
    public static $validations = [
        'required'  => \Validator\Validations\Required::class,
        'max'       => \Validator\Validations\MaxLength::class,
        'min'       => \Validator\Validations\MinLength::class,
        'boolean'   => \Validator\Validations\Boolean::class,
        'numeric'   => \Validator\Validations\Numeric::class,
        'email'     => \Validator\Validations\Email::class,
        'date'      => \Validator\Validations\Date::class,
    ];
}
