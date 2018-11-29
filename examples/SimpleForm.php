<?php
/**
 * Created by: André Moreira
 * Date: 21/11/18
 * Time: 00:11
 */

use PhpHtml\Abstracts\ScreenAbstract;

class SimpleForm extends ScreenAbstract
{
    public function run()
    {
        $this->phpHtml->text('apelido');
        $this->phpHtml->text('endereco', 'Endereço')->setReadonly('readonly');
    }
}
