<?php

/**
 * Plugin que armazena linhas.
 */

namespace LaraHtml\Grid\Plugin;

use LaraHtml\Traits\StoresRows;
use LaraHtml\Exceptions\LaraHtmlPluginNotFoundException;

/**
 * Class Container
 *
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

    /**
     * Container constructor.
     *
     * @param string $pluginName
     * @param array $arguments
     * @param string|null $template
     * @throws LaraHtmlPluginNotFoundException
     * @throws \LaraHtml\Exceptions\LaraHtmlConfigNotFoundException
     */
    public function __construct(string $pluginName, array $arguments = [], string $template = null)
    {
        parent::__construct($template);

        $this->pluginName = $pluginName;

        $configPlugin = $this->config("plugins.{$this->pluginName}");

        $auxCfg = [];
        foreach ($configPlugin as $idx => $item) {
            if (is_int($idx))
                $auxCfg[] = $item;
            else
                $auxCfg[] = [$idx => $item];
        }

        if (!$configPlugin)
            throw new LaraHtmlPluginNotFoundException("Plugin '{$this->pluginName}' not found in config file 
            'config/larahtml/{$this->getTemplate()}.php'");

        // DEFININDO CONFIGURAÇÃO DO CONSTRUTOR
        if (count($arguments) > 0) {
            foreach ($arguments as $argumentIndex => $argumentValue) {

                echo "<pre>";
                print_r([$arguments, $argumentIndex, $argumentValue]);
//                    print_r($this->getAttr());
                echo "</pre>";

                if (isset($configPlugin[$argumentIndex])) {

                    $this->{"attr{$configPlugin[$argumentIndex]}"}($argumentValue);
//                    $this->addMeta($configPlugin[$argumentIndex], $argumentValue);


                }


            }
        }

        // DEFININDO META ATRIBUTOS
        foreach ($configPlugin as $configPluginIndex => $configPluginValue) {
            if (is_int($configPluginIndex)) {
                $metaName = explode('.', $configPluginValue);
                if (count($metaName) == 2)
                    $this->addMeta($metaName[1], '');
            } else {
                $metaName = explode('.', $configPluginIndex);
                if (count($metaName) == 2) {
                    $valueHelp = '';

                    try {
                        eval('$valueHelp = ' . $configPluginValue . ';');
                    } catch (\Throwable $exception) {
                        $valueHelp = $configPluginValue;
                    } finally {
                        $this->addMeta($metaName[1], $valueHelp);
                    }
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
            'attr' => $this->getAttr(),
            'meta' => $this->getMeta(),
        ];

        return $this->getView($this->getPluginName(), $data);
    }

}
