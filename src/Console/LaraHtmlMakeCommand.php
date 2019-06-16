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
     * The type of class being generated.
     *
     * @var string
     */
//    protected $type = 'LaraHtml';

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
        $this->type = "$name"; // ARMAZENANDO NOME DA CLASSE PARA EXIBIR AO USUÁRIO
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
        $rootNamespace .= '\Screens';
        $this->type = $rootNamespace.'\\'.$this->type; // CONCATENANDO NOME DA CLASSE COM O NAMESPACE PARA EXIBIR AO USUÁRIO
        return $rootNamespace;
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
