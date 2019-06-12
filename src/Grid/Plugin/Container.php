<?php

/**
 * Plugin que armazena linhas
 */

namespace LaraHtml\Grid\Plugin;


use LaraHtml\Grid\Row;
use LaraHtml\Traits\StoresRows;

/**
 * Class Container
 * @package LaraHtml\Grid\Plugin
 */
abstract class Container extends General
{

    use StoresRows;

    public function __construct()
    {
        parent::__construct();

        $this->row();
    }

}
