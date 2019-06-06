<?php
/**
 * Created by: André Moreira
 * Date: 21/11/18
 * Time: 00:11
 */

namespace Examples;

use PhpHtml\Finals\Row;

class SimpleForm
{
    public function run(Row $row)
    {
        /*$this->addText('nome');
        $this->addText('nome');*/
        $form = $row->addForm('/');
        $form->addText('nome');
        $form->addText('endereco');
        /*$form->row();
        $form->addText('endereco');
        $form->row();
        $form->addText('fone');
        $colCel = $form->addText('cel')->getCol();
        $colCel->addText('cel2');
        $colCel->addText('cel3');*/
    }
}
