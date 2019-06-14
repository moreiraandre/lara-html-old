<?php


namespace LaraHtml\Grid;


use LaraHtml\Abstracts\General;
use LaraHtml\Traits\StoresRows;

abstract class Screen extends General
{

    use StoresRows;

    /**
     * Retorna o HTML da classe.
     *
     * @return string
     */
    public function getHtml(): string
    {
        $data = [
            'class' => $this->config('css.screen'),
            'extend_view' => config('larahtml.extend_view'),
            'elements' => $this->getHtmlElements($this->rows),
            'attributes' => $this->getAttributesTag(),
        ];

        return $this->getView('screen', $data);
    }

}
