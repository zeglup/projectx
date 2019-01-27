<?php
/**
 * Created by PhpStorm.
 * User: Glup
 * Date: 27/01/2019
 * Time: 18:20
 */

namespace App\Command;

use Symfony\Component\Workflow\Registry;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpGraphCommand extends Command
{
    protected static $defaultName = 'app:dump_graph';
    private $workflow;

    public function __construct(string $workflow)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->workflow = $workflow;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Dump SF workflow.');
        $this->addArgument('workflow', InputArgument::REQUIRED, 'Worflow to dump ?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $input->hasArgument('workflow') ? $workflow = $input->getArgument('workflow' ) : $workflow = $this->workflow;
        $process = new Process(['php bin/console workflow:dump ' . $workflow . ' --dump-format=puml | java -jar bin/plantuml.jar -p  > public/img/graph_' . $workflow . '.png']);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }
}