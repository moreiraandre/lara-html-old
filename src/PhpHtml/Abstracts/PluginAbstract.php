<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:40
 */

namespace PhpHtml\Abstracts;

use PhpHtml\Errors\PluginNonexistentError;
use PhpHtml\Interfaces\PluginInterface;
use PhpHtml\Plugins\Col;
use PhpHtml\Plugins\Row;

abstract class PluginAbstract implements PluginInterface
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * Referência da linha pai
     *
     * @var \PhpHtml\Plugins\Row
     */
    private $row;

    /**
     * Referência da coluna pai
     *
     * @var \PhpHtml\Plugins\Col
     */
    private $col;

    private $items = [];

    /**
     * @return Row
     */
    public function getRow(): Row
    {
        return $this->row;
    }

    /**
     * @param Row $row
     */
    public function setRow(Row $row): void
    {
        $this->row = $row;
    }

    /**
     * @return Col
     */
    public function getCol(): Col
    {
        return $this->col;
    }

    /**
     * @param Col $col
     */
    public function setCol(Col $col): void
    {
        $this->col = $col;
    }

    /**
     * Define atributos de tag ou cria plugins dentro do atual
     *
     * @param $name
     * @param $arguments
     * @return $this
     * @throws \Throwable
     */
    public function __call($name, $arguments)
    {
        $prefix = substr($name, 0, 3);
        $suffix = substr($name, 3);

        throw_if(
            !in_array($prefix, ['set', 'add']),
            \Exception::class,
            "Method $name don't exists!"
        );

        if ($prefix == 'set') { // DEFINE ATRIBUTOS DE TAG
            $this->attributes[mb_strtolower(substr($name, 3))] = $arguments[0];
            return $this;
        } elseif ($prefix == 'add') { // CRIA PLUGINS DENTRO DO ATUAL
            $class = "PhpHtml\Plugins\\$suffix";

            // LANÇA UM ERRO PERSONALIZADO SE O PLUGIN NÃO EXISTIR
            try {
                $obj = new $class(...$arguments);
            } catch (\Error $e) {
                throw new PluginNonexistentError("Plugin $class does not exist!");
            }

            return $this->items[] = $obj;
        }
    }

    /**
     * Retorna o vetor de plugins recebidos
     *
     * @return array
     */
    protected function getItems()
    {
        return $this->items;
    }

    /**
     * @return string
     */
    public function getAttributesTag()
    {
        $html = '';
        foreach ($this->attributes as $attr => $value)
            $html .= "$attr=\"$value\"";

        return $html;
    }
}