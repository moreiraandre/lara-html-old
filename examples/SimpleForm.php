<?php
/**
 * Created by: André Moreira
 * Date: 21/11/18
 * Time: 00:11
 */


class SimpleForm extends \PhpHtml\Abstracts\ScreenAbstract
{
    public function run()
    {
        $this->phpHtml->form()->text('apelido');
        $this->phpHtml->form()->text('endereco', 'Endereço');
    }
}
