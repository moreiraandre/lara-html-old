<?php
/**
 * Created by: André Moreira
 * Date: 21/11/18
 * Time: 00:11
 */

namespace Examples;

use PhpHtml\PhpHtml;

class SimpleForm extends PhpHtml
{
    public function run()
    {
        /*$this->addText('nome');
        $this->addText('nome');*/
        $form = $this->addForm('/');
        $form->addText('nome');
        /*$form->row();
        $form->addText('endereco');
        $form->row();
        $form->addText('fone');
        $colCel = $form->addText('cel')->getCol();
        $colCel->addText('cel2');
        $colCel->addText('cel3');*/
    }
}
