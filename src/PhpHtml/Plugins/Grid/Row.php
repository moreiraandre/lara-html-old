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
     * @var Col|null
     */
    private $col = null;

    /**
     * @var GetItems|null
     */
    private $accessCols = null;

    /**
     * Row constructor.
     */
    public function __construct()
    {
        $this->accessCols = new GetItems($this->columns);
    }

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
     * @return GetItems|null
     */
    public function cols()
    {
        return $this->accessCols;
    }

    /**
     * @param Col $col
     */
    public function setCol(Col $col)
    {
        $this->col = $col;
    }

    /**
     * @return Col|null
     */
    public function getCol()
    {
        return $this->col;
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