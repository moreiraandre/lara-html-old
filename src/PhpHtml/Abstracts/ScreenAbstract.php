<?php
/**
 * Responsável por gerar o HTML geral da tela.
 *
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:37
 */

namespace PhpHtml\Abstracts;

use PhpHtml\Abstracts\Plugins\PluginAbstract;
use PhpHtml\Interfaces\ScreenInterface;
use PhpHtml\Finals\Row;

abstract class ScreenAbstract implements ScreenInterface
{
    /**
     * @var array|null
     */
    private $rows = null;

    /**
     * @var Row|null
     */
    private $currentRow = null;

    /**
     * Inicia a linha atual
     *
     * ScreenAbstract constructor.
     * @param Row $row
     */
    public function __construct(Row $row)
    {
        $this->rows[] = $this->currentRow = $row;
    }

    /**
     * Cria plugins dinamicamente pelo nome da classe invocada ou adiciona nova linha
     *
     * @param $name
     * @param $arguments
     * @return PluginAbstract|Row
     */
    public function __call($name, $arguments)
    {
        // CASO O TOTAL DE COLUNAS DA LINHA SEJA 12 OU O DESENVOLVEDOR SOLICITE NOVA LINHA ENTÃO A NOVA LINHA SERÁ CRIADA
        if (($this->currentRow->totalCols() == 12)
            or ($name == 'row'))
            $this->rows[] = $this->currentRow = new Row();

        if ($name == 'row')
            return $this->currentRow;
        else // CASO O DESENVOLVEDOR ESTEJA CRIANDO NOVO PLUGIN ELE SERÁ ADICIONADO A UMA COLUNA
            return $this->currentRow->addCol($name, $arguments);
    }

    /**
     * Gera e retorna o HTML da classe filha.
     *
     * @return string
     */
    public final function getHtml(): string
    {
        static::run(); // POPULA AS VARIÁVEIS PRIVADAS COM OS OBJETOS DE PLUGINS

        // GERA O HTML DE TODAS AS LINHAS
        $html = '';
        foreach ($this->rows as $row)
            $html .= $row->getHtml();

        return $html;
    }

}