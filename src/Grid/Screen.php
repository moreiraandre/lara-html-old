<?php

/**
 * Esta classe deve ser extendida pelas classes de tela da aplicação.
 */

namespace LaraHtml\Grid;

use LaraHtml\Abstracts\General;
use LaraHtml\Traits\StoresRows;

class Screen extends General
{

    use StoresRows;

    /**
     * @var string|null Define a view blade que será estendida pela view da Screen.
     */
    private $extendView = null;

    /**
     * Screen constructor.
     *
     * @param string|null $template
     * @param string|null $extendView
     * @throws \LaraHtml\Exceptions\LaraHtmlConfigNotFoundException
     */
    public function __construct(string $template = null, string $extendView = null)
    {
        parent::__construct($template);
        $this->extendView = $extendView ?: config('larahtml.config.extend_view');
    }

    /**
     * @return string|null
     */
    public function getExtendView(): ?string
    {
        return $this->extendView;
    }

    /**
     * @param string|null $extendView
     */
    public function setExtendView(?string $extendView): void
    {
        $this->extendView = $extendView;
    }

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
            'extendView' => $this->getExtendView(),
        ];

        return $this->getView('screen', $data);
    }

}
