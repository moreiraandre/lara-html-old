<?php

namespace LaraHtml;

use LaraHtml\Grid\Col;
use LaraHtml\Grid\Row;

interface PluginInterface
{
    public function setRow(?Row $row): self;

    public function getRow(): ?Row;

    public function setCol(?Col $row): self;

    public function getCol(): ?Col;

    public function setTemplate(string $template): self;

    public function getTemplate(): string;

    public function setBlade(string $blade): self;

    public function getBlade(): string;

    public function setRowContainer(): self;

    public function setPluginContainer(): self;

    public function isRowContainer(): bool;

    public function attr(array $attr): self;

    public function rmAttr(string $key): array;

    public function meta(array $meta): self;

    public function rmMeta(string $key): array;

    public function setData(?array $data = []): self;

    public function getData(): array;

    public function setDataAttrFind(string $key): self;

    public function setDataAttrValue(string $key): self;

    public function getDataAttrFind(): string;

    public function getDataAttrValue(): string;

    public function getHtml(): string;

    public function getHtmlPlugins(array $auxData): string;
}
