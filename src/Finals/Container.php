<?php

/**
 * Created by: André Moreira
 * Date: 06/06/19
 * Time: 23:56
 */

namespace PhpHtml\Finals;

use PhpHtml\Abstracts\PluginContainerAbstract;

/**
 * Class Container
 * @package PhpHtml\Finals
 */
final class Container extends PluginContainerAbstract
{
    /**
     * Retorna o HTML dos plugins filhos
     *
     * @return string
     */
    public function getHtml(): string
    {
//        require __DIR__."/../Template/bootstrap4/config.php";
        $htmlPlugins = $this->getHtmlPlugins();
//        return "<div class=\"{$config['css']['col']}\">$htmlPlugins</div>";
        return "<div class=\"container\">$htmlPlugins</div>";
    }
}
