<?php
/**
 * Define o padrão de um plugin outros
 *
 * Created by: André Moreira
 * Date: 16/12/18
 * Time: 22:50
 */

namespace PhpHtml\Abstracts;

use PhpHtml\Abstracts\Plugins\PluginSingleAbstract;
use PhpHtml\Exceptions\PhpHtmlMethodNotFoundException;
use PhpHtml\Exceptions\PhpHtmlParametersException;
use PhpHtml\Exceptions\PhpHtmlPluginNotFoundException;
use PhpHtml\Finals\Col;
use PhpHtml\Finals\Row;

abstract class PluginContainerAbstract extends PluginAbstract
{

    /**
     * @var array Variável que armazena os plugins
     */
    private $plugins = [];

    /**
     * Adiciona um plugin
     *
     * @param PluginSingleAbstract $plugin
     * @return PluginSingleAbstract
     */
    public function addPlugin(PluginSingleAbstract $plugin): PluginSingleAbstract
    {
        return $this->plugins[] = $plugin;
    }

    /**
     * Retorna os plugins armazenados
     *
     * @return array|null
     */
    public function getPlugins(): ?array
    {
        return $this->plugins;
    }

    /**
     * Cria objetos de plugins
     *
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Throwable
     */
    public function __call($name, $arguments)
    {
        // GUARDANDO O PREFIXO DO MÉTODO PARA VERIFICAR SE REALMENTE É DESEJADO CRIAR UM NOVO PLUGIN
        $prefix = substr($name, 0, 3);

        // CRIANDO PLUGINS
        if ($prefix == 'add') { // NOVO PLUGIN
            // CASO O OBJETO SEJA UMA COLUNA E NÃO CONTENHA PLUGINS FILHOS SERÁ CRIADO UM PLUGIN


            $pluginClass = substr($name, 3); // IGNORANDO O PREFIXO add
            $class = "PhpHtml\Plugins\\$pluginClass"; // NOME DA CLASSE COM NAMESPACE PARA CRIAR O OBJETO

            // LANÇA UM ERRO CASO O ARQUIVO DA CLASSE NÃO EXISTA
            if (!file_exists(__DIR__ . "/../Plugins/$pluginClass.php"))
                throw new PhpHtmlPluginNotFoundException("Plugin $class does not exist!");

            // RESOLVENDO A HIERARQUIA DE PARÂMETROS EM MÉTODOS DINÂMICOS
            while (is_array($arguments[0]))
                $arguments = $arguments[0];

            // LANÇA ERRO PERSONALIZADO CASO OS ARGUMENTOS PARA CRIAR O PLUGIN ESTEJAM INVÁLIDOS
            try {
                $this->plugins[] = $obj = new $class(...$arguments); // CRIANDO OBJETO
            } catch (\TypeError $e) {
                throw new PhpHtmlParametersException($e->getMessage());
            }

            // CRIANDO COLUNA
            $col = new Col();

            if ($this->getRow())
                $col->setRow($this->getRow());
            else {
                $row = new Row();
                $col->setRow($row);
            }

            $obj->setCol($col); // GUARDANDO REFERÊNCIA DA COLUNA NO PLUGIN
            $obj->setRow($col->getRow()); // GUARDANDO REFERÊNCIA DA LINHA NO PLUGIN

            return $obj;


            if ($this instanceof Col) {
                $pluginClass = substr($name, 3); // IGNORANDO O PREFIXO add
                $class = "PhpHtml\Plugins\\$pluginClass"; // NOME DA CLASSE COM NAMESPACE PARA CRIAR O OBJETO

                // LANÇA UM ERRO CASO O ARQUIVO DA CLASSE NÃO EXISTA
                if (!file_exists(__DIR__ . "/../../Plugins/$pluginClass.php"))
                    throw new PhpHtmlPluginNotFoundException("Plugin $class does not exist!");

                // RESOLVENDO A HIERARQUIA DE PARÂMETROS EM MÉTODOS DINÂMICOS
                while (is_array($arguments[0]))
                    $arguments = $arguments[0];

                // LANÇA ERRO PERSONALIZADO CASO OS ARGUMENTOS PARA CRIAR O PLUGIN ESTEJAM INVÁLIDOS
                try {
                    $this->pluginOrRows = $obj = new $class(...$arguments); // CRIANDO OBJETO
                } catch (\TypeError $e) {
                    throw new PhpHtmlParametersException($e->getMessage());
                }

                $obj->setCol($this); // GUARDANDO REFERÊNCIA DA COLUNA NO PLUGIN
                $obj->setRow($this->getRow()); // GUARDANDO REFERÊNCIA DA LINHA NO PLUGIN

                return $obj;
            } else { // CASO A COLUNA NÃO ESTEJA VAZIA
                if ($this->pluginOrRows instanceof PluginAbstract) { // CASO UM PLUGIN ESTEJA ARMAZENADO DIRETAMENTE
                    /*======================================================================================================
                     *                           SUBSTITUINDO O PLUGIN ARMAZENADO POR LINHAS
                     *======================================================================================================
                     */
                    $currentPlugin = $this->pluginOrRows; // SALVANDO REFERÊNCIA DO PLUGIN ARMAZENADO ATUALMENTE NESTE COLUNA
                    $this->currentRow = new Row(); // CRIANDO UMA LINHA E DEFININDO COMO ATUAL
                    $auxCol = new Col($this->currentRow); // CRIANDO UMA COLUNA
                    $this->currentRow->addColObj($auxCol);
                    $auxCol->pluginObj($currentPlugin); // ADICIONANDO O OBJETO DO PLUGIN Á NOVA COLUNA
                    $currentPlugin->setRow($this->currentRow); // GUARDANDO REFERÊNCIA DA LINHA NO PLUGIN
                    $currentPlugin->setCol($auxCol); // GUARDANDO REFERÊNCIA DA COLUNA NO PLUGIN
                    $this->pluginOrRows = [$this->currentRow]; // SUBSTITUINDO O PLUGIN ATUAL PELA LINHA ATUAL
                    //                     *** FIM SUBSTITUINDO O PLUGIN ARMAZENADO POR LINHAS ***

                    // ADICIONANDO O NOVO PLUGIN
                    return $this->currentRow->addCol($name, $arguments);
                } else {
                    /* CASO A COLUNA JÁ ESTEJA ARMAZENANDO LINHAS UMA NOVA COLUNA SERÁ ADICIONADA A LINHA ATUAL COM A
                     * SOLICITAÇÃO DE CRIAÇÃO DO PLUGIN
                     */
                    // CASO O TOTAL DE COLUNAS DA LINHA SEJA 12 OU O DESENVOLVEDOR SOLICITE NOVA LINHA ENTÃO A NOVA LINHA SERÁ CRIADA
//                    dd($this, $this->getCurrentRow());
                    if ($this->currentRow->totalCols() == 12)
                        $this->pluginOrRows[] = $this->currentRow = new Row();

                    // CASO O DESENVOLVEDOR ESTEJA CRIANDO NOVO PLUGIN ELE SERÁ ADICIONADO A UMA COLUNA
                    return $this->currentRow->addCol($name, $arguments);
                }
            }
        } elseif ($prefix == 'row') { // ADICIONANDO NOVA LINHA SOLICITADA PELO DDESENVOLVEDOR
            if ($this->pluginOrRows instanceof PluginAbstract) {
                /*======================================================================================================
                 *                           SUBSTITUINDO O PLUGIN ARMAZENADO POR LINHAS
                 *======================================================================================================
                 */
                $currentPlugin = $this->pluginOrRows; // SALVANDO REFERÊNCIA DO PLUGIN ARMAZENADO ATUALMENTE NESTA COLUNA
                $this->currentRow = new Row(); // CRIANDO UMA LINHA E DEFININDO COMO ATUAL
                $auxCol = new Col($this->currentRow); // CRIANDO UMA COLUNA
                $this->currentRow->addColObj($auxCol);
                $auxCol->pluginObj($currentPlugin); // ADICIONANDO O OBJETO DO PLUGIN Á NOVA COLUNA
                $currentPlugin->setRow($this->currentRow); // GUARDANDO REFERÊNCIA DA LINHA NO PLUGIN
                $currentPlugin->setCol($auxCol); // GUARDANDO REFERÊNCIA DA COLUNA NO PLUGIN
                $this->pluginOrRows = [$this->currentRow]; // SUBSTITUINDO O PLUGIN ATUAL PELA LINHA ATUAL
                //                     *** FIM SUBSTITUINDO O PLUGIN ARMAZENADO POR LINHAS ***
            }

            return $this->pluginOrRows[] = $this->currentRow = new Row();
        } else
            // CASO O PREFIXO DO MÉTODO CHAMADO NÃO SEJA add UM ERRO DE MÉTODO INEXISTENTE É LANÇADO
            throw new PhpHtmlMethodNotFoundException("Method $name does not exist!");
    }

    /**
     * Retorna o HTML dos plugins filhos
     *
     * @return string
     */
    public function getHtml(): string
    {
        $htmlPlugins = '';
        foreach ($this->plugins as $plugin)
            $htmlPlugins .= $plugin->getHtml();

        return "<div>$htmlPlugins</div>";
    }

}
