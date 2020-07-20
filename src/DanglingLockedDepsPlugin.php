<?php

namespace ComposerDanglingLockedDeps;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;

/**
 * Class DanglingLockedDepsPlugin
 *
 * @package ComposerDanglingLockedDeps
 */
class DanglingLockedDepsPlugin implements PluginInterface, Capable {

  /**
   * @param \Composer\Composer $composer
   * @param \Composer\IO\IOInterface $io
   */
  public function activate(Composer $composer, IOInterface $io) {
  }

  /**
   * @return string[]
   */
  public function getCapabilities() {
    return [
      CommandProvider::class => DanglingLockedDepsCommandProvider::class,
    ];
  }

  /**
   * @param \Composer\Composer $composer
   * @param \Composer\IO\IOInterface $io
   */
  public function deactivate(Composer $composer, IOInterface $io) {

  }

  /**
   * @param \Composer\Composer $composer
   * @param \Composer\IO\IOInterface $io
   */
  public function uninstall(Composer $composer, IOInterface $io) {

  }
}