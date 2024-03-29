<?php

/**
 * Armazena linhas. Faz a gestão das linhas, bem como criação de plugins e suas colunas.
 */

namespace LaraHtml\Traits;

use LaraHtml\Exceptions\LaraHtmlParametersException;
use LaraHtml\Grid\Col;
use LaraHtml\Grid\Plugin;
use LaraHtml\Grid\Row;

/**
 * Trait StoresRows
 *
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
            self::replacePluginForRows();

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
                self::replacePluginForRows();
            // CASO O OBJETO SEJA UMA COLUNA E NÃO CONTENHA PLUGINS FILHOS SERÁ CRIADO UM PLUGIN

            $pluginClass = substr($name, 3); // IGNORANDO O PREFIXO add
//            $class = "LaraHtml\Plugins\\$pluginClass"; // NOME DA CLASSE COM NAMESPACE PARA CRIAR O OBJETO
            $class = Plugin::class; // NOME DA CLASSE COM NAMESPACE PARA CRIAR O OBJETO

            // RESOLVENDO A HIERARQUIA DE PARÂMETROS EM MÉTODOS DINÂMICOS
            if (isset($arguments[0]))
                while (is_array($arguments[0]))
                    $arguments = $arguments[0];

            // LANÇA ERRO PERSONALIZADO CASO OS ARGUMENTOS PARA CRIAR O PLUGIN ESTEJAM INVÁLIDOS
            try {
                $obj = new $class($pluginClass, $arguments, $this->getTemplate()); // CRIANDO OBJETO
            } catch (\TypeError $e) {
                throw new LaraHtmlParametersException($e->getMessage());
            }

            // VERIFICA SE A QUANTIDADE DE COLUNAS CHEGOU AO MÁXIMO PARA CRIAR NOVA LINHA
            if ($this->currentRow->countCols() >= parent::config('max_cols'))
                $this->newRow(new Row);

            $col = new Col($this->currentRow, $this->getTemplate()); // CRIANDO COLUNA
            $this->currentRow->newCol($col); // INSERINDO ANOVA COLUNA NA LINHA ATUAL
            $col->newPlugin($obj); // INSERINDO O NOVO PLUGIN NA COLUNA

            return $obj;
        } else
            parent::__call($name, $arguments);
    }

}
