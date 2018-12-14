<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:43
 */

namespace PhpHtml\Plugins\Grid;


use PhpHtml\Abstracts\PluginAbstract;
use PhpHtml\Interfaces\PluginOutHtmlInterface;

final class Row implements PluginOutHtmlInterface
{
    /**
     * @var array
     */
    private $columns = [];

    /**
     * Adicionando colunas
     *
     * @param $pluginName
     * @param $arguments
     * @return PluginAbstract
     */
    public function addCol($pluginName, $arguments)
    {
        $this->columns[] = $col = new Col(); // CRIANDO COLUNA
        $col->setRow($this); // ADICIONANDO REFERÊNCIA DA LINHA AO OBJETO DA COLUNA
        $plugin = $col->{"add$pluginName"}($arguments); // CRIANDO PLUGIN

        return $plugin;
    }

    /**
     * Total de colunas
     *
     * @return int
     */
    public function totalColumns()
    {
        return count($this->columns);
    }

    /**
     * @return mixed|null
     */
    public function firstCol()
    {
        return count($this->columns) > 0 ? $this->columns[0] : null;
    }

    /**
     * @param int $index
     * @return mixed
     */
    public function getCol(int $index)
    {
        return $this->columns[$index];
    }

    /**
     * @return mixed|null
     */
    public function lastCol()
    {
        return count($this->columns) > 0 ? end($this->columns) : null;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        $html = ''; // INICIANDO VARIAVEL HTML
        foreach ($this->columns as $col)
            $html .= $col->getHtml();

        return "<div class='form-row'>$html</div>";
    }
}