<?php

/**
 * Armazena linhas.
 */

namespace LaraHtml\Traits;


use LaraHtml\Exceptions\LaraHtmlParametersException;
use LaraHtml\Exceptions\LaraHtmlPluginNotFoundException;
use LaraHtml\Grid\Col;
use LaraHtml\Grid\Row;

/**
 * Trait StoresRows
 * @package LaraHtml\Traits
 */
trait StoresRows
{

    /**
     * @var null|array
     */
    private $rows = null;

    /**
     * Linha atual.
     *
     * @var null|Row
     */
    private $currentRow = null;

    /**
     * @return array|null
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * Método para o dev criar nova linha.
     *
     * @return Row
     * @throws \LaraHtml\Exceptions\LaraHtmlConfigNotFoundException
     */
    public function row()
    {
        // SE FOR UMA COLUNA QUE AINDA NÃO ESTÁ ARMAZENANDO LINHAS, A TROCA SERÁ FEITA
        if (($this instanceof Col) && ($this->isStoredPlugin()))
            self::changePluginRows();

        return $this->newRow(new Row);
    }

    /**
     * Armazenar nova linha e define como atual.
     *
     * @param Row $row
     * @return Row
     */
    public function newRow(Row $row)
    {
        return $this->currentRow = $this->rows[] = $row;
    }

    /**
     * Cria objetos de plugins.
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
            // SE FOR UMA COLUNA QUE AINDA NÃO ESTÁ ARMAZENANDO LINHAS, A TROCA SERÁ FEITA
            if (($this instanceof Col) && ($this->isStoredPlugin()))
                self::changePluginRows();
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

            // VERIFICA SE AQUANTIDADE DE COLUNAS CHEGOU AO MÁXIMO PARA CRIAR NOVA LINHA
            if ($this->currentRow->countCols() >= parent::config('max_cols'))
                $this->newRow(new Row);

            $col = new Col($this->currentRow); // CRIANDO COLUNA
            $this->currentRow->newCol($col); // INSERINDO ANOVA COLUNA NA LINHA ATUAL
            $col->newPlugin($obj); // INSERINDO O NOVO PLUGIN NA COLUNA

            return $obj;
        } else
            parent::__call($name, $arguments);
    }

}
