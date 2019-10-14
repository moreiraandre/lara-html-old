<?php

namespace LaraHtml\Traits;

trait AttrMeta
{
    private $attr = [];
    private $metaData = [];

    public function attr(array $attr): self
    {
        $this->attr[] = $attr;
        return $this;
    }

    public function rmAttr(string $key): array
    {
        $return = [$key => $this->attr[$key]];
        unset($this->attr[$key]);
        return $return;
    }

    public function meta(array $meta): self
    {
        $this->metaData[] = $meta;
        return $this;
    }

    public function rmMeta(string $key): array
    {
        $return = [$key => $this->metaData[$key]];
        unset($this->metaData[$key]);
        return $return;
    }
}
