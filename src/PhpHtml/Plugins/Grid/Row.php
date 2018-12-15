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
    private $cols = [];

    /**
     * @var Col|null
     */
    private $col = null;

    /**
     * Adicionando colunas
     *
     * @param $pluginName
     * @param $arguments
     * @return PluginAbstract
     */
    public function addCol($pluginName, $arguments)
    {
        $this->cols[] = $col = app(Col::class); // CRIANDO COLUNA
        $col->setRow($this); // ADICIONANDO REFERÊNCIA DA LINHA AO OBJETO DA COLUNA
        $plugin = $col->{"$pluginName"}($arguments); // CRIANDO PLUGIN

        return $plugin;
    }

    /**
     * Total de colunas
     *
     * @return int
     */
    public function totalCols()
    {
        return count($this->cols);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function cols()
    {
        return collect($this->cols);
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
        foreach ($this->cols as $col)
            $html .= $col->getHtml();

        return "<div class='form-row'>$html</div>";
    }
}