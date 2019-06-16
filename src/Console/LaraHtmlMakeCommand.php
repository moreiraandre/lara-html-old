<?php

namespace LaraHtml\Console;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class LaraHtmlMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:lhtml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new lara-html class';

    /**
     * Execute the console command.
     *
     * @return bool|void|null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return;
        }
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        return $class;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/lara-html.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Screens';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the lara-html already exists'],
        ];
    }
}
