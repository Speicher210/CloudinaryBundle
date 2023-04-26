<?php

declare(strict_types=1);

namespace Speicher210\CloudinaryBundle\Command;

use Cloudinary\Api\Response;
use Speicher210\CloudinaryBundle\Cloudinary\Api;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

use function assert;
use function sprintf;

/**
 * Command to remove resources from Cloudinary API.
 */
class DeleteCommand extends Command
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
        $helper = $this->getHelper('question');
        assert($helper instanceof QuestionHelper);
        $question = new ConfirmationQuestion(
            '<question>Are you sure you want to remove all resources based on your criteria?</question> [Y]',
        );
        if ($helper->ask($input, $output, $question) !== true) {
            return Command::SUCCESS;
        }

        if ($input->getOption('prefix')) {
            $this->removeByPrefix($input, $output);
        }

        if (! $input->getOption('resource')) {
            return Command::SUCCESS;
        }

        $this->removeResource($input, $output);

        return Command::SUCCESS;
    }

    /**
     * Remove resources by prefix.
     *
     * @param InputInterface  $input  Console input.
     * @param OutputInterface $output Console output.
     */
    private function removeByPrefix(InputInterface $input, OutputInterface $output): void
    {
        $prefix = $input->getOption('prefix');
        $output->writeln(
            sprintf('<comment>Removing all resources from <info>%s</info></comment>', $prefix),
        );

        $response = $this->api->delete_resources_by_prefix($prefix);
        $this->outputApiResponse($response, 'deleted', $output);
    }

    /**
     * Remove a resource.
     *
     * @param InputInterface  $input  Console input.
     * @param OutputInterface $output Console output.
     */
    private function removeResource(InputInterface $input, OutputInterface $output): void
    {
        $resource = $input->getOption('resource');
        $output->writeln(
            sprintf('<comment>Removing resource <info>%s</info></comment>', $resource),
        );

        $response = $this->api->delete_resources($resource);
        $this->outputApiResponse($response, 'deleted', $output);
    }

    /**
     * Output the API response.
     *
     * @param Response        $response The response
     * @param string          $part     The part of the response to output.
     * @param OutputInterface $output   The console output.
     */
    private function outputApiResponse(Response $response, string $part, OutputInterface $output): void
    {
        $table = new Table($output);
        $table->setHeaders(['Resource', 'Status']);
        foreach ($response[$part] as $file => $status) {
            $table->addRow([$file, $status]);
        }

        $table->render();
    }
}
