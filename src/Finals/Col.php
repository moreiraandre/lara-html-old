<?php
/**
 * Created by: André Moreira
 * Date: 21/11/18
 * Time: 02:06
 */

namespace PhpHtml\Finals;

use PhpHtml\Abstracts\ContainerRowsAbstract;
use PhpHtml\Abstracts\PluginAbstract;

/**
 * Class Col
 * @package PhpHtml\Plugins
 */
final class Col extends ContainerRowsAbstract
{
    /**
     * @var null|PluginAbstract Plugin armazenado nesta coluna
     */
    private $plugin = null;

    /**
     * @return PluginAbstract
     * @return null Quando a coluna está armazenando linhas
     */
    public function getPlugin(): PluginAbstract
    {
        return $this->plugin;
    }

    /**
     * @param PluginAbstract $plugin
     */
    public function setPlugin(PluginAbstract $plugin): void
    {
        $this->plugin = $plugin;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        $html = $this->getHtmlPlugins();

        return "<div class='col-sm'>$html</div>";
    }
}
