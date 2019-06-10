<?php

/**
 * Ponto de partida para criação de telas
 */

namespace LaraHtml;

use LaraHtml\Abstracts\PluginContainerAbstract;

/**
 * Class LaraHtmlScreen
 * @package LaraHtml
 */
final class LaraHtmlScreen extends PluginContainerAbstract
{
    /**
     * @return string
     */
    public function getHtml(): string
    {
        return "<div class='php-html-screen'>{$this->getHtmlPlugins()}</div>";
    }
}
