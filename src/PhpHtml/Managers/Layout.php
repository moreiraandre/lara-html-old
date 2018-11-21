<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 20/11/18
 * Time: 23:35
 */

namespace PhpHtml\Managers;


use PhpHtml\Plugins\Layout\Column;

class Layout
{

    private $objPlugins = [];

    public function getPlugins()
    {
        return $this->objPlugins;
    }

    public function column(string $content, int $number)
    {
        return $this->objPlugins[] = new Column($content, $number);
    }

}