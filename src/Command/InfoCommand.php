<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Command;

use Cloudinary\Api\Response;
use Speicher210\CloudinaryBundle\Cloudinary\Api;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function is_scalar;
use function log;
use function pow;
use function sprintf;

use const PHP_EOL;

/**
 * Command to get info about a resource.
 */
class InfoCommand extends Command
{
    /**
     * Cloudinary API.
     */
    private Api $api;

    public function __construct(Api $api)
    {
        $this->api = $api;

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
        $response = $this->api->resource($input->getArgument('public_id'));

        $this->renderProperties($output, $response);

        if ($output->getVerbosity() < OutputInterface::VERBOSITY_VERBOSE) {
            return Command::SUCCESS;
        }

        $output->writeln(PHP_EOL);
        $this->renderDerivedResources($output, $response['derived']);

        return Command::SUCCESS;
    }

    /**
     * Render the general properties.
     *
     * @param OutputInterface $output   The output.
     * @param Response        $response The API response.
     */
    protected function renderProperties(OutputInterface $output, Response $response): void
    {
        $table = new Table($output);
        $table->setHeaders(['Property', 'Value']);
        foreach ($response as $property => $value) {
            if (! is_scalar($value)) {
                continue;
            }

            $table->addRow([$property, $value]);
        }

        $table->render();
    }

    /**
     * Render the derived resources.
     *
     * @param OutputInterface $output           The output.
     * @param array<mixed>    $derivedResources The derived resources.
     */
    protected function renderDerivedResources(OutputInterface $output, array $derivedResources): void
    {
        $table = new Table($output);
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

    /**
     * Format the size of a file.
     *
     * @param int $bytes The number of bytes.
     */
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
