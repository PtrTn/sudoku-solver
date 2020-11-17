<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Application\SolveSudokuCommand;
use App\Application\SolveSudokuCommandHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SolveCommand extends Command
{
    private FileSystemSudokuRepository $sudokuRepository;
    private JsonDecoder $jsonDecoder;
    private PuzzleJsonFormatter $puzzleJsonFormatter;
    private SolveSudokuCommandHandler $commandHandler;

    protected static $defaultName = 'app:solve';

    public function __construct(
        FileSystemSudokuRepository $sudokuRepository,
        JsonDecoder $jsonDecoder,
        PuzzleJsonFormatter $puzzleJsonFormatter,
        SolveSudokuCommandHandler $commandHandler
    ) {
        parent::__construct();
        $this->sudokuRepository = $sudokuRepository;
        $this->jsonDecoder = $jsonDecoder;
        $this->puzzleJsonFormatter = $puzzleJsonFormatter;
        $this->commandHandler = $commandHandler;
    }

    protected function configure()
    {
        $this->addArgument('puzzle-file', InputArgument::REQUIRED, 'File path to a JSON-encoded puzzle');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Starting to solve sudoku');

        $contents = $this->sudokuRepository->getContentsForFilePath($input->getArgument('puzzle-file'));
        $decoded = $this->jsonDecoder->decode($contents);
        $formatted = $this->puzzleJsonFormatter->format($decoded);

        $command = new SolveSudokuCommand($formatted);
        $this->commandHandler->handle($command);

        $output->writeln('Solved sudoku!');

        return Command::SUCCESS;
    }
}
