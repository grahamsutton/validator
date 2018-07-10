# Validator

The validator is a simple PHP validation library to remove the hassle of creating (often times) ugly validation logic and takes huge inspiration from Laravel's internal validation library.

This library is intended to be lightweight (no dependencies!) and easy-to-use.

[![Build Status](https://travis-ci.org/grahamsutton/validator.svg?branch=master)](https://travis-ci.org/grahamsutton/validator)

Requirements:
* PHP 7.1 and higher

To install, run the following in your project root:

```sh
$ composer require grahamsutton/validator
```

**Available Rules**

* [required](#required)
* [max](#max)
* [min](#min)
* [int](#int)
* [float](#float)
* [numeric](#numeric)
* [email](#email)
* [boolean](#boolean)
* [accepted](#accepted)
* [array](#array)
* [date](#date)
* [afterDate](#afterDate)
* [beforeDate](#beforeDate)

## Two Ways to Use It

There are two ways to perform validations:

**Chain Methods**

You can chain validation methods together if you want to perform validations...

```php
use Validator\Validator;

$is_valid = (new Validator())
    ->required('name', 'Graham')
    ->numeric('age', 33)
    ->email('email', 'grahamsutton2@gmail.com')
    ->int('total', 123)
    ->float('amount', 123.45)
    ->boolean('likes_dinos', true)
    ->min('fav_color', 'green', 3)
    ->max('state', 'FL', 2)
    ->date('birthday', '1980-01-01')
    ->array('fav_nums', [7, 4, 92])
    ->accepted('terms', true)
    ->afterDate('start_date', '2018-05-24', '2018-01-31')
    ->beforeDate('end_date', '2024-05-24', '2218-01-31')
    ->validate();
```

-or-

**Pipe Format (preferred)**

Use can use pipe formatting the same way you do in Laravel if you want to perform multiple validations on a field. This is the preferred method of performing validations and looks better most of the time.

```php
use Validator\Validator;

$validator = new Validator([
    'name'        => 'required|min:3|max:15',
    'age'         => 'required|numeric',
    'email'       => 'required|email',
    'total'       => 'required|int',
    'amount'      => 'required|float'
    'likes_dinos' => 'required|boolean',
    'date'        => 'required|date',
    'fav_nums'    => 'required|array',
    'terms'       => 'accepted',
    'start_date'  => 'required|afterDate:2018-01-31',
    'end_date'    => 'required|beforeDate:2218-01-31',
]);

$is_valid = $validator->validate([
    'name'        => 'someone',
    'age'         => 23,
    'email'       => 'someone@example.com',
    'total'       => 123,
    'amount'      => 123.45,
    'likes_dinos' => true,
    'date'        => '2018-02-18 23:00:00',
    'fav_nums'    => [7, 4, 92],
    'terms'       => true,
    'start_date'  => '2018-05-24',
    'end_date'    => '2024-05-24',
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
    'name'        => 'required|min:3|max:15',
    'age'         => 'required|numeric',
    'email'       => 'required|email',
    'total'       => 'required|int',
    'amount'      => 'required|float'
    'likes_dinos' => 'required|boolean',
    'date'        => 'required|date',
    'fav_nums'    => 'required|array',
    'terms'       => 'accepted',
    'start_date'  => 'required|afterDate:2018-01-31',
    'end_date'    => 'required|beforeDate:2218-01-31',
]);

// $is_valid will be false
$is_valid = $validator->validate([
    'name'        => '',                     // invalid
    'age'         => 'string',               // invalid
    'email'       => '@example.com',         // invalid
    'total'       => 123.45,                 // invalid
    'amount'      => 123,                    // invalid
    'likes_dinos' => 12,                     // invalid
    'date'        => 'incorrect'             // invalid
    'fav_nums'    => 'should be an array',   // invalid  
    'terms'       => false,                  // invalid
    'start_date'  => '2017-05-24',           // invalid
    'end_date'    => '2324-05-24',           // invalid
]));

$validator->getErrors();

// Returns:
// [
//     'name'        => 'The name field is required.',
//     'age'         => 'The age field must be a numeric value.',
//     'email'       => 'The email field must be a valid email.',
//     'total'       => 'The total field must be an integer.',
//     'amount'      => 'The amount field must be a float.',
//     'likes_dinos' => 'The likes_dinos field must be a boolean value.',
//     'date'        => 'The date field is not a valid date.',
//     'fav_nums'    => 'The fav_nums field must be an array.',
//     'terms'       => 'The terms field must be accepted.',
//     'start_date'  => 'The start_date field value must be after 2018-01-31 00:01:00 (yyyy-mm-dd hh:mm:ss).',
//     'end_date'    => 'The end_date field value must be before 2218-01-31 00:01:00 (yyyy-mm-dd hh:mm:ss).',
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
    'name'       => '',              // invalid
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

<a name="required">
<h3>required</h3>
</a>

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

<a name="max">
<h3>max:<em>int</em></h3>
</a>

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

<a name="min">
<h3>min:<em>int</em></h3>
</a>

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

<a name="int">
<h3>int</h3>
</a>

Determines that a value is an integer based on PHP's `is_int` function.

```php
use Validator\Validator;

$is_valid = (new Validator)
    ->int('field_name', $value = 123)
    ->validate();
```

or

```php
use Validator\Validator;

$validator = new Validator([
    'field_name' => 'int'
]);

$is_valid = $validator->validate([
    'field_name' => 123
]);
```

Default error message: `The {field_name} field must be an integer.`

<a name="float">
<h3>float</h3>
</a>

Determines that a value is a float based on PHP's `is_float` function.

```php
use Validator\Validator;

$is_valid = (new Validator)
    ->float('field_name', $value = 123.45)
    ->validate();
```

or

```php
use Validator\Validator;

$validator = new Validator([
    'field_name' => 'float'
]);

$is_valid = $validator->validate([
    'field_name' => 123.45
]);
```

Default error message: `The {field_name} field must be an float.`

<a name="numeric">
<h3>numeric</h3>
</a>

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

<a name="email">
<h3>email</h3>
</a>

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

<a name="boolean">
<h3>boolean</h3>
</a>

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

<a name="accepted">
<h3>accepted</h3>
</a>

Determines that a value is `true`, `1`, `"1"`, or `"yes"`. This is useful for ensuring that people accept things like terms and conditions for your site. This validation will fail if provided a false value. 

`"yes"` will be parsed to lowercase when provided, just in case you provide it capitalized.

```php
use Validator\Validator;

$is_valid = (new Validator)
    ->accepted('field_name', $value = true)
    ->validate();
```

or

```php
use Validator\Validator;

$validator = new Validator([
    'field_name' => 'accepted'
]);

$is_valid = $validator->validate([
    'field_name' => true
]);
```

Default error message: `The {field_name} field must be accepted.`

<a name="array">
<h3>array</h3>
</a>

Determines that a value is an array. Internally, it uses PHP's `is_array` function to determine its truthiness. Empty arrays are considered valid. Add a `required` validation to disallow empty arrays.

```php
use Validator\Validator;

$is_valid = (new Validator)
    ->array('field_name', $value = ['value1', 'value2'])
    ->validate();
```

or

```php
use Validator\Validator;

$validator = new Validator([
    'field_name' => 'array'
]);

$is_valid = $validator->validate([
    'field_name' => ['value1', 'value2']
]);
```

Default error message: `The {field_name} field must be an array.`

<a name="date">
<h3>date</h3>
</a>

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

<a name="afterDate">
<h3>afterDate:<em>string</em></h3>
</a>


Determines if a value is after the specified date. The *string* parameter can be any value that can be parsed by PHP's `strtotime` function.

```php
use Validator\Validator;

$is_valid = (new Validator)
    ->afterDate('field_name', $value = '2018-07-25 03:30:24', $after_date = '2018-07-24 00:00:00')
    ->validate();
```

or

```php
use Validator\Validator;

$validator = new Validator([
    'field_name' => 'afterDate:2018-07-24 00:00:00'
]);

$is_valid = $validator->validate([
    'field_name' => '2018-07-25 03:30:24'
]);
```

Default error message: `The {field_name} field value must be after {after_date} (yyyy-mm-dd hh:mm:ss).`

<a name="beforeDate">
<h3>beforeDate:<em>string</em></h3>
</a>

Determines if a value is before the specified date. The *string* parameter can be any value that can be parsed by PHP's `strtotime` function.

```php
use Validator\Validator;

$is_valid = (new Validator)
    ->beforeDate('field_name', $value = '2018-07-24 03:30:24', $before_date = '2018-07-25 00:00:00')
    ->validate();
```

or

```php
use Validator\Validator;

$validator = new Validator([
    'field_name' => 'beforeDate:2018-07-25 00:00:00'
]);

$is_valid = $validator->validate([
    'field_name' => '2018-07-24 03:30:24'
]);
```

Default error message: `The {field_name} field value must be before {before_date} (yyyy-mm-dd hh:mm:ss).`

## License
Validator is licensed under the MIT License - see the LICENSE file for details.