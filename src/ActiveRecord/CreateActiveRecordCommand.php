<?php


namespace Depa\Tooling\ActiveRecord;


use Symfony\Component\Console\Command\Command;

class CreateActiveRecordCommand extends Command
{

    public const HELP = <<< 'EOT'
Create a new active record for the application.
- ...
- ...
- ...
EOT;

    /**
     * Configure command.
     */
    protected function configure() : void
    {
        $this->setDescription('Create a ActiveRecord');
        $this->setHelp(self::HELP);
        CommandCommonOptions::addDefaultOptionsAndArguments($this);
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $activeRecord = $input->getArgument('activeRecord');

        $generator = new CreateActiveRecord();
        $path = $generator->process($activeRecord);
        $output->writeln('<info>Success!</info>');
        $output->writeln(sprintf(
            '<info>- Created class %s, in file %s</info>',
            $activeRecord,
            $path
        ));

    }

    private function generateService(string $middlewareClass, InputInterface $input, OutputInterface $output) : int
    {
        $serviceInput = new ArrayInput([
            'command'       => 'service:create',
            'class'         => $activeRecordClass,
            '--no-register' => $input->getOption('no-register'),
        ]);
        $command = $this->getApplication()->find('service:create');
        return $command->run($serviceInput, $output);
    }

}