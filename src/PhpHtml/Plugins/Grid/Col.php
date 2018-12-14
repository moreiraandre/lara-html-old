<?php
/**
 * Created by: André Moreira
 * Date: 21/11/18
 * Time: 02:06
 */

namespace PhpHtml\Plugins\Grid;


use PhpHtml\Errors\PluginNonexistentError;
use PhpHtml\Interfaces\PluginOutHtmlInterface;
use PhpHtml\Traits\CreatePluginTrait;

/**
 * Class Col
 * @package PhpHtml\Plugins
 */
final class Col implements PluginOutHtmlInterface
{

    /**
     * @var array Armazena os objetos de plugins
     */
    private $plugins = [];

    /**
     * @var array Armazena os objetos de linhas
     */
    private $rows = [];

    /**
     * @var Row Linha atual
     */
    private $rowCurrent;

    /**
     * @var Row Referência da linha
     */
    private $row;

    /**
     * @var null
     */
    private $accessRows = null;

    /**
     * Inicia a linha atual
     *
     * PhpHtml constructor.
     * @param Row $rowCurrent
     */
    public function __construct(Row $rowCurrent)
    {
        $this->rows[] = $this->rowCurrent = $rowCurrent;
        $this->accessRows = new GetItems($this->rows);
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

        if (($this->rowCurrent->totalColumns() == 12)
            or ($name == 'row'))
            return $this->rows[] = $this->rowCurrent = new Row();
        elseif ($prefix == 'add') {
            $pluginClass = substr($name, 3); // IGNORANDO O PREFIXO add

            $class = "PhpHtml\Plugins\\$pluginClass"; // NOME DA CLASSE COM NAMESPACE PARA CRIAR O OBJETO

            // LANÇA UM ERRO CASO O ARQUIVO DA CLASSE NÃO EXISTA
            if (!file_exists(__DIR__ . "/../../Plugins/$pluginClass.php"))
                throw new PluginNonexistentError("Plugin $class does not exist!");

            if ($this instanceof Col) {
                $arguments = !is_array($arguments) ? [$arguments] : $arguments; //!!!!!!!!!!!!!!!
                $this->plugins[] = $obj = new $class(...$arguments); // CRIANDO OBJETO
                $obj->setCol($this); // GUARDANDO REFERÊNCIA DA COLUNA NO PLUGIN
                $obj->setRow($this->getRow()); // GUARDANDO REFERÊNCIA DA LINHA NO PLUGIN

                return $obj;
            } else
                return $this->rowCurrent->addCol($name, $arguments);
        } else
            // CASO O PREFIXO DO MÉTODO CHAMADO NÃO SEJA add UM ERRO DE MÉTODO INEXISTENTE É LANÇADO
            throw new MethodNonexistentError("Method $name does not exist!");
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
        return $this->plugins;
    }

    /**
     * @return GetItems|null
     */
    public function rows()
    {
        return $this->accessRows;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        $html = '';
        foreach ($this->plugins as $plugin)
            $html .= $plugin->getHtml();

        return "<div class='col-sm'>$html</div>";
    }

}
