<?php

namespace LaraHtml\Traits;

trait Config
{
    private $template = null;
    private $blade = null;
    private $containerType = 'Row';

    public function setTemplate(string $template): self
    {
        $this->template = $template;
        return $this;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function setBlade(string $blade): self
    {
        $this->blade = $blade;
        return $this;
    }

    public function getBlade(): string
    {
        return $this->blade;
    }

    public function setRowContainer(): self
    {
        $this->containerType = 'Row';
        return $this;
    }

    public function setPluginContainer(): self
    {
        $this->containerType = 'Plugin';
        return $this;
    }

    public function isRowContainer(): bool
    {
        return $this->containerType == 'Row';
    }
}
