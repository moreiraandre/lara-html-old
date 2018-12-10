<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:43
 */

namespace PhpHtml\Plugins;


use PhpHtml\Abstracts\PluginAbstract;

final class Row extends PluginAbstract
{
    /**
     * @var array
     */
    private $columns = [];

    /**
     * @param PluginAbstract $plugin
     * @return PluginAbstract
     */
    public function addCol(PluginAbstract $plugin)
    {
        return $this->columns[] = $plugin;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        $html = ''; // INICIANDO VARIAVEL HTML
        foreach ($this->columns as $col)
            $html .= $col->getHtml();

        return "<div class='row'>$html</div>";
    }
}