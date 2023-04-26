<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Command;

use Cloudinary\Api\ApiResponse;
use Psl\Filesystem;
use Speicher210\CloudinaryBundle\Cloudinary\Uploader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Throwable;

final class UploadCommand extends Command
{
    private readonly Uploader $uploader;

    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('sp210:cloudinary:upload')
            ->setDescription(
                'Upload files from a directory to Cloudinary. The public ID will be the name of the file. It will overwrite the existing files automatically.',
            )
            ->addArgument('directory', InputArgument::REQUIRED, 'The directory from where to upload the files.')
            ->addOption(
                'prefix',
                null,
                InputOption::VALUE_REQUIRED,
                'Add prefix to uploaded files.',
            )
            ->addOption(
                'filter',
                null,
                InputOption::VALUE_REQUIRED,
                'Filter to apply when scanning the directory (ex: "*.jpg").',
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $symfonyStyle = new SymfonyStyle($input, $output);

        $files  = Finder::create()->files()->in($input->getArgument('directory'));
        $prefix = $input->getOption('prefix');
        if ($input->getOption('filter') !== null) {
            $files->name($input->getOption('filter'));
        }

        $table = $symfonyStyle->createTable();
        $table->setHeaders(['Local file', 'Public ID', 'Error']);
        $table->render();

        foreach ($files as $file) {
            try {
                $publicId = $prefix . Filesystem\get_filename($file->getFilename());
                $response = $this->uploadFileToCloudinary($file, $publicId);

                $table->appendRow(
                    [
                        $file->getRealPath(),
                        $response['public_id'],
                        null,
                    ],
                );
            } catch (Throwable $e) {
                $table->appendRow(
                    [
                        $file->getRealPath(),
                        $response['public_id'] ?? null,
                        $e->getMessage(),
                    ],
                );
            }
        }

        return Command::SUCCESS;
    }

    private function uploadFileToCloudinary(SplFileInfo $file, string $publicId): ApiResponse
    {
        return $this->uploader->upload(
            $file->getRealPath(),
            ['public_id' => $publicId],
        );
    }
}
