<?php
/**
 * Created by: André Moreira
 * Date: 21/11/18
 * Time: 02:06
 */

namespace PhpHtml\Finals;

use PhpHtml\Abstracts\PluginContainerAbstract;

/**
 * Class Col
 * @package PhpHtml\Plugins
 */
final class Col extends PluginContainerAbstract
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

        return "<div class=\"col\">$htmlPlugins</div>";
    }
}
