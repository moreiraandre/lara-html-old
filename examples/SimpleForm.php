<?php
/**
 * User: andre
 * Date: 21/11/18
 * Time: 00:11
 */


class SimpleForm extends \PhpHtml\Abstracts\ScreenAbstract
{
    public function run()
    {
        $this->phpHtml->form()->text('apelido');
        $this->phpHtml->form()->text('endereco');
    }
}

$container = Illuminate\Container\Container::getInstance(); // Retorna um objeto do service container Laravel
$obj = $container->make(SimpleForm::class); // Resolve as dependências da classe
echo $obj->getHtml();