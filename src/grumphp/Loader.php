<?php

namespace ComposerDanglingLockedDeps\GrumPHP;

use GrumPHP\Extension\ExtensionInterface;

/**
 * Class Loader
 *
 * @package ComposerDanglingLockedDeps
 */
class Loader implements ExtensionInterface
{

  public function imports(): iterable {
    return [
      __DIR__ . '/../../composer_dangling_locked_deps.yml',
    ];
  }
}
