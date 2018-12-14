<?php
/**
 * Cria novos plugins dinamicamente
 * Gerencia toda a lógica do Grid Bootstrap (Linhas e Colunas)
 *
 * Created by: André Moreira
 * Date: 11/12/18
 * Time: 00:10
 */

namespace PhpHtml\Abstracts;

use PhpHtml\Errors\MethodNonexistentError;
use PhpHtml\Errors\PluginNonexistentError;
use PhpHtml\Plugins\Grid\Col;
use PhpHtml\Plugins\Grid\Row;

abstract class CreatePluginAbstract
{

    /**
     * @var array Armazena os objetos de linhas
     */
    private $rows = [];

    /**
     * @var Row Linha atual
     */
    private $rowCurrent;

    /**
     * Inicia a linha atual
     *
     * PhpHtml constructor.
     * @param Row $rowCurrent
     */
    public function __construct(Row $rowCurrent)
    {
        $this->rows[] = $this->rowCurrent = $rowCurrent;
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

        // CRIA NOVA LINHA CASO O TOTAL DE COLUNAS DA ATUAL SEJA 12 OU O DESENVOLVEDOR INDIQUE MANUALMENTE
        if (($this->rowCurrent->totalColumns() == 12)
            or ($name == 'row'))
            return $this->rows[] = $this->rowCurrent = new Row();
        elseif ($prefix == 'add')
            // ADICIONA NOVA COLUNA PARA CRIAR NOVO PLUGIN
            return $this->rowCurrent->addCol($name, $arguments[0]);
        else
            // CASO O PREFIXO DO MÉTODO CHAMADO NÃO SEJA add UM ERRO DE MÉTODO INEXISTENTE É LANÇADO
            throw new MethodNonexistentError("Method $name does not exist!");
    }

}