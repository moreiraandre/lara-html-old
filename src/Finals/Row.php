<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:43
 */

namespace PhpHtml\Finals;

use PhpHtml\Abstracts\PluginContainerAbstract;

final class Row extends PluginContainerAbstract
{
    /**
     * Retorna o HTML dos plugins filhos
     *
     * @return string
     */
    public function getHtml(): string
    {
        $htmlPlugins = '';
        foreach ($this->getPlugins() as $plugin)
            $htmlPlugins .= $plugin->getHtml();

        return "<div class=\"row\">$htmlPlugins</div>";
    }
}
