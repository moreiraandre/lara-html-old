<?php
/**
 * Created by: André Moreira
 * Date: 21/11/18
 * Time: 02:06
 */

namespace PhpHtml\Plugins;


use PhpHtml\Abstracts\PluginAbstract;
use PhpHtml\Errors\PluginNonexistentError;

final class Col extends PluginAbstract
{

    /**
     * @var array
     */
    private $plugins = [];

    /**
     * @var array
     */
    private $rows = [];

    /**
     * @var Row Linha atual
     */
    private $rowCurrent = null;

    /**
     * Col constructor.
     * @param PluginAbstract|null $plugin
     */
    public function __construct(PluginAbstract $plugin = null)
    {
        /*if ($plugin)
            $this->addPlugin($plugin);*/
    }

    public function __call($name, $arguments)
    {
        $arguments = $arguments[0];

        $prefix = substr($name, 0, 3);
        $suffix = substr($name, 3);

        $class = "PhpHtml\Plugins\\$suffix";

        throw_if(
            !file_exists(__DIR__ . "/../Plugins/$suffix.php"),
            \Exception::class,
            "Method $name don't exists!"
        );

        // LANÇA UM ERRO PERSONALIZADO SE O PLUGIN NÃO EXISTIR
        try {
            $this->plugins[] = $obj = new $class(...$arguments);
            $obj->setCol($this);
        } catch (\Error $e) {
            throw new PluginNonexistentError("Plugin $class does not exist!");
        }

        return $obj;
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
