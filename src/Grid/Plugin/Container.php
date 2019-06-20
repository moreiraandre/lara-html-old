<?php

/**
 * Plugin que armazena linhas.
 */

namespace LaraHtml\Grid\Plugin;

use LaraHtml\Traits\StoresRows;
use League\Flysystem\Plugin\PluginNotFoundException;

/**
 * Class Container
 * @package LaraHtml\Grid\Plugin
 */
class Container extends General
{

    use StoresRows;

    /**
     * Nome do plugin para buscar as configurações no arquivo.
     *
     * @var string
     */
    private $pluginName = '';

    /**
     * @return string
     */
    public function getPluginName()
    {
        return $this->pluginName;
    }

    public function __construct(string $pluginName, array $arguments = [])
    {
        parent::__construct();

        $this->pluginName = $pluginName;

        $configPlugin = $this->config("plugins.{$this->pluginName}");

        if (!$configPlugin)
            throw new PluginNotFoundException("Plugin '{$this->pluginName}' not found in config file 
            'config/larahtml/{$this->getTemplate()}.php'");

        // DEFININDO ATRIBUTOS DO CONSTRUTOR
        if (count($arguments) > 0) {
            foreach ($arguments as $argumentIndex => $argumentValue) {
                if (isset($configPlugin[$argumentIndex])) {
                    $this->{"attr{$configPlugin[$argumentIndex]}"}($argumentValue);
                    $this->addMetaAttributes($configPlugin[$argumentIndex], $argumentValue);
                }
            }
        }

        // DEFININDO META ATRIBUTOS
        foreach ($configPlugin as $configPluginIndex => $configPluginValue) {
            if (is_int($configPluginIndex))
                $this->addMetaAttributes($configPluginValue, '');
            else {
                $valueHelp = '';

                try {
                    eval('$valueHelp = ' . $configPluginValue . ';');
                } catch (\Throwable $exception) {
                    $valueHelp = $configPluginValue;
                } finally {
                    $this->addMetaAttributes($configPluginIndex, $valueHelp);
                    $this->{"attr{$configPluginIndex}"}($valueHelp);
                }
            }
        }

        $this->row();
    }

    public function getHtml(?array $data = null): string
    {
        $data = [
            'elements' => $this->getHtmlElements($this->getRows()),
            'attributes' => $this->getAttributesTag(),
            'attr' => $this->getAttributes(),
            'meta' => $this->getMeta(),
        ];

        return $this->getView($this->getPluginName(), $data);
    }

}
