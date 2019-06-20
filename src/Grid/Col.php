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

    /**
     * Informa se a coluna está armazenando um plugin ao invés de linhas.
     *
     * @return bool
     */
    public function isStoredPlugin()
    {
        return $this->plugins !== null;
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
        $plugin->setRow($this->getRow());
        return $this->plugins[] = $plugin;
    }

    /**
     * Troca o plugin armazenado por linhas.
     */
    protected function replacePluginForRows()
    {
        $this->newRow(new Row); // NOVA LINHA
        $col = new Col($this->currentRow); // CRIANDO COLUNA
        $this->currentRow->newCol($col); // ADICIONANDO COLUNA NA LINHA ATUAL
        $col->newPlugin($this->plugins[0]); // ADICIONANDO PLUGIN ATUAL NA COLUNA
        $this->plugins = null; // EXCLUINDO PLUGIN ANTIGO DA COLUNA
    }

    /**
     * Gera e retorna o HTML do plugin.
     *
     * @param array|null $data
     * @return string
     */
    public function getHtml(?array $data = null): string
    {
        $countCols = $this->getRow()->countCols(); // TOTAL DE COLUNAS DA LINHA PAI
        $maxCols = $this->config('max_cols'); // MÁXIMO DE COLUNAS DO TEMPLATE EM USO
        $numCol = $maxCols / $countCols; // QUANTAS COLUNAS ESTA COLUNA OCUPARÁ
        if (!is_int($numCol)) // SE O RESULTADO NÃO FOR INTEIRO
            // CALCULE A QUANTIDADE DE COLUNAS DA ÚLTIMA COLUNA
            if ($data['total'] - 1 == ($data['idx'])) { // SE A COLUNA ATUAL FOR A ÚLTIMA ARMAZENADA NA LINHA PAI
                $numCol = (int)$numCol; // PARTE INTEIRA DA QUANTIDADE DE COLUNAS OCUPADAS PELA ATUAL
                $oldNumCol = $numCol; // ARMAZENA EM UMA VARIÁVEL AUXILIAR
                $numCol = $numCol * $countCols; // TOTAL GERAL DE COLUNAS OCUPADAS NA LINHA PAI
                $numCol = $maxCols - $numCol; // QUANTAS COLUNAS VAGAS EXISTEM
                $numCol = $oldNumCol + $numCol; // ADICIONE AS COLUNAS VAGAS A ÚLTIMA COLUNA
            }
        $numCol = (int)$numCol; // SE O RESULTADO NÃO FOR INTEIRO E NÃO FOR A ÚLTIMA COLUNA

        $this->attrClass($this->config('css.grid.col') . $numCol);
        $data = [
            'elements' => $this->getHtmlElements($this->plugins ?: $this->rows),
            'attributes' => $this->getAttributesTag(),
        ];

        return $this->getView('col', $data);
    }

}
