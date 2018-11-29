<?php
/**
 * Prove acesso as classes gestoras de plugins.
 *
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
    private $columns = [];

    /**
     * @return Row
     */
    public function row()
    {
        return new Row();
    }

    /**
     * @return Col
     */
    public function col()
    {
        return new Col();
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

        return $this->columns[] = new Col($obj);
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        $html = '';
        $countCol = 0;
        $row = $this->row();
        // PERCORRE TODOS OS GESTOES DE PLUGINS
        foreach ($this->columns as $col)
            $row->addCol($col);

        return "<form>{$row->getHtml()}</form>";
    }

}