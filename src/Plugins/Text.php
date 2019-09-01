<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:41
 */

namespace LaraHtml\Plugins;


use LaraHtml\Grid\Plugin;

/**
 * Class Text
 * @package LaraHtml\Plugins
 */
class Text extends Plugin
{
    /**
     * @var string
     */
    private $label;

    /**
     * Text constructor.
     * @param string $name
     * @param string|null $label
     */
    public function __construct(string $name, string $label = null)
    {
        parent::__construct();

        // Caso $label não seja informado ele recebe o valor de $name com a primeira letra maiúscula.
        $this->label = $label ?: ucfirst($name);

        $this->attrClass($this->config('css.plugins.input'));
        $this->attrName($name);
    }

    /**
     * @param array|null $data
     * @return string
     */
    public function getHtml(?array $data = null): string
    {
        $data = [
            'label' => $this->label,
            'attributes' => $this->getAttributesTag(),
        ];

        return $this->getView('text', $data);
    }
}
