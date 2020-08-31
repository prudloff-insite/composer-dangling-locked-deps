<?php

namespace ComposerDanglingLockedDeps\GrumPHP;

use GrumPHP\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class Loader
 *
 * @package ComposerDanglingLockedDeps
 */
class Loader implements ExtensionInterface
{

  /**
   * @param ContainerBuilder $container
   */
  public function load(ContainerBuilder $container)
  {
    $container->register('task.composer_dangling_locked_deps', ComposerDanglingLockedDeps::class)
      ->addArgument(new Reference('config'))
      ->addArgument(new Reference('process_builder'))
      ->addArgument(new Reference('formatter.raw_process'))
      ->addTag('grumphp.task', ['config' => 'composer_dangling_locked_deps']);
  }
}
