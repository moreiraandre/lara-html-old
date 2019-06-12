<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:41
 */

namespace LaraHtml\Plugins;


use LaraHtml\Grid\Plugin\Simple;

/**
 * Class Text
 * @package LaraHtml\Plugins
 */
class Button extends Simple
{
    private
        /**
         * @var string
         */
        $label;

    /**
     * Text constructor.
     * @param string|null $label
     */
    public function __construct(string $label = null)
    {
        parent::__construct();

        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        $data = [
            'label' => $this->label,
            'attributes' => $this->getAttributesTag(),
        ];

        return $this->getView('button', $data);
    }
}
