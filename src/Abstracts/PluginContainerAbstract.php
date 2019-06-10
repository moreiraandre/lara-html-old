<?php
/**
 * Define o padrão de um plugin outros
 *
 * Created by: André Moreira
 * Date: 16/12/18
 * Time: 22:50
 */

namespace LaraHtml\Abstracts;

use phpDocumentor\Reflection\Types\This;
use LaraHtml\Abstracts\Plugins\PluginSingleAbstract;
use LaraHtml\Exceptions\LaraHtmlMethodNotFoundException;
use LaraHtml\Exceptions\LaraHtmlParametersException;
use LaraHtml\Exceptions\LaraHtmlPluginNotFoundException;
use LaraHtml\Finals\Col;
use LaraHtml\Finals\Row;
use Webmozart\Assert\Assert;

abstract class PluginContainerAbstract extends PluginAbstract
{
    /**
     * @var array Variável que armazena os plugins
     */
    private $plugins = [];

    /**
     * Adiciona um plugin
     *
     * @param PluginAbstract $obj
     * @return PluginAbstract
     */
    public function addPlugin(PluginAbstract $obj): PluginAbstract
    {
//        dd("addPlugin: " . get_class($obj) . ' - ' . get_class($this));
        if ($this instanceof Col) {
            $obj->setCol($this);
            if ($obj->getRow() instanceof Row)
                $obj->setRow($this->getRow());
        }
        if ($this instanceof Row)
            $obj->setRow($this);

        return $this->plugins[] = $obj;
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
     * Retorna o HTML de todos os plugins
     *
     * @return string
     */
    protected function getHtmlPlugins(): string
    {
        $html = '';
        foreach ($this->getPlugins() as $plugin) {
//            dd("getHtmlPlugins: " . get_class($this) . ' - ' . get_class($plugin));
            $html .= $plugin->getHtml();
        }
        return $html;
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
            $class = "LaraHtml\Plugins\\$pluginClass"; // NOME DA CLASSE COM NAMESPACE PARA CRIAR O OBJETO

            // LANÇA UM ERRO CASO O ARQUIVO DA CLASSE NÃO EXISTA
            if (!file_exists(__DIR__ . "/../Plugins/$pluginClass.php"))
                throw new LaraHtmlPluginNotFoundException("Plugin $class does not exist!");

            // RESOLVENDO A HIERARQUIA DE PARÂMETROS EM MÉTODOS DINÂMICOS
            while (is_array($arguments[0]))
                $arguments = $arguments[0];

            // LANÇA ERRO PERSONALIZADO CASO OS ARGUMENTOS PARA CRIAR O PLUGIN ESTEJAM INVÁLIDOS
            try {
                $obj = new $class(...$arguments); // CRIANDO OBJETO
            } catch (\TypeError $e) {
                throw new LaraHtmlParametersException($e->getMessage());
            }

            $col = new Col(); // CRIANDO COLUNA
            $this->addPlugin($col);
            $col->addPlugin($obj);

            return $obj;


            if ($this instanceof Col) {
                $pluginClass = substr($name, 3); // IGNORANDO O PREFIXO add
                $class = "LaraHtml\Plugins\\$pluginClass"; // NOME DA CLASSE COM NAMESPACE PARA CRIAR O OBJETO

                // LANÇA UM ERRO CASO O ARQUIVO DA CLASSE NÃO EXISTA
                if (!file_exists(__DIR__ . "/../../Plugins/$pluginClass.php"))
                    throw new LaraHtmlPluginNotFoundException("Plugin $class does not exist!");

                // RESOLVENDO A HIERARQUIA DE PARÂMETROS EM MÉTODOS DINÂMICOS
                while (is_array($arguments[0]))
                    $arguments = $arguments[0];

                // LANÇA ERRO PERSONALIZADO CASO OS ARGUMENTOS PARA CRIAR O PLUGIN ESTEJAM INVÁLIDOS
                try {
                    $this->pluginOrRows = $obj = new $class(...$arguments); // CRIANDO OBJETO
                } catch (\TypeError $e) {
                    throw new LaraHtmlParametersException($e->getMessage());
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
            throw new LaraHtmlMethodNotFoundException("Method $name does not exist!");
    }
}
