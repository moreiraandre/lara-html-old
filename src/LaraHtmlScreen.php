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
        $data = [
            'rows' => $this->getHtmlPlugins(),
        ];

        return $this->getView('screen', $data);
    }
}
