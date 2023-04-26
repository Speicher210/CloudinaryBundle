<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Command;

use Cloudinary\Api\ApiResponse;
use Speicher210\CloudinaryBundle\Cloudinary\Admin;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use function is_scalar;
use function log;
use function pow;
use function sprintf;

final class InfoCommand extends Command
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
            ->setName('sp210:cloudinary:info')
            ->setDescription('Get information about a resource.')
            ->addArgument('public_id', InputArgument::REQUIRED, 'The public ID of the resource.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $symfonyStyle = new SymfonyStyle($input, $output);

        $response = $this->cloudinary->asset($input->getArgument('public_id'));

        $this->renderProperties($symfonyStyle, $response);

        return Command::SUCCESS;
    }

    protected function renderProperties(SymfonyStyle $symfonyStyle, ApiResponse $response): void
    {
        $table = $symfonyStyle->createTable();
        $table->setHeaders(['Property', 'Value']);
        foreach ($response as $property => $value) {
            if (! is_scalar($value)) {
                continue;
            }

            $table->addRow([$property, $value]);
        }

        $table->render();

        if (! $symfonyStyle->isVerbose()) {
            return;
        }

        $symfonyStyle->newLine();
        $this->renderDerivedResources($symfonyStyle, $response['derived']);
    }

    /**
     * @param array<array{id: string, format: string, bytes: int, transformation: string, url: string}> $derivedResources
     */
    private function renderDerivedResources(SymfonyStyle $symfonyStyle, array $derivedResources): void
    {
        $table = $symfonyStyle->createTable();
        $table->setHeaders(
            [
                [new TableCell('Derived resources', ['colspan' => 5])],
                ['ID', 'Format', 'Size', 'Transformation', 'URL'],
            ],
        );
        foreach ($derivedResources as $resource) {
            $table->addRow(
                [
                    $resource['id'],
                    $resource['format'],
                    $this->formatSize($resource['bytes']),
                    $resource['transformation'],
                    $resource['url'],
                ],
            );
        }

        $table->render();
    }

    private function formatSize(int $bytes): string
    {
        $unit = 1024;
        if ($bytes <= $unit) {
            return $bytes . ' b';
        }

        $exp = (int) (log($bytes) / log($unit));
        $pre = 'kMGTPE';
        $pre = $pre[$exp - 1];

        return sprintf('%.1f %sB', $bytes / pow($unit, $exp), $pre);
    }
}
