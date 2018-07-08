# Validator

The validator is a simple PHP validation library to remove the hassle of creating (often times) ugly validation logic and takes huge inspiration from Laravel's internal validation library.

This library is intended to be lightweight (no dependencies!) and easy-to-use.

Requirements:
* PHP 7+

To install, run the following in your project root:

```sh
$ composer require grahamsutton/validator
```

## Two Ways to Use It

There are two ways to perform validations:

**Chain Methods**

Use chain methods if you want to perform validations with at most one rule per field.

```php
use Validator\Validator;

$is_valid = (new Validator())
    ->required('name', 'Graham')
    ->numeric('age', 33)
    ->email('email', 'grahamsutton2@gmail.com')
    ->boolean('accepted_terms', true)
    ->min('fav_color', 'green', 3)
    ->max('state', 'FL', 2)
    ->date('birthday', '1980-01-01')
    ->validate();
```

-or-

**Pipe Format (preferred)**

Use can use pipe formatting the same way you do in Laravel if you want to perform multiple validations on a field. This is the preferred method of performing validations and looks better most of the time.

```php
use Validator\Validator;

$validator = new Validator([
    'name'       => 'required|min:3|max:15',
    'age'        => 'required|numeric',
    'email'      => 'required|email',
    'accepted'   => 'required|boolean',
    'date'       => 'required|date'
]);

$is_valid = $validator->validate([
    'name'       => 'someone',
    'age'        => 23,
    'email'      => 'someone@example.com',
    'accepted'   => true,
    'date'       => '2018-02-18 23:00:00'
]));
```

## Retrieving Errors

Retrieving errors is simple. When a validation fails to pass, it will be recorded into an array that can be retrieved from two different methods: `getErrors` or `getAllErrors`.

**getErrors: array**

This will return a flat associative array, where the key is the name of the failed field and the value is the first error detected.

**Note**: Notice how some values fail multiple validations, like `name`, but there is only error message per field.

```php
use Validator\Validator;

$validator = new Validator([
    'name'       => 'required|min:3|max:15',
    'age'        => 'required|numeric',
    'email'      => 'required|email',
    'accepted'   => 'required|boolean',
    'date'       => 'required|date'
]);

// $is_valid will be false
$is_valid = $validator->validate([
    'name'       => '',             // invalid
    'age'        => 'string',        // invalid
    'email'      => '@example.com',  // invalid
    'accepted'   => 12,              // invalid
    'date'       => 'incorrect'      // invalid
]));

$validator->getErrors();

// Returns:
// [
//     'name'     => 'The name field is required.',
//     'age'      => 'The age field must be a numeric value.',
//     'email'    => 'The email field must be a valid email.',
//     'accepted' => 'The accepted field must be a boolean value.',
//     'date'     => 'The date field is not a valid date.'
// ]
```


**getAllErrors: array**

If you want to get *all* error messages recorded for a all fields, just use `getAllErrors` method. This will return the name of the failed fields as the keys and an array of error messages per failed field as the values.

```php
use Validator\Validator;

$validator = new Validator([
    'name'       => 'required|min:3|max:15',
    'age'        => 'required|numeric',
    'email'      => 'required|email',
    'accepted'   => 'required|boolean',
    'date'       => 'required|date'
]);

// $is_valid will be false
$is_valid = $validator->validate([
    'name'       => '',             // invalid
    'age'        => 'string',        // invalid
    'email'      => '@example.com',  // invalid
    'accepted'   => 12,              // invalid
    'date'       => 'incorrect'      // invalid
]));

$validator->getErrors();

// Returns:
// [
//     'name' => [
//         'The name field is required.',
//         'The name field must be greater than or equal to 3 characters.'
//     ],
//     'age'      => ['The age field must be a numeric value.'],
//     'email'    => ['The email field must be a valid email.'],
//     'accepted' => ['The accepted field must be a boolean value.'],
//     'date'     => ['The date field is not a valid date.']
// ]
```

## Available Rules

### required

Validates that value is not empty and the field is present.

```php
use Validator\Validator;

$is_valid = (new Validator)
    ->required('field_name', 'value')
    ->validate();
```

or

```php
use Validator\Validator;

$validator = new Validator([
    'field_name' => 'required'
]);

$is_valid = $validator->validate([
    'field_name' => 'value'
]);
```

Default error message: `The {field_name} field is required.`

### max:*int*

Determines the max value or string length that a field can have.

If the value provided is an integer, the validation will compare that the provided integer is less than or equal to the specified *int* value.

If the value provided is a string, the validation will compare that the value's string length (determined by PHP's *strlen* function) is less than or equal to the specified *int* value.

```php
use Validator\Validator;

$is_valid = (new Validator)
    ->max('field_name', 'value', $max = 8)
    ->validate();
```

or

```php
use Validator\Validator;

$validator = new Validator([
    'field_name' => 'max:8'
]);

$is_valid = $validator->validate([
    'field_name' => 'value'
]);
```

Default error message: `The {field_name} field must be less than or equal to {int} characters.`

### min:*int*

Determines the minimum value or string length that a field can have.

If the value provided is an integer, the validation will compare that the provided integer is greater than or equal to the specified *int* value.

If the value provided is a string, the validation will compare that the value's string length (determined by PHP's *strlen* function) is greater than or equal to the specified *int* value.

```php
use Validator\Validator;

$is_valid = (new Validator)
    ->min('field_name', 'value', $min = 3)
    ->validate();
```

or

```php
use Validator\Validator;

$validator = new Validator([
    'field_name' => 'min:3'
]);

$is_valid = $validator->validate([
    'field_name' => 'value'
]);
```

Default error message: `The {field_name} field must be greater than or equal to {int} characters.`

### numeric

Determines that a value is numeric based on PHP's `is_numeric` function. The value can be a string, as long as it can be cast to a numerical value.

```php
use Validator\Validator;

$is_valid = (new Validator)
    ->numeric('field_name', $value = 23)
    ->validate();
```

or

```php
use Validator\Validator;

$validator = new Validator([
    'field_name' => 'numeric'
]);

$is_valid = $validator->validate([
    'field_name' => 23
]);
```

Default error message: `The {field_name} field must be a numeric value.`

### email

Determines that a value is a valid email address.

```php
use Validator\Validator;

$is_valid = (new Validator)
    ->email('field_name', 'value@example.com')
    ->validate();
```

or

```php
use Validator\Validator;

$validator = new Validator([
    'field_name' => 'email'
]);

$is_valid = $validator->validate([
    'field_name' => 'value@example.com'
]);
```

Default error message: `The {field_name} field must be a valid email.`

### boolean

Determines that a value is `true`, `false`, `0`, `1`, `"0"`, or `"1"`.

```php
use Validator\Validator;

$is_valid = (new Validator)
    ->boolean('field_name', $value = true)
    ->validate();
```

or

```php
use Validator\Validator;

$validator = new Validator([
    'field_name' => 'boolean'
]);

$is_valid = $validator->validate([
    'field_name' => true
]);
```

Default error message: `The {field_name} field must be a boolean value.`

### date

Determines that a value can be parsed by PHP's `strtotime` function.

```php
use Validator\Validator;

$is_valid = (new Validator)
    ->date('field_name', $value = '2018-07-24 03:30:24')
    ->validate();
```

or

```php
use Validator\Validator;

$validator = new Validator([
    'field_name' => 'date'
]);

$is_valid = $validator->validate([
    'field_name' => '2018-07-24 03:30:24'
]);
```

Default error message: `The {field_name} field is not a valid date.`
