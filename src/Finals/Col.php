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
        require_once __DIR__."/../Template/bootstrap4/config.php";
        $htmlPlugins = $this->getHtmlPlugins();
        return "<div class=\"{$config['css']['col']}\">$htmlPlugins</div>";
    }
}
