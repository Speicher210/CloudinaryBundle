<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Command;

use Cloudinary\Api\ApiResponse;
use Psl\Str;
use Speicher210\CloudinaryBundle\Cloudinary\Admin;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class DeleteCommand extends Command
{
    private readonly Admin $cloudinary;

    public function __construct(Admin $cloudinary)
    {
        $this->cloudinary = $cloudinary;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('sp210:cloudinary:delete')
            ->setDescription('Remove resources from Cloudinary based on criteria.')
            ->addOption(
                'prefix',
                null,
                InputOption::VALUE_REQUIRED,
                'The prefix for the resources to remove.',
            )
            ->addOption(
                'resource',
                null,
                InputOption::VALUE_REQUIRED,
                'Remove one resource by public ID.',
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $symfonyStyle = new SymfonyStyle($input, $output);

        $confirm = $symfonyStyle->confirm('Are you sure you want to remove all resources based on your criteria?', false);

        if ($confirm !== true) {
            return Command::SUCCESS;
        }

        if ($input->getOption('prefix') !== null) {
            $this->removeByPrefix($input, $symfonyStyle);
        }

        if ($input->getOption('resource') !== null) {
            $this->removeResource($input, $symfonyStyle);
        }

        return Command::SUCCESS;
    }

    private function removeByPrefix(InputInterface $input, SymfonyStyle $symfonyStyle): void
    {
        $prefix = $input->getOption('prefix');
        $symfonyStyle->writeln(
            Str\format('<comment>Removing all resources from <info>%s</info></comment>', $prefix),
        );

        $response = $this->cloudinary->deleteAssetsByPrefix($prefix);
        $this->outputApiResponse($response, $symfonyStyle);
    }

    private function removeResource(InputInterface $input, SymfonyStyle $symfonyStyle): void
    {
        $resource = $input->getOption('resource');
        $symfonyStyle->writeln(
            Str\format('<comment>Removing resource <info>%s</info></comment>', $resource),
        );

        $response = $this->cloudinary->deleteAssets($resource);
        $this->outputApiResponse($response, $symfonyStyle);
    }

    private function outputApiResponse(ApiResponse $response, SymfonyStyle $symfonyStyle): void
    {
        $table = $symfonyStyle->createTable();
        $table->setHeaders(['Resource', 'Status']);

        foreach ($response['deleted'] as $file => $status) {
            $table->addRow([$file, $status]);
        }

        $table->render();
    }
}
