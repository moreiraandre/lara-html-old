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
     * @throws \LaraHtml\Exceptions\LaraHtmlConfigNotFoundException|\Exception
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

        $configIndex = 0; // ÍNDICE DA CONFIGURAÇÃO ATUAL
        /*
         * NA ATRIBUIÇÃO DE CONFIGURAÇÃO PELO CONSTRUTOR DA CLASSE, NÃO HAVERÁ CONCATENAÇÃO DE VALOR DE CONFIGURAÇÃO,
         * APENAS SUBSTITUIÇÃO SE O VALOR FOR INFORMADO NO CONSTRUTOR OU UTILIZAÇÃO DO VALOR PRÉ-DEFINIDO NA CONFIGURAÇÃO
         * SE O VALOR NÃO FOR PASSADO NO CONSTRUTOR.
         */
        foreach ($configPlugin as $configPluginIndex => $configPluginValue) {
            $configName = // NOME DA CONFIGURAÇÃO (ATRIBUTO OU META-DADO)
            $configValue = null; // VALOR DA CONFIGURAÇÃO (ESTÁTICO OU INTERPRETADO PELA FUNÇÃO eval())
            /*
             * 1. $configPluginIndex:
             *    1.1. Pode ser um "inteiro" (índice), quando apenas o nome da configuração é declarada, e não possui
             *         valor pré-definido.
             *         $configName = $configPluginValue;
             *         $configValue = $arguments[$configIndex];
             *         1.1.1. Se "meta." estiver contido em $configPluginValue
             *                1.1.1.1. Se $arguments[$configIndex] existir: UM META-DADO SERÁ CRIADO!
             *                1.1.1.2. Se $arguments[$configIndex] NÃO existir: Nenhuma configuração será definida!
             *         1.1.2. Se "meta." NÃO estiver contido em $configPluginValue
             *                1.1.2.1. Se $arguments[$configIndex] existir: UM ATRIBUTO SERÁ CRIADO!
             *                1.1.2.2. Se $arguments[$configIndex] NÃO existir: Nenhuma configuração será definida!
             *    1.2. Pode ser uma "cadeia de caracteres", quando o nome da configuração é declarada com um valor
             *         pré-definido.
             *         $configName = $configPluginIndex;
             *         1.2.1. Se "meta." estiver contido em $configPluginIndex
             *                1.2.1.1. Se $arguments[$configIndex] existir:
             *                         $configValue = $arguments[$configIndex];
             *                         UM META-DADO SERÁ CRIADO!
             *                1.2.1.2. Se $arguments[$configIndex] NÃO existir:
             *                         1.2.1.2.1. Se "eval.." estiver contido em $configPluginValue: A sequência de
             *                                    caracteres posterior deve ser interpretada com a função "eval()".
             *                                    UM META-DADO SERÁ CRIADO!
             *                                    OU UMA EXCEÇÃO SERÁ GERADA!
             *                         1.2.1.2.2. Se "eval.." NÃO estiver contido em $configPluginValue:
             *                                    $configValue = $configPluginValue;
             *                                    UM META-DADO SERÁ CRIADO!
             *         1.2.2. Se "meta." NÃO estiver contido em $configPluginIndex
             *                1.2.2.1. Se "eval.." estiver contido em $configPluginValue: A sequência de caracteres
             *                           posterior deve ser interpretada com a função "eval()".
             *                           UM ATRIBUTO SERÁ CRIADO!
             *                           OU UMA EXCEÇÃO SERÁ GERADA!
             *                1.2.2.2. Se "eval.." NÃO estiver contido em $configPluginValue:
             *                           $configValue = $configPluginValue;
             *                           UM ATRIBUTO SERÁ CRIADO!
             *----------------------------------------------------------------------------------------------------------
             * 2. $configPluginValue: Sempre será uma "cadeia de caracteres".
             *    2.1. $configPluginIndex é "inteiro": $configPluginValue será o nome da configuração.
             *    2.2. $configPluginIndex é uma "cadeia de caracteres": $configPluginValue será o valor pré-definido da
             *         configuração (pode ser texto estático ou interpretado pela função "eval()").
             *----------------------------------------------------------------------------------------------------------
             * 3. $arguments: Vetor dos valores que serão atribuidos as configurações
             *    3.1 Se $arguments[$configIndex] existir, o valor será da configuração atual.
             *
             */
            // DEBUG
            /*echo "<pre>";
            print_r([$configPluginIndex, $configPluginValue, gettype($configPluginIndex), gettype($configPluginValue)]);
            echo "</pre>---";*/

            if (is_int($configPluginIndex)) { // 1.1
                $configName = $configPluginValue;
                if (strpos($configName,'meta.') !== false) { // 1.1.1
                    if (isset($arguments[$configIndex])) { // 1.1.1.1
                        $configName = explode('.', $configName)[1];
                        $this->addMeta($configName, $arguments[$configIndex]);
                    }
                } else { // 1.1.2
                    if (isset($arguments[$configIndex])) { // 1.1.2.1
                        $this->{"attr{$configName}"}($arguments[$configIndex]);
                    }
                }

            } elseif (is_string($configPluginIndex)) { // 1.2
                $configName = $configPluginIndex;
                if (strpos($configName, 'meta.') !== false) { // 1.2.1
                    $configName = explode('.', $configName)[1];
                    if (isset($arguments[$configIndex])) { // 1.2.1.1
                        $this->addMeta($configName, $arguments[$configIndex]);
                    } else {
                        if (strpos($configPluginValue,'eval..') !== false) { // 1.2.2.1
                            $configValue = str_replace('eval..', '', $configPluginValue);
                            eval("\$configValue = $configValue;"); // INTERPRETANDO VALOR COMO COMANDO PHP
                            $this->addMeta($configName, $configValue);
                        } else { // 1.2.2.2
                            $this->addMeta($configName, $configPluginValue);
                        }
                    }
                } else { // 1.1.2
                    if (isset($arguments[$configIndex])) { // 1.1.2.1
                        $this->{"attr{$configName}"}($arguments[$configIndex]);
                    } else { // 1.1.2.2
                        if (strpos($configPluginValue, 'eval..') !== false) { // 1.2.2.1
                            $configValue = str_replace('eval..', '', $configPluginValue);
                            eval("\$configValue = $configValue;"); // INTERPRETANDO VALOR COMO COMANDO PHP
                            $this->{"attr{$configName}"}($configValue);
                        } else { // 1.2.2.2
                            $this->{"attr{$configName}"}($configPluginValue);
                        }
                    }
                }
            } else {
                throw new \Exception('$configPluginIndex é de um tipo não reconhecido! ('
                    . gettype($configPluginIndex) . ')');
            }
            $configIndex++;
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
