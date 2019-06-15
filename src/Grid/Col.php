<?php

/**
 * Colunas
 */

namespace LaraHtml\Grid;


use LaraHtml\Abstracts\General;
use LaraHtml\Traits\StoresRows;
use LaraHtml\Grid\Plugin\General as Plugin;

/**
 * Class Col
 * @package LaraHtml\Grid
 */
final class Col extends General
{

    use StoresRows;

    /**
     * @var null|array
     */
    private $plugins = null;

    public function __construct(Row $row)
    {
        parent::__construct();

        $this->setRow($row);
    }

    public function countPlugins()
    {
        return count($this->plugins ?: []);
    }

    /**
     * Adiciona plugin a coluna.
     *
     * @param Plugin $plugin
     * @return Plugin
     */
    public function newPlugin(Plugin $plugin)
    {
        $plugin->setCol($this);
        return $this->plugins[] = $plugin;
    }

    protected function changePluginRows()
    {
        $this->newRow(new Row);
        $col = new Col($this->currentRow); // CRIANDO COLUNA
        $this->currentRow->newCol($col);
        $col->newPlugin($this->plugins[0]);
        $this->plugins = null;
    }

    /**
     * Gera e retorna o HTML do plugin.
     *
     * @param array|null $data
     * @return string
     */
    public function getHtml(?array $data = null): string
    {
        $countCols = $this->getRow()->countCols();
        $maxCols = $this->config('max_cols');
        $numCol = $maxCols / $countCols; // QTS COLUNAS ESTA COLUNA OCUPARÁ
        if (!is_int($numCol)) // SE O RESULTADO NÃO FOR INTEIRO
            // CALCULE A QUANTIDADE DE COLUNAS DA ÚLTIMA COLUNA
            if ($data['total'] - 1 == ($data['idx'])) {
                $numCol = (int)$numCol;
                $oldNumCol = $numCol;
                $numCol = $numCol * $countCols; // TOTAL DE COLUNAS OCUPADAS
                $numCol = $maxCols - $numCol; // QUANTAS COLUNAS VAGAS EXISTEM
                $numCol = $oldNumCol + $numCol; // ADICIONE AS COLUNAS VAGAS A ÚLTIMA COLUNA
            }
        $numCol = (int)$numCol; // SE O RESULTADO NÃO FOR INTEIRO E NÃO FOR A ÚLTIMA COLUNA
        $data = [
            'class' => $this->config('css.col.md') . '-' . $numCol,
            'elements' => $this->getHtmlElements($this->plugins ?: $this->rows),
            'attributes' => $this->getAttributesTag(),
        ];

        return $this->getView('col', $data);
    }

}
