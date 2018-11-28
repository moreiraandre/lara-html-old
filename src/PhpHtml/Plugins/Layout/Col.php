<?php
/**
 * Created by: André Moreira
 * Date: 21/11/18
 * Time: 02:06
 */

namespace PhpHtml\Plugins\Layout;


use PhpHtml\Interfaces\PluginInterface;

class Col implements PluginInterface
{

    private $plugins = [];

    public function __construct(PluginInterface $plugin = null)
    {
        if ($plugin)
            $this->addPlugin($plugin);
    }

    public function addPlugin(PluginInterface $plugin)
    {
        $this->plugins[] = $plugin;
    }

    public function getHtml(): string
    {
        $html = '';

        foreach ($this->plugins as $plugin)
            $html .= "<div class='col-sm'>{$plugin->getHtml()}</div>";

        return $html;
    }

}
