<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:36
 */

namespace PhpHtml\Managers;


use PhpHtml\Plugins\Form\Text;

class Form
{

    private $objPlugins = [];

    public function getPlugins()
    {
        return $this->objPlugins;
    }

    public function text(string $name, string $label = null)
    {
        return $this->objPlugins[] = new Text($name, $label);
    }

}