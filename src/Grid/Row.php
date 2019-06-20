<?php

/**
 * Linha
 */

namespace LaraHtml\Grid;


use LaraHtml\Abstracts\General;

/**
 * Class Row
 * @package LaraHtml\Grid
 */
final class Row extends General
{

    /**
     * @var null|array
     */
    private $cols = null;

    /**
     * Método para o dev criar nova coluna.
     *
     * @return Col
     */
    public function col()
    {
        $col = new Col($this);
        return $this->newCol($col);
    }

    /**
     * @param Col $col
     * @return Col
     */
    public function newCol(Col $col)
    {
        return $this->cols[] = $col;
    }

    /**
     * Retorna a quantidade de colunas armazenadas.
     *
     * @return int
     */
    public function countCols(): int
    {
        return count($this->cols ?: []);
    }

    /**
     * Gera e retorna o HTML do plugin.
     *
     * @param array|null $data
     * @return string
     */
    public function getHtml(?array $data = null): string
    {
        $this->attrClass($this->config('grid-css.row'));

        $data = [
            'elements' => $this->getHtmlElements($this->cols),
            'attributes' => $this->getAttributesTag(),
        ];

        return $this->getView('row', $data);
    }

}
