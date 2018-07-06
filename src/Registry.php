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
        // 'max'       => App_Validator_Validation_MaxLength::class,
        // 'min'       => App_Validator_Validation_MinLength::class,
        // 'boolean'   => App_Validator_Validation_Boolean::class,
        // 'numeric'   => App_Validator_Validation_Numeric::class,
        // 'email'     => App_Validator_Validation_Email::class,
        // 'key'       => App_Validator_Validation_EntityKey::class,
        // 'date'      => App_Validator_Validation_Date::class,
    ];
}
