# Support - вспомогательные классы PHP

> Документация актуальна для версии v0.10.

Вспомогательные классы и их функции могут быть использованы в любом PHP-проекте.

Вспомогательные классы используются в компонентах Belca.

## <a name="constants"></a> Константы и перечисления (Constants & Enum)

Именованные константы и перечисления используются для неизменяемых значений. Классы ниже содержат функции для извлечения списка констант и для получения констант без выброса исключений.

|||
|--|--|
|[AbstractConstants](#abstract-constants)|[AbstractEnum](#abstract-enum)|

### <a name="abstract-constants"></a> AbstractConstants

AbstractConstants - абстрактный класс для реализации списка именованных констант и получения их значений.

|Имена функций|Описание функций|
|--|--|
|getConstants()|Возвращает все константы используемого класса.|
|getLastConstants()|Возвращает массив констант определенных в вызываемом классе и не возвращает константы родительских классов.|
|getParentConstants()|Возвращает все константы родительских классов.|
|getConst($const)|$const - имя константы.<br/><br/> Возвращает значение указанной константы, если оно существует, иначе возвращает *null*.<br/> Это безопасный метод вызова констант, т.к. вызывая константу другим способом вы можете получить ошибку, если контанта не существует.|
|isDefined($const)|$const - имя константы. <br/><br/> Проверяет существование константы в используемом классе.|

Возможно вы будите использовать только один класс констант, и тогда он будет примерно таким, как показано ниже.

```php
use Belca\Support\AbstractConstants;

class FirstConstants extends AbstractConstants
{
    const USER = 'user';
    const SUPERUSER = 'superuser';
    const CLIENT = 'client';
    const MODERATOR = 'moderator';
    const SUPERMODERATOR = 'super'.self::USER;
}
```

В классе `FirstConstants` мы объявили все необходимые нам константы. Спустя какое-то время у нас появилась необходимость добавить еще констант. Мы можем это осуществить в том же классе, но если мы разрабатываем пакет, то у нас это будет выглядеть так, как показано ниже.

```php
class SecondConstants extends FirstConstants
{
    const VIEWER = 'viewer';
    const CHECKER = 'checker';
    const TESTER = 'tester';
    const SUPERUSER = 'root'; // заменяет предыдущее значение
    const SUPERMODERATOR = 'supermoderator'; // заменяет предыдущее значение
}
```

В новом классе констант мы можем переопределить ранее объявленные значения.

Давайте посмотрим примеры использования наших созданных классов.

```php
// Получим все константы классов
$allFirstConstants = FirstConstants::getConstants();
$allSecondConstants = SecondConstants::getConstants();

// Output $allFirstConstants: [
//    'USER' => 'user',
//    'SUPERUSER' => 'superuser',
//    'CLIENT' => 'client',
//    'MODERATOR' => 'moderator',
//    'SUPERMODERATOR' => 'superuser',
// ]
//
// Output $allSecondConstants: [
//    'USER' => 'user',
//    'SUPERUSER' => 'root',
//    'CLIENT' => 'client',
//    'MODERATOR' => 'moderator',
//    'SUPERMODERATOR' => 'superuser',
//    'VIEWER' => 'viewer',
//    'CHECKER' => 'checker',
// ]

// Получим конкретные константы FirstConstants
$user = FirstConstants::getConst('USER'); // 'user'
$superuser = FirstConstants::getConst('SUPERUSER'); // 'superuser'
$root = FirstConstants::getConst('ROOT'); // null

// Получим конкретные константы SecondConstants
$user = SecondConstants::getConst('USER'); // 'user'
$superuser = SecondConstants::getConst('SUPERUSER'); // 'root'
$root = SecondConstants::getConst('ROOT'); // null

// Проверим существование констант
SecondConstants::isDefined('SUPERUSER'); // true
SecondConstants::isDefined('ROOT'); // false
```

В примере выше мы получили все константы, получили конкретные константы, попытались получить несуществующую константу и проверили существование константы в классе.

Конечно, мы можем обращаться к конкретным константам напрямую, но обратившись к несуществующей константе мы получим исключение. Поэтому лучше использовать функции класса.

```php
$superuser = SecondConstants::SUPERUSER; // 'root'
$root = SecondConstants::ROOT; // Error: Undefined class constant 'ROOT'
```

### <a name="abstract-enum"></a> AbstractEnum

AbstractEnum - абстрактный класс для реализации списка именованных констант и возвращения их значений.  Отличие от `Belca\Support\AbstractConstants` класса, класс `Belca\Support\AbstractEnum` использует константу по умолчанию.

|Имена функций|Описание функций|
|--|--|
|getConstants()| Возвращает все константы класса без значения по умолчанию (значение по умолчанию может ссылаться на одну из констант).|
|getLastConstants()|Возвращает массив констант определенных в вызываемом классе и не возвращает константы родительских классов.|
|getParentConstants()|Возвращает все константы родительских классов без значения по умолчанию.|
|getConst($const)|$const - имя константы.<br/><br/> Возвращает значение указанной константы, если оно существует, иначе возвращает *null*.<br/> Это безопасный метод вызова констант, т.к. вызывая константу другим способом вы можете получить ошибку, если контанта не существует.|
|isDefined($const)|$const - имя константы. <br/><br/> Проверяет существование константы в используемом классе.|
|getDefault()|Возвращает последнее объявленное значение по умолчанию.|

Функции реализованного класса от `AbstractEnum` идентичны классу `AbstractConstants`, за исключением одного. Вам доступна новая функция - `getDefault()`. Также немного отличается и реализация класса.

```php
use Belca\Support\AbstractEnum;

class FirstConstants extends AbstractEnum
{
    const DEFAULT = self::USER;

    const USER = 'user';
    const SUPERUSER = 'root';
    const CLIENT = 'client';
}
```

```php
$defaultValue = FirstConstants::getDefault(); // 'user'
```

Расширяя класс мы можем переопределить значение по умолчанию.
