<?php

/**
 * Plugin que armazena linhas.
 */

namespace LaraHtml\Grid;

use LaraHtml\Abstracts\General;
use LaraHtml\Traits\StoresRows;
use LaraHtml\Exceptions\LaraHtmlPluginNotFoundException;

/**
 * Class Plugin
 *
 * @package LaraHtml\Grid\Plugin
 */
class Plugin extends General
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
     * Plugin constructor.
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

        if (!$configPlugin)
            throw new LaraHtmlPluginNotFoundException("Plugin '{$this->pluginName}' not found in config file 
            'config/larahtml/{$this->getTemplate()}.php'");

//        PERCORRER OS VETORES DE CONFIGURAÇÃO DO PLUGIN E ARGUMENTOS, SOMENTE MANIPULANDO OS PONTEIROS INTERNOS DO ARRAY

        foreach ($configPlugin as $configPluginIndex => $configPluginValue) {
            /*
             * $configPluginIndex:
             * - Pode ser um "inteiro" (índice), quando apenas o nome da configuração é declarada, e não possui valor
             *   pré-definido
             * - Pode ser uma "cadeia de caracteres", quando o nome da configuração é declarada com um valor pré-definido
             *   - Possui cadeia de caracteres "eval..": A cadeia de caracteres após deve ser interpretada como um comando
             *     PHP através da função "eval()", gera exceção.
             *   - Não possui cadeia de caracteres "eval..": O valor deve ser interpretado como caracteres estáticos.
             *----------------------------------------------------------------------------------------------------------
             * $configPluginValue: Sempre será uma "cadeia de caracteres".
             * - $configPluginIndex é "inteiro": $configPluginValue será o nome da configuração.
             * - $configPluginIndex é uma "cadeia de caracteres": $configPluginValue será o valor pré-definido da
             *   configuração.
             *
             */
//            echo "<pre>";
//            print_r([$configPluginIndex, $configPluginValue, gettype($configPluginIndex)]);
//            print_r([$configPluginIndex, $configPluginValue, gettype($configPluginValue)]);
//            print_r([$configPluginIndex]);
//            print_r([$configPluginValue]);
//            print_r([$configPlugin, $configPluginIndex, $configPluginValue]);
//            print_r([$configPluginIndex, $configPluginValue]);
//            echo "</pre>---";
        }

        $countConfigPlugin = 0;
        foreach ($configPlugin as $configPluginIndex => $configPluginValue) {
            /*if ($countConfigPlugin == 2)*/
//                dd($configPlugin, $configPluginIndex, $configPluginValue, $arguments[$countConfigPlugin], $arguments);

//            if (isset($configPlugin[$arguments[$countConfigPlugin]])) { // SE O VALOR DA CONFIGURAÇÃO DO PLUGIN FOI INFORMADO COMO ARGUMENTO
//            if (isset($configPlugin[$arguments[$countConfigPlugin]]) && isset($arguments[$countConfigPlugin])) { // SE O VALOR DA CONFIGURAÇÃO DO PLUGIN FOI INFORMADO COMO ARGUMENTO
            if (isset($arguments[$countConfigPlugin])) { // SE O VALOR DA CONFIGURAÇÃO DO PLUGIN FOI INFORMADO COMO ARGUMENTO
                if ($countConfigPlugin == 1)
                    dd($configPlugin, $configPluginIndex, $configPluginValue, $arguments[$countConfigPlugin], $arguments, $countConfigPlugin, $configPlugin[$countConfigPlugin]);

                if (isset($configPlugin[$arguments[$countConfigPlugin]])) {
                    if (mb_strtolower(explode('.', $configPlugin[$arguments[$countConfigPlugin]])[0]) != 'meta') // SE NÃO FOR UM META DADO, ADICIONE UM ATRIBUTO
                        $this->{"attr{$configPlugin[$countConfigPlugin]}"}($arguments[$countConfigPlugin]);
                    else { // SENÃO, ADICIONE UM META DADO

                        // META DADOS
                        $metaName = explode('.', $configPlugin[$arguments[$countConfigPlugin]]);
                        if (count($metaName) == 2) {
                            $valueHelp = '';

                            try {
                                eval('$valueHelp = ' . pos($arguments) . ';');
                            } catch (\Throwable $exception) {
                                $valueHelp = pos($arguments);
                            } finally {
                                $this->addMeta($metaName[1], $valueHelp);
                            }
                        }
                    }
                }

                next($arguments);
            } else { // SE O VALOR DA CONFIGURAÇÃO DO PLUGIN "NÃO" FOI INFORMADO COMO ARGUMENTO
                if (mb_strtolower(explode('.', $configPluginIndex)[0]) != 'meta') { // SE NÃO FOR UM META DADO, ADICIONE UM ATRIBUTO
                    $valueHelp = '';

                    try {
                        eval('$valueHelp = ' . $configPluginValue . ';');
                    } catch (\Throwable $exception) {
                        $valueHelp = $configPluginValue;
                    } finally {
                        $this->{"attr{$configPluginIndex}"}($valueHelp);
//                        $this->addMeta($metaName[1], $valueHelp);
                    }
                } else { // SENÃO, ADICIONE UM META DADO

                    // META DADOS
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
            $countConfigPlugin++;

        }
        reset($arguments);


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
