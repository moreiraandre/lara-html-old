<?php

/**
 * Ponto de partida para criação de telas
 */

namespace LaraHtml\Abstracts;

/**
 * Class LaraHtmlScreen
 * @package LaraHtml
 */
abstract class LaraHtmlScreen extends PluginContainerAbstract
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
