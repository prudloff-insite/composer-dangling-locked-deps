<?php

namespace ComposerDanglingLockedDeps;

use Composer\Command\BaseCommand;
use Composer\Repository\ArrayRepository;
use Composer\Repository\CompositeRepository;
use PackageVersions\Versions;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DanglingLockedDepsCommand
 *
 * @package DanglingLockedDeps
 */
class DanglingLockedDepsCommand extends BaseCommand {

  /**
   * @return void
   */
  protected function configure() {
    $this->setName('dangling-locked-deps')
      ->setDescription('Detect dangling locked dependencies');
  }

  /**
   * @param \Symfony\Component\Console\Input\InputInterface $input
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *
   * @return int
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $composer = $this->getComposer();
    $repository = new CompositeRepository([
      new ArrayRepository([$composer->getPackage()]),
      $composer->getRepositoryManager()->getLocalRepository(),
    ]);
    $io = $this->getIO();

    $exitCode = 0;

    foreach (Versions::VERSIONS as $package => $version) {
      if ($package != Versions::ROOT_PACKAGE_NAME) {
        $results = $repository->getDependents($package, NULL, FALSE, FALSE);
        if (empty($results)) {
          $io->error($package . ' is a dangling dependency.');

          $exitCode = 1;
        }
      }
    }

    return $exitCode;
  }
}
