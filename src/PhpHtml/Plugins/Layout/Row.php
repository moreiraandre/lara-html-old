<?php
/**
 * User: andre
 * Date: 20/11/18
 * Time: 23:43
 */

namespace PhpHtml\Plugins\Layout;


use PhpHtml\Interfaces\PluginInterface;

class Row implements PluginInterface
{
    private $columns = [];

    public function col()
    {
        return $this->columns[] = app(Column::class);
    }

     public function getHtml(): string
     {
         $html = '';
         foreach ($this->columns as $col) {
             $html .= $col->getHtml();
         }

         return "<div class='row'>$html</div>";
     }
}