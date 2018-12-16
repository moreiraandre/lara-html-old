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
        $form = $this->addForm('/');
        $form->addText('nome');
        $form->row();
        $form->addText('endereco');
        $form->row();
        $form->addText('fone');
        $form->addText('cel');
    }
}
