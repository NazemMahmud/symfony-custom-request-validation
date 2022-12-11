<?php

namespace Piash\Command;

use Piash\Helper\Generator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Piash\Helper\RequestTemplate;

#[AsCommand(
    name: 'piash:request',
    description: 'This command creates a custom request file for form request validation',
    aliases: ['piash:add-request'],
    hidden: false,
)]
class MakeRequestCommand extends Command
{
    private $generator;
    private $folderName;

    public function __construct(Generator $generator)
    {
        parent::__construct();
        $this->generator = $generator;
        $this->folderName = 'Requests';
    }


    protected function configure(): void
    {
        $this->setName('piash:request')
            ->setDescription('This command creates a custom request file for form request validation')
            ->setHelp('Run this command to create your custom request validation class')
            ->addArgument('filename', InputArgument::REQUIRED, 'File name for the request class.');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filename = $input->getArgument('filename');
        $this->createTemplate($filename, $output);
        return Command::SUCCESS;
    }


    protected function createTemplate(string $filename, $output): void
    {
        $rootDir = $this->generator->getAppRootDir();
        $dirPath = $rootDir . '/src/' . $this->folderName;

        try {
            if (!file_exists($dirPath)) {
                mkdir($dirPath, 0777, true);
            }
            $template = new RequestTemplate($filename, $dirPath);
            $template->render();
            $output->writeln($filename . " successfully created...");
        } catch (\Exception $ex) {
            $output->writeln($ex->getMessage());
        }
    }
}
