<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:35
 */

namespace PhpHtml\Managers;


use PhpHtml\Plugins\Layout\Col;
use PhpHtml\Plugins\Layout\Row;

class Layout
{

    private $objPlugins = [];

    public function getPlugins()
    {
        return $this->objPlugins;
    }

    public function col(string $content, int $number)
    {
        return $this->objPlugins[] = new Col($content, $number);
    }

    public function row()
    {
        return $this->objPlugins[] = new Row();
    }

}