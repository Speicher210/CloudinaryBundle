<?php

namespace Speicher210\CloudinaryBundle\Command;

use Cloudinary\Api\Response;
use Speicher210\CloudinaryBundle\Cloudinary\Api;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to get info about a resource.
 */
class InfoCommand extends Command
{
    /**
     * Cloudinary API.
     *
     * @var Api
     */
    private $api;

    public function __construct(Api $api)
    {
        $this->api = $api;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('sp210:cloudinary:info')
            ->setDescription('Get information about a resource.')
            ->addArgument('public_id', InputArgument::REQUIRED, 'The public ID of the resource.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->api->resource($input->getArgument('public_id'));

        $this->renderProperties($output, $response);

        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
            $output->writeln(PHP_EOL);
            $this->renderDerivedResources($output, $response['derived']);
        }
    }

    /**
     * Render the general properties.
     *
     * @param OutputInterface $output   The output.
     * @param Response        $response The API response.
     */
    protected function renderProperties(OutputInterface $output, Response $response)
    {
        $table = new Table($output);
        $table->setHeaders(['Property', 'Value']);
        foreach ($response as $property => $value) {
            if (is_scalar($value)) {
                $table->addRow([$property, $value]);
            }
        }
        $table->render();
    }

    /**
     * Render the derived resources.
     *
     * @param OutputInterface $output           The output.
     * @param array           $derivedResources The derived resources.
     */
    protected function renderDerivedResources(OutputInterface $output, array $derivedResources)
    {
        $table = new Table($output);
        $table->setHeaders(
            [
                [new TableCell('Derived resources', ['colspan' => 5])],
                ['ID', 'Format', 'Size', 'Transformation', 'URL'],
            ]
        );
        foreach ($derivedResources as $resource) {
            $table->addRow(
                [
                    $resource['id'],
                    $resource['format'],
                    $this->formatSize($resource['bytes']),
                    $resource['transformation'],
                    $resource['url'],
                ]
            );
        }
        $table->render();
    }

    /**
     * Format the size of a file.
     *
     * @param int $bytes The number of bytes.
     *
     * @return string
     */
    private function formatSize($bytes)
    {
        $unit = 1024;
        if ($bytes <= $unit) {
            return $bytes.' b';
        }
        $exp = (int)(log($bytes) / log($unit));
        $pre = 'kMGTPE';
        $pre = $pre[$exp - 1];

        return sprintf('%.1f %sB', $bytes / pow($unit, $exp), $pre);
    }
}
