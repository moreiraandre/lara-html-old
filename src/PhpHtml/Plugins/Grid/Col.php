<?php
/**
 * Created by: André Moreira
 * Date: 21/11/18
 * Time: 02:06
 */

namespace PhpHtml\Plugins\Grid;

use PhpHtml\Abstracts\PluginAbstract;
use PhpHtml\Errors\PhpHtmlMethodNotFoundError;
use PhpHtml\Errors\PhpHtmlParametersError;
use PhpHtml\Errors\PhpHtmlPluginNotFoundError;
use PhpHtml\Interfaces\PluginOutHtmlInterface;

/**
 * Class Col
 * @package PhpHtml\Plugins
 */
final class Col implements PluginOutHtmlInterface
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
     * @var Row Referência da linha mãe
     */
    private $row;

    /**
     * Col constructor.
     * @param Row $row Linha mãe
     */
    public function __construct(Row $row)
    {
        $this->row = $row;
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
            if ($this->pluginOrRows === null) { // CASO A COLUNA ESTEJA VAZIA SERÁ CRIADO UM PLUGIN
                $pluginClass = substr($name, 3); // IGNORANDO O PREFIXO add
                $class = "PhpHtml\Plugins\\$pluginClass"; // NOME DA CLASSE COM NAMESPACE PARA CRIAR O OBJETO

                // LANÇA UM ERRO CASO O ARQUIVO DA CLASSE NÃO EXISTA
                if (!file_exists(__DIR__ . "/../$pluginClass.php"))
                    throw new PhpHtmlPluginNotFoundError("Plugin $class does not exist!");

                // LANÇA ERRO PERSONALIZADO CASO OS ARGUMENTOS PARA CRIAR O PLUGIN ESTEJAM INVÁLIDOS
                try {
                    $this->pluginOrRow = $obj = new $class(...$arguments); // CRIANDO OBJETO
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
                    $auxCol->pluginObj($currentPlugin); // ADICIONANDO O OBJETO DO PLUGIN Á NOVA COLUNA
                    $currentPlugin->setRow($this->currentRow); // GUARDANDO REFERÊNCIA DA LINHA NO PLUGIN
                    $currentPlugin->setCol($auxCol); // GUARDANDO REFERÊNCIA DA COLUNA NO PLUGIN
                    $this->pluginOrRows = [$this->currentRow]; // SUBSTITUINDO O PLUGIN ATUAL PELA LINHA ATUAL
                    //                     *** FIM SUBSTITUINDO O PLUGIN ARMAZENADO POR LINHAS ***

                    // ADICIONANDO O NOVO PLUGIN
                    return $this->currentRow->addCol($name, ...$arguments);
                } else {
                    /* CASO A COLUNA JÁ ESTEJA ARMAZENANDO LINHAS UMA NOVA COLUNA SERÁ ADICIONADA A LINHA ATUAL COM A
                     * SOLICITAÇÃO DE CRIAÇÃO DO PLUGIN
                     */
                    // CASO O TOTAL DE COLUNAS DA LINHA SEJA 12 OU O DESENVOLVEDOR SOLICITE NOVA LINHA ENTÃO A NOVA LINHA SERÁ CRIADA
                    if (($this->currentRow->totalCols() == 12)
                        or ($name == 'row'))
                        $this->pluginOrRows[] = $this->currentRow = new Row();

                    if ($name == 'row')
                        return $this->currentRow;
                    else // CASO O DESENVOLVEDOR ESTEJA CRIANDO NOVO PLUGIN ELE SERÁ ADICIONADO A UMA COLUNA
                        return $this->currentRow->addCol($name, ...$arguments);
                }
            }
        } elseif($prefix == 'row') // ADICIONANDO NOVA LINHA SOLICITADA PELO DDESENVOLVEDOR
            return $this->pluginOrRows[] = $this->currentRow = new Row();
        else
            // CASO O PREFIXO DO MÉTODO CHAMADO NÃO SEJA add UM ERRO DE MÉTODO INEXISTENTE É LANÇADO
            throw new PhpHtmlMethodNotFoundError("Method $name does not exist!");
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
     * Retorna a referência da linha
     *
     * @return Row
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * Guarda a referência da linha
     *
     * @param Row $row
     */
    public function setRow(Row $row)
    {
        $this->row = $row;
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
     * @return string
     */
    public function getHtml(): string
    {
        $html = '';
        // APROVEITANDO REPETIÇÃO DE ARMAZENAMENTO DO HTML MESMO QUE ESTEJA ARMAZENDO UM PLUGIN AO INVÉS DE LINHAS
        $this->pluginOrRows = !is_array($this->pluginOrRows) ? [$this->pluginOrRows] : $this->pluginOrRows;
        foreach ($this->pluginOrRows as $plugin)
            $html .= $plugin->getHtml();

        return "<div class='col-sm'>$html</div>";
    }

}
