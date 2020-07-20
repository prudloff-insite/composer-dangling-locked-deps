<?php

namespace ComposerDanglingLockedDeps;

use Composer\Plugin\Capability\CommandProvider;

/**
 * Class DanglingLockedDepsCommandProvider
 *
 * @package ComposerDanglingLockedDeps
 */
class DanglingLockedDepsCommandProvider implements CommandProvider {

  /**
   * @return \Composer\Command\BaseCommand[]|\ComposerDanglingLockedDeps\DanglingLockedDepsCommand[]
   */
  public function getCommands() {
    return [
      new DanglingLockedDepsCommand(),
    ];
  }
}