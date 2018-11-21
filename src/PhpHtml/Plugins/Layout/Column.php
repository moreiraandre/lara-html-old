<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 21/11/18
 * Time: 02:06
 */

namespace PhpHtml\Plugins\Layout;


use PhpHtml\Interfaces\PluginInterface;

class Column implements PluginInterface
{

    private
        $content,
        $number;

    public function __construct(string $content, int $number)
    {
        $this->content = $content;
        $this->number = $number;
    }

    public function getHtml(): string
    {
        return "<div class='col-md-$this->number'>$this->content</div>";
    }

}