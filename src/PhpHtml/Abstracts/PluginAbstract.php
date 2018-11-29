<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:40
 */

namespace PhpHtml\Abstracts;


use PhpHtml\Interfaces\PluginInterface;

abstract class PluginAbstract implements PluginInterface
{
    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        if (substr($name, 0, 3) == 'set')
            $this->attributes[mb_strtolower(substr($name, 3))] = $arguments[0];

        var_dump($this->attributes);
    }

    /**
     * @return string
     */
    public function getAttributesTag()
    {
        var_dump($this->attributes);

        $html = '';
        foreach ($this->attributes as $attr => $value)
            $html .= "$attr=\"$value\"";

        return $html;
    }
}