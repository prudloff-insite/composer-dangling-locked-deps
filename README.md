# Composer Dangling Locked Deps

This Composer plugin allows you to detect dangling locked dependencies.

That is dependencies that are present in your `composer.lock` files
but are not actually required by your project or one of its dependencies.

This can happen, for example, when merging changes to `composer.lock` with conflicts;
a dependency that has been removed from `composer.json`
will not be correctly removed from `composer.lock` and will continue to be installed.

## Install

```shell script
composer require insite/composer-dangling-locked-deps --dev
```

## Usage

```shell script
composer dangling-locked-deps
```

You can then call `composer remove` on those dependencies.
