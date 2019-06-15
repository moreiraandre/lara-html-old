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
     * @param array|null $data
     * @return string
     */
    public function getHtml(?array $data = null): string;
}
