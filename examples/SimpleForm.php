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

        $form = $this->phpHtml->form('/');
        $form->addText('apelido');
        $form->addText('endereco', 'Endereço')->setReadonly('readonly');
        $form->addText('ocupacao', 'Ocupação');
        $form->addText('ocupacao', 'Ocupação');
        $form->row();
        $form->addText('ocupacao', 'Ocupação');
        $form->addText('ocupacao', 'Ocupação');
        $form->row();
        $form->addText('ocupacao', 'Ocupação');
        $form->addText('ocupacao', 'Ocupação');
        $form->addText('ocupacao', 'Ocupação');
        $form->addText('ocupacao', 'Ocupação');
        $form->addText('ocupacao', 'Ocupação');
        $form->addText('ocupacao', 'Ocupação');
        $form->addText('ocupacao', 'Ocupação');
    }
}
