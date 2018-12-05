<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:41
 */

namespace PhpHtml\Plugins;


use PhpHtml\Abstracts\PluginAbstract;

/**
 * Class Text
 * @package PhpHtml\Plugins
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
        return
            "<div class='form-group col-sm'>
                <label>$this->label</label>
                <input class='form-control form-control-sm' name='$this->name' " . $this->getAttributesTag() . ">
            </div>";
    }
}