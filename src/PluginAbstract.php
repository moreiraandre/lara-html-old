<?php

namespace LaraHtml;

use LaraHtml\Traits\AttrMeta;
use LaraHtml\Traits\Config;
use LaraHtml\Traits\RowCol;
use LaraHtml\Traits\StoreData;
use LaraHtml\Traits\StorePlugins;

abstract class PluginAbstract implements PluginInterface
{
    use AttrMeta, Config, RowCol, StoreData, StorePlugins;

    public function getHtml(): string
    {

    }

    public function getHtmlPlugins(array $auxData): string
    {

    }
}
