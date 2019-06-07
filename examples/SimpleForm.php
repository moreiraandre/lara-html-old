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
        $row->addText('nome');
        $row->addText('fone');
        $row->addText('dt_nasc', 'Nascimento');
        $r2 = $row->row();

    }
}
