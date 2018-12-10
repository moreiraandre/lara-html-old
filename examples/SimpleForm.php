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

        $form = $this->phpHtml->addForm('/');
        $form->addText('apelido');
        echo "<pre>";
        print_r($form);
        echo "</pre>";
//        $form->addText('endereco', 'Endereço')->setReadonly('readonly');
        /*$form->addText('ocupacao', 'Ocupação');
        $form->addText('ocupacao', 'Ocupação');
        $form->row();
        $form->addText('ocupacao', 'Ocupação');
        $form->addText('ocupacao', 'Ocupação');
        $form->row();
        $form->addText('ocupacao', 'Ocupação');
        $form->addText('ocupacao', 'Ocupação');
        $form->addText('ocupacao', 'Ocupação');*/
        /*$col = $form->addText('ocupacao', 'Ocupação')->getCol();
        $col->addText('teste');*/
        /*$form->addText('ocupacao', 'Ocupação');
        $form->addText('ocupacao', 'Ocupação');
        $form->addText('ocupacao', 'Ocupação');*/
    }
}
