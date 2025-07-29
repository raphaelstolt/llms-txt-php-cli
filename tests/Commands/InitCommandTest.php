<?php

declare(strict_types=1);

namespace Stolt\LlmsTxt\Cli\Tests\Commands;

use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\Attributes\Test;
use Stolt\LlmsTxt\Cli\Commands\InitCommand;
use Stolt\LlmsTxt\Cli\Commands\ValidateCommand;
use Stolt\LlmsTxt\Cli\Tests\TestCase;
use Stolt\LlmsTxt\LlmsTxt;
use Zenstruck\Console\Test\TestCommand;

final class InitCommandTest extends TestCase
{
    #[Test]
    #[RunInSeparateProcess]
    public function detectsExistingLlmsFile(): void
    {
        $this->setUpTemporaryDirectory();
        \chdir($this->temporaryDirectory);
        \touch('existing-test.md');

        $initCommand = new InitCommand(
            new LlmsTxt()
        );

        $expectedOutput = <<<CONTENT
The llms txt file existing-test.md already exists.
CONTENT;

        TestCommand::for($initCommand)
            ->addArgument('existing-test.md')
            ->execute()
            ->assertOutputContains($expectedOutput)
            ->assertFaulty();
    }

    #[Test]
    #[RunInSeparateProcess]
    public function initsExpectedLlmsFile(): void
    {
        $this->setUpTemporaryDirectory();
        \chdir($this->temporaryDirectory);

        $initCommand = new InitCommand(
            new LlmsTxt()
        );

        $validateCommand = new ValidateCommand(
            new LlmsTxt()
        );

        $expectedOutput = <<<CONTENT
Created llms txt file init-test.md.
CONTENT;

        TestCommand::for($initCommand)
            ->addArgument('init-test.md')
            ->execute()
            ->assertOutputContains($expectedOutput)
            ->assertSuccessful();

        TestCommand::for($validateCommand)
            ->addArgument('init-test.md')
            ->execute()
            ->assertSuccessful();
    }

    #[Test]
    #[RunInSeparateProcess]
    public function respondsAsExpectedWhenUnableToInit(): void
    {
        $this->setUpTemporaryDirectory();
        \chdir($this->temporaryDirectory);

        $llmsTxtStub = $this->createStub(LlmsTxt::class);

        $llmsTxtStub->method('initialise')
            ->willReturn(new LlmsTxt());

        $initCommand = new InitCommand($llmsTxtStub);

        $expectedOutput = <<<CONTENT
Unable to create llms txt file init-test.md.
CONTENT;

        TestCommand::for($initCommand)
            ->addArgument('init-test.md')
            ->execute()
            ->assertOutputContains($expectedOutput)
            ->assertFaulty();
    }
}
