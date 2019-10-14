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
     * @return $this
     */
    public function setRow(?Row $row): self
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
     * @return $this
     */
    public function setCol(?Col $col): self
    {
        $this->col = $col;
    }

}
