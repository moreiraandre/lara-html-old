<?php
/**
 * Created by: André Moreira
 * Date: 21/11/18
 * Time: 02:06
 */

namespace LaraHtml\Finals;

use LaraHtml\Abstracts\PluginContainerAbstract;

/**
 * Class Col
 * @package LaraHtml\Finals
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
        require __DIR__."/../Template/bootstrap4/config.php";
        $htmlPlugins = $this->getHtmlPlugins();
        return "<div class=\"{$config['css']['col']}\">$htmlPlugins</div>";
    }
}
