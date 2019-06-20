<?php

/**
 * Esta classe deve ser extendida pelas classes de tela da aplicação.
 */

namespace LaraHtml\Grid;


use LaraHtml\Abstracts\General;
use LaraHtml\Traits\StoresRows;

abstract class Screen extends General
{

    use StoresRows;

    /**
     * Gera e retorna o HTML do plugin.
     *
     * @param array|null $data
     * @return string
     */
    public function getHtml(?array $data = null): string
    {
        $this->attrClass($this->config('grid-css.screen'));
        $data = [
            'extend_view' => config('larahtml.extend_view'),
            'elements' => $this->getHtmlElements($this->rows),
            'attributes' => $this->getAttributesTag(),
        ];

        return $this->getView('screen', $data);
    }

}
