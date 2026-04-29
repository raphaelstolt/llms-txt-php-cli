<?php

declare(strict_types=1);

namespace Stolt\LlmsTxt\Cli\Commands;

use PhpPkg\CliMarkdown\CliMarkdown;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class RenderCommand extends Command
{
    use CurlExtensionGuard;

    public const NOT_LLMS_TXT_FOUND_AT_URI = 'no llms.txt file found at uri';

    protected function configure(): void
    {
        $this->setName('render');
        $description = 'Render the given llms.txt file';
        $this->setDescription($description);

        $llmsTxtFileDescription = 'The llms.txt file to render';

        $this->addArgument(
            'llms-txt-file',
            InputArgument::OPTIONAL,
            $llmsTxtFileDescription,
            'llms.txt'
        );

        $uriDescription = 'The URI at which to look for a llms.txt file to render';

        $this->addArgument(
            'uri',
            InputArgument::OPTIONAL,
            $uriDescription
        );
    }

    private function getLlmsTxtFileContentFromUrl(string $url): mixed
    {
        $curlHandle = \curl_init();
        \curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        \curl_setopt($curlHandle, CURLOPT_URL, $url);
        $data = \curl_exec($curlHandle);
        \curl_close($curlHandle);

        if (\str_contains($data, '404')) {
            return self::NOT_LLMS_TXT_FOUND_AT_URI;
        }

        return $data;
    }

    private function renderLlmsTxtFile(string $llmsTxtFileContent): string
    {
        $parser = new CliMarkdown();

        return $parser->render($llmsTxtFileContent);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $llmsTxtFileToRender = (string) $input->getArgument('llms-txt-file');

        if (\is_dir($llmsTxtFileToRender)) {
            $llmsTxtFileToRender.= DIRECTORY_SEPARATOR . 'llms.txt';
        }

        if (\str_starts_with($llmsTxtFileToRender, 'http')) {
            if ($this->guardCurlExtension($output) === false) {
                return $this->curlExtensionFailureCode();
            }

            $remoteLlmTxtContent = $this->getLlmsTxtFileContentFromUrl($llmsTxtFileToRender . DIRECTORY_SEPARATOR . 'llms.txt');

            if ($remoteLlmTxtContent === self::NOT_LLMS_TXT_FOUND_AT_URI) {
                $warning = \sprintf("Warning: No llms.txt file found at the provided URI %s.", $llmsTxtFileToRender);
                $outputContent = '<error>' . $warning . '</error>';
                $output->writeln($outputContent);

                return Command::FAILURE;
            }

            $renderedLlmsTxtContent = $this->renderLlmsTxtFile($remoteLlmTxtContent);
            $output->writeln($renderedLlmsTxtContent);

            return Command::SUCCESS;
        } else {
            $llmsTxtFileToRender = \realpath($llmsTxtFileToRender);

            $renderedLlmsTxtContent = $this->renderLlmsTxtFile(\file_get_contents($llmsTxtFileToRender));
            $output->writeln($renderedLlmsTxtContent);

            return Command::FAILURE;
        }
    }
}
