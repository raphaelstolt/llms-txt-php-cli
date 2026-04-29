<?php

declare(strict_types=1);

namespace Stolt\LlmsTxt\Cli\Commands;

use Symfony\Component\Console\Output\OutputInterface;
trait CurlExtensionGuard
{
    private function guardCurlExtension(OutputInterface $output): bool
    {
        if (\extension_loaded('curl')) {
            return true;
        }

        $output->writeln('<error>The curl extension is required to run this command.</error>');

        return false;
    }
}
