<?php

namespace ComposerDanglingLockedDeps;

use Composer\Command\BaseCommand;
use Composer\InstalledVersions;
use Composer\Repository\ArrayRepository;
use Composer\Repository\CompositeRepository;
use Composer\Repository\InstalledRepository;
use Composer\Repository\LockArrayRepository;
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
   * @todo Ignore virtual packages
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $composer = $this->getComposer();
    $rootPackage = $composer->getPackage();
    $localRepository = $composer->getRepositoryManager()->getLocalRepository();

    if (class_exists(InstalledRepository::class)) {
      // Composer 2
      $repository = new InstalledRepository([
        new LockArrayRepository([$rootPackage]),
        $localRepository,
      ]);
    }
    else {
      // Composer 1
      $repository = new CompositeRepository([
        new ArrayRepository([$rootPackage]),
        $localRepository,
      ]);
    }

    $io = $this->getIO();

    $exitCode = 0;

    foreach (InstalledVersions::getInstalledPackages() as $package) {
      if ($package != $rootPackage->getName()) {
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
