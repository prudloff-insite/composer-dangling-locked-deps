<?php

namespace ComposerDanglingLockedDeps;

use Composer\Command\BaseCommand;
use Composer\InstalledVersions;
use Composer\Repository\ArrayRepository;
use Composer\Repository\CompositeRepository;
use Composer\Repository\InstalledRepository;
use Composer\Repository\LockArrayRepository;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;
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
    $io = $this->getIO();

    // This tells composer-merge-plugin that we want merged dev dependencies.
    $event = new Event(ScriptEvents::PRE_AUTOLOAD_DUMP, $composer, $io, true);
    $this->getComposer()
      ->getEventDispatcher()
      ->dispatch($event->getName(), $event);

    $repository = new InstalledRepository([
      new LockArrayRepository([$rootPackage]),
      $localRepository,
    ]);

    $exitCode = 0;

    foreach (InstalledVersions::getInstalledPackages() as $package) {
      if ($package != $rootPackage->getName()) {
        // This filters out virtual packages.
        if ($repository->findPackage($package, '*')) {
          $results = $repository->getDependents($package, NULL, FALSE, FALSE);
          if (empty($results)) {
            $io->error($package . ' is a dangling dependency.');

            $exitCode = 1;
          }
        }
      }
    }

    return $exitCode;
  }
}
