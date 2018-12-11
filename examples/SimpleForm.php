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
        /*$this->phpHtml->addText('a');
        $this->phpHtml->addText('a');
        $this->phpHtml->row();
        $this->phpHtml->addText('a');*/

        $form = $this->phpHtml->addForm('/');
        $form->addText('a');
        $form->addText('b');
//        $formCol = $form->getCol();
//        dd($formCol);
//        $formCol->addText('apelido');
    }
}
