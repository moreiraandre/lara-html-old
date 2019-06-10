<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:41
 */

namespace LaraHtml\Plugins;


use LaraHtml\Abstracts\PluginAbstract;

/**
 * Class Text
 * @package LaraHtml\Plugins
 */
class Text extends PluginAbstract
{
    private
        /**
         * @var string
         */
        $name,
        /**
         * @var string
         */
        $label;

    /**
     * Text constructor.
     * @param string $name
     * @param string|null $label
     */
    public function __construct(string $name, string $label = null)
    {
        parent::__construct();

        // Caso $label não seja informado ele recebe o valor de $name com a primeira letra maiúscula.
        $label = $label ?: ucfirst($name);

        $this->name = $name;
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        $data = [
            'label' => $this->label,
            'name' => $this->name,
            'attributes' => $this->getAttributesTag(),
        ];

        return $this->getView('text', $data);
    }
}
