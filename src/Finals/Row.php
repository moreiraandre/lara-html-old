<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:43
 */

namespace LaraHtml\Finals;

use LaraHtml\Abstracts\PluginContainerAbstract;

/**
 * Class Row
 * @package LaraHtml\Finals
 */
final class Row extends PluginContainerAbstract
{
    /**
     * Retorna o HTML dos plugins filhos
     *
     * @return string
     */
    public function getHtml(): string
    {
        $htmlPlugins = $this->getHtmlPlugins();
        return "<div class=\"".config('larahtml.templates.'.$this->getTemplate().'.row')."\">$htmlPlugins</div>";
    }
}
