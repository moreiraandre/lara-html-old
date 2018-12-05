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
    protected $attributes = [];

    /**
     * @param $name
     * @param $arguments
     * @return $this
     * @throws \Throwable
     */
    public function __call($name, $arguments)
    {
        throw_if(
            !substr($name, 0, 3) == 'set',
            \Exception::class,
            "Method $name don't exists!"
        );

        $this->attributes[mb_strtolower(substr($name, 3))] = $arguments[0];
        return $this;
    }

    /**
     * @return string
     */
    public function getAttributesTag()
    {
        $html = '';
        foreach ($this->attributes as $attr => $value)
            $html .= "$attr=\"$value\"";

        return $html;
    }
}