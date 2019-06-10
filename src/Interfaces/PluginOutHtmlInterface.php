<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:38
 */

namespace LaraHtml\Interfaces;


interface PluginOutHtmlInterface
{
    /**
     * Gera e retorna o HTML do plugin.
     *
     * @return string
     */
    public function getHtml(): string;
}
