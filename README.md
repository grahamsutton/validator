# Validator

The validator is a simple PHP validation library to remove the hassle of creating (often times) ugly validation logic and takes huge inspiration from Laravel's internal validation library.

This library is intended to be lightweight (no dependencies!) and easy-to-use.

Requirements:
* >= PHP 7

To install, run the following in your project root:

```sh
$ composer require grahamsutton/validator
```

## Two Ways to Use It

There are two ways to perform validations:

**Chain Methods**

Use chain methods if you want to perform one-time validations.

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

Use can use pipe formatting the same way you do in Laravel. This is the preferred method of performing validations.

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
