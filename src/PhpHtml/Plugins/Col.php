<?php
/**
 * Created by: André Moreira
 * Date: 21/11/18
 * Time: 02:06
 */

namespace PhpHtml\Plugins;


use PhpHtml\Abstracts\PluginAbstract;

class Col extends PluginAbstract
{

    /**
     * @var array
     */
    private $plugins = [];

    /**
     * Col constructor.
     * @param PluginAbstract|null $plugin
     */
    public function __construct(PluginAbstract $plugin = null)
    {
        if ($plugin)
            $this->addPlugin($plugin);
    }

    /**
     * @param PluginAbstract $plugin
     */
    public function addPlugin(PluginAbstract $plugin)
    {
        $this->plugins[] = $plugin;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        $html = '';

        foreach ($this->plugins as $plugin)
            $html .= "<div class='col-sm'>{$plugin->getHtml()}</div>";

        return $html;
    }

}
