<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:52
 */

namespace PhpHtml;

use PhpHtml\Interfaces\PluginInterface;
use PhpHtml\Plugins\Col;
use PhpHtml\Plugins\Row;

/**
 * Class PhpHtml
 * @package PhpHtml
 */
class PhpHtml
{
    /**
     * @var array
     */
    private $plugins = [];

    /**
     * Inicia nova linha
     */
    public function row()
    {
        $this->plugins[] = 'row';
    }

    /**
     * Inicia nova coluna
     */
    public function col()
    {
        $this->plugins[] = 'col';
    }

    /**
     * Cria plugins dinamicamente pelo nome da classe invocada.
     *
     * @param $name
     * @param $arguments
     * @return Col
     * @throws \Throwable
     */
    public function __call($name, $arguments)
    {
        $name = ucfirst($name);
        $class = "PhpHtml\Plugins\\$name";
        $obj =  new $class(...$arguments);
        throw_if(
            ! $obj instanceof PluginInterface,
            \Exception::class,
            "Object don't is a PluginInterface instance!"
        );

        return $this->plugins[] = $obj;
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        $html = '';
        // PERCORRE TODOS OS GESTOES DE PLUGINS
        foreach ($this->plugins as $p)
            $html .= $p->getHtml();

        return $html;

        /*$html = '';
        $countCol = 0;
        $row = new Row();
        // PERCORRE TODOS OS GESTOES DE PLUGINS
        foreach ($this->plugins as $col)
            $row->addCol($col);

        return "<form>{$row->getHtml()}</form>";*/
    }

}