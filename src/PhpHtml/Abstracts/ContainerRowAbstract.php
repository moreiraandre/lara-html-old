<?php
/**
 * Define o padrão de um plugin que armazena outros plugins
 *
 * Created by: André Moreira
 * Date: 16/12/18
 * Time: 22:50
 */

namespace PhpHtml\Abstracts\Plugins;

use PhpHtml\Errors\PhpHtmlMethodNotFoundError;
use PhpHtml\Errors\PhpHtmlParametersError;
use PhpHtml\Errors\PhpHtmlPluginNotFoundError;
use PhpHtml\Finals\Col;
use PhpHtml\Finals\Row;

abstract class ContainerRowAbstract extends PluginAbstract
{
    /**
     * @var PluginAbstract|array Armazena um plugin ou linhas
     */
    private $pluginOrRows = null;

    /**
     * @var null|Row Linha atual se não estiver armazenando somente um plugin
     */
    private $currentRow = null;

    /**
     * Inicia a Linha Atual
     *
     * @param Row $currentRow
     */
    public function __construct(Row $currentRow)
    {
        $this->currentRow = $currentRow;
    }

    /**
     * @return Row|null
     */
    public function getCurrentRow(): ?Row
    {
        return $this->currentRow;
    }

    /**
     * @param Row $currentRow
     */
    public function setCurrentRow(Row $currentRow): void
    {
        $this->currentRow = $currentRow;
    }

    /**
     * Armazena um plugin quando ele já é um objeto
     *
     * @param PluginAbstract $plugin
     */
    public function pluginObj(PluginAbstract $plugin)
    {
        $this->pluginOrRows = $plugin;
    }

    /**
     * Retorna o array que armazena os plugins
     *
     * @return array
     */
    public function getPlugins()
    {
        return $this->pluginOrRows;
    }

    /**
     * @return \Illuminate\Support\Collection|null
     */
    public function rows()
    {
        return is_array($this->pluginOrRows) ? collect($this->pluginOrRows) : null;
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
            if (($this instanceof Col) && ($this->pluginOrRows === null)) {
                $pluginClass = substr($name, 3); // IGNORANDO O PREFIXO add
                $class = "PhpHtml\Plugins\\$pluginClass"; // NOME DA CLASSE COM NAMESPACE PARA CRIAR O OBJETO

                // LANÇA UM ERRO CASO O ARQUIVO DA CLASSE NÃO EXISTA
                if (!file_exists(__DIR__ . "/../../Plugins/$pluginClass.php"))
                    throw new PhpHtmlPluginNotFoundError("Plugin $class does not exist!");

                // RESOLVENDO A HIERARQUIA DE PARÂMETROS EM MÉTODOS DINÂMICOS
                while (is_array($arguments[0]))
                    $arguments = $arguments[0];

                // LANÇA ERRO PERSONALIZADO CASO OS ARGUMENTOS PARA CRIAR O PLUGIN ESTEJAM INVÁLIDOS
                try {
                    $this->pluginOrRows = $obj = new $class(...$arguments); // CRIANDO OBJETO
                } catch (\TypeError $e) {
                    throw new PhpHtmlParametersError($e->getMessage());
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
            throw new PhpHtmlMethodNotFoundError("Method $name does not exist!");
    }

    /**
     * Retorna o HTML dos plugins filhos
     *
     * @return string
     */
    public function getHtmlPlugins()
    {
        $html = '';
        // APROVEITANDO REPETIÇÃO DE ARMAZENAMENTO DO HTML MESMO QUE ESTEJA ARMAZENDO UM PLUGIN AO INVÉS DE LINHAS
        $this->pluginOrRows = !is_array($this->pluginOrRows) ? [$this->pluginOrRows] : $this->pluginOrRows;
        foreach ($this->pluginOrRows as $plugin) {

            // !!! SOMENTE PARA DESCOBERTA DE ERRO! DEVE SER RETIRADO!!!
            try {
                $html .= $plugin->getHtml();
            } catch (\Error $error) {
                echo $error->getMessage();
                echo "<br>";
                var_dump($plugin);
                echo "<br>";
                var_dump($this->pluginOrRows);
                echo "<br>";
                echo class_basename($plugin);
                echo "<br>";
            }
        }

        return $html;
    }

}
