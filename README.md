# PHPStan Extensions

[![Downloads total](https://img.shields.io/packagist/dt/symplify/phpstan-extensions.svg?style=flat-square)](https://packagist.org/packages/symplify/phpstan-extensions/stats)

<br>

## Install

```bash
composer require symplify/phpstan-extensions --dev
```

<b>

## Symplify Error Formatter

Update your `phpstan.neon` config:

```yaml
parameters:
    errorFormat: symplify
```

- Do you want to **click the error and get right to the line in the file** it's reported at?
- Do you want to **copy-paste regex escaped error to your `ignoreErrors`**?

Works best with [anthraxx/intellij-awesome-console](https://github.com/anthraxx/intellij-awesome-console)

```bash
vendor/bin/phpstan analyse src
```

↓

```bash
------------------------------------------------------------------------------------------
src/Command/ReleaseCommand.php:51
------------------------------------------------------------------------------------------
- "Call to an undefined method Symplify\\Command\\ReleaseCommand\:\:nonExistingCall\(\)"
------------------------------------------------------------------------------------------
```

<br>

## Improved Symfony Types

#### `ContainerGetTypeExtension`

With Symfony container and type as an argument, you always know **the same type is returned**:

```php
use Symfony\Component\DependencyInjection\Container;

/** @var Container $container */
// PHPStan: object ❌
$container->get(Type::class);
// Reality: Type ✅
$container->get(Type::class);

// same for in-controller/container-aware context
$this->get(Type::class);
```

<br>

#### `KernelGetContainerAfterBootReturnTypeExtension`

After Symfony Kernel boot, `getContainer()` always returns the container:

```php
use Symfony\Component\HttpKernel\Kernel;

final class AppKernel extends Kernel
{
    // ...
}

$kernel = new AppKernel('prod', false);
$kernel->boot();

// PHPStan: null|ContainerInterface ❌
$kernel->getContainer();
// Reality: ContainerInterface ✅
$kernel->getContainer();
// Reality: ContainerInterface ✅
```

<br>

#### `SplFileInfoTolerantReturnTypeExtension`

Symfony Finder finds only existing files (obviously), so the `getRealPath()` always return `string`:

```php
use Symfony\Component\Finder\Finder;

$finder = new Finder();

foreach ($finder as $fileInfo) {
    // PHPStan: false|string ❌
    $fileInfo->getRealPath();
    // Reality: string ✅
    $fileInfo->getRealPath();
}
```

<br>

Happy coding!
