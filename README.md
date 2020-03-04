# Helpers for constants and enumerations

> The documentation is actual for version 1.0.

Supporting classes for constants of PHP.

Named constants and enumerations are used for immutable values. The package classes contain functions for getting a list of constants and their values without thrown exceptions of PHP.

```php
use Belca\Support\AbstractEnum;

class MyConstants extends AbstractEnum
{
    const DEFAULT = self::USER;

    const USER = 'user';
    const ADMIN = 'administrator';
    const CLIENT = 'client';
}

// ...

$constants = MyConstants::list();

// Output $constants: [
//    'USER' => 'user',
//    'ADMIN' => 'superuser',
//    'CLIENT' => 'client',
// ]

$default = MyConstants::getDefault(); // only using AbstractEnum
// or
$default = MyConstants::DEFAULT;

// Output $default: 'user'
```

## Introduction

Install the package using Composer or manually.

```bash
composer require belca/support-constants:1.*
```

Use one of the classes.

```php
use Belca\Support\AbstractConstants;
// or
use Belca\Support\AbstractEnum;
```

Use their features!

[AbstractConstants](#abstract-constants) [AbstractEnum](#abstract-enum)

## <a name="abstract-constants"></a> AbstractConstants

AbstractConstants is the abstract class for implementing a list of named constants and getting their values.

|Function|Description|
|--|--|
|```getConstants()```|Returns all constants of the class.|
|```list()```|The alias of the ```getConstants()``` function.|
|```getLastConstants()```|Returns an array of constants defined in the called class without constants of parrent classes.|
|```getParentConstants()```|Returns all constants of parent classes.|
|```getConst($name)```|*$name* - a name of constant.<br/><br/> Returns a value of a given constant if it exists, else returns *null*.<br/>  This is a safe method for calling constants, in otherwise when you calls undefined constants you will catch an error.|
|```isDefined($name)```|*$name* - a name of constant. <br/><br/> Checks whether a given constant exists and is defined in the class.|

See the example below. Down there is implementing of the base (first) class of constants.

**Example #1 Implementing the first (parent) class with constants**
```php
namespace AnyoneVendor\MyPackage\Enums;

use Belca\Support\AbstractConstants;

class Roles extends AbstractConstants
{
    const USER = 'user';
    const SUPERUSER = 'superuser';
    const CLIENT = 'client';
    const MODERATOR = 'moderator';
    const SUPERMODERATOR = 'superuser';
}
```

After implementing the class you can get a list of constants from this class. Use ```list()``` or ```getConstants()``` to do this.

**Example #2 Getting all constants from the parent class**
```php
$constants = Roles::list();
// or
$constants = Roles::getConstants();

// Output $constants: [
//    'USER' => 'user',
//    'SUPERUSER' => 'superuser',
//    'CLIENT' => 'client',
//    'MODERATOR' => 'moderator',
//    'SUPERMODERATOR' => 'superuser',
// ]
```

If you want to get one value then use the ```getConst()``` function. The function gets a case-sensitive name of constant. By convention, constant identifiers are always uppercase.

**Example #3 Getting values of constants of the class**
```php
$user = Roles::getConst('USER'); // Output: 'user'
$superuser = Roles::getConst('SUPERUSER'); // Output: 'superuser'
$root = Roles::getConst('ROOT'); // Output: null, because it is not defined
$user = Roles::getConst('user'); // Output: null, because the constant was defined in uppercase
```

The `Roles` class contains the constants for us.
You will probably want some other constants. Extend the class to solve the problem. This need exists when you uses third-party classes.

**Example #4 Extending the parent class**
```php
namespace App\Enums;

use AnyoneVendor\MyPackage\Enums\Roles as BaseRoles;

class Roles extends BaseRoles
{
    // Defines new constants
    const VIEWER = 'viewer';
    const CHECKER = 'checker';
    const TESTER = 'tester';

    // Replaces old values of constants
    const SUPERUSER = 'root';
    const SUPERMODERATOR = 'supermoderator';
}
```

See the examples of the new child class.

**Example #5 Checking of existing constants**
```php
Roles::isDefined('SUPERUSER'); // true
Roles::isDefined('ROOT'); // false
```

**Example #6 Getting new constants**
```php
$constants = Roles::list();

// Output $constants: [
//    'USER' => 'user',
//    'SUPERUSER' => 'root',
//    'CLIENT' => 'client',
//    'MODERATOR' => 'moderator',
//    'SUPERMODERATOR' => 'superuser',
//    'VIEWER' => 'viewer',
//    'CHECKER' => 'checker',
// ]
```

**Example #6 Getting a value of the replaced constant**
```php
$superuser = Roles::getConst('SUPERUSER'); // 'root'
```

You can get some constant using the standard PHP syntax. If you try to take a undefined constant then you will catch an error.
If you are not sure about an existing constant then use the ```getConst()``` function and you will not catch an error.

**Example 7 Getting values using the standard PHP function**
```php
$superuser = Roles::SUPERUSER; // 'root'
$root = Roles::ROOT; // Error: Undefined class constant 'ROOT'
```

## <a name="abstract-enum"></a> AbstractEnum

AbstractEnum is the abstract class for implementing a list of named constants and getting their values. It was extended from AbstractConstants.

In contract to the `Belca\Support\AbstractConstants` class, the `Belca\Support\AbstractEnum` uses a constant with default value.

|Function|Description|
|--|--|
|```getConstants()```|Returns all constants of the class.|
|```list()```|The alias of the ```getConstants()``` function.|
|```getLastConstants()```|Returns an array of constants defined in the called class without constants of parrent classes.|
|```getParentConstants()```|Returns all constants of parent classes.|
|```getConst($name)```|*$name* - a name of constant.<br/><br/> Returns a value of a given constant if it exists, else returns *null*.<br/>  This is a safe method for calling constants, in otherwise when you calls undefined constants you will catch an error.|
|```isDefined($name)```|*$name* - a name of constant. <br/><br/> Checks whether a given constant exists and is defined in the class.|
|```getDefault()```|Returns the last defined default constant.|

> The function that return a list of contains do not return the DEFAULT constant.

This class have a new function: the ```getDefault()``` function. The other functions are the same.

**Example #8 Implementing the first (parent) class with a default value**
```php
namespace AnyoneVendor\MyPackage\Enums;

use Belca\Support\AbstractEnum;

class Roles extends AbstractEnum
{
    const DEFAULT = self::USER;

    const USER = 'user';
    const SUPERUSER = 'root';
    const CLIENT = 'client';
}
```

Get the default value using the ```getDefault()``` function.

**Example #9 Getting the default value**
```php
$default = Roles::getDefault(); // 'user'
```

Also you can get the default value using the PHP syntax.

**Example #10 Getting the default value using the PHP syntax**
```php
$default = Roles::DEFAULT; // 'user'
```

You can redefine the default constant by means of extending class.

**Example #11 Redefining the default constant**
```php
namespace App\Enums;

use AnyoneVendor\MyPackage\Enums\Roles as BaseRoles;

class Roles extends BaseRoles
{
    const DEFAULT = self::UNREGISTRED;

    const UNREGISTERED = 'unregistered';
}
```

## License

The package and other [Belca components](https://github.com/belcacomponents) are open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
