<?php

namespace Examples;

use LaraHtml\Grid\Screen;

class PersonForm extends Screen
{
    public function run()
    {
        $form = $this->addForm('/');
        $form->addText('nome');
        $form->addText('fone');
        $form->row();
        $form->addButton('Enviar');
        /*$colFone = $this->addText('fone')->getCol();
        $colFone->addText('cel');
        $colFone->row();
        $colFone->addText('trabalho');
        $this->row();
        $col = $this->addText('endereco')->getCol();
        $col->row();
        $col->addText('j');*/
    }
}
