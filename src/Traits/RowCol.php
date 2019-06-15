<?php

/**
 * Referência da linha e coluna do elemento.
 */

namespace LaraHtml\Traits;


use LaraHtml\Grid\Col;
use LaraHtml\Grid\Row;

/**
 * Trait RowCol
 * @package LaraHtml\Traits
 */
trait RowCol
{

    /**
     * @var null|Row
     */
    private $row = null;

    /**
     * @var null|Col
     */
    private $col = null;

    /**
     * @return Row|null
     */
    public function getRow(): ?Row
    {
        return $this->row;
    }

    /**
     * @param Row|null $row
     */
    public function setRow(?Row $row): void
    {
        $this->row = $row;
    }

    /**
     * @return Col|null
     */
    public function getCol(): ?Col
    {
        return $this->col;
    }

    /**
     * @param Col|null $col
     */
    public function setCol(?Col $col): void
    {
        $this->col = $col;
    }

}
