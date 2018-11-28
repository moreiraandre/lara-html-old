<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:41
 */

namespace PhpHtml\Plugins\Form;


use PhpHtml\Interfaces\PluginInterface;

class Text implements PluginInterface
{
    private
        $name,
        $label;

    public function __construct(string $name, string $label = null)
    {
        // Caso $label não seja informado ele recebe o valor de $name com a primeira letra maiúscula.
        $label = $label ?: ucfirst($name);

        $this->name = $name;
        $this->label = $label;
    }

    public function getHtml(): string
    {
        return
            "<div class='form-group'>
                <label>$this->label</label>
                <input class='form-control form-control-sm' name='$this->name'>
            </div>";
    }
}