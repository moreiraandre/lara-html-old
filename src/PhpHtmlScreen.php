<?php

/**
 * Ponto de partida para criação de telas
 */

namespace PhpHtml;

use PhpHtml\Abstracts\PluginContainerAbstract;

class PhpHtmlScreen extends PluginContainerAbstract
{
    /**
     * @return string
     */
    public function getHtml(): string
    {
        return "<div class='php-html-screen'>{$this->getHtmlPlugins()}</div>";
    }
}
