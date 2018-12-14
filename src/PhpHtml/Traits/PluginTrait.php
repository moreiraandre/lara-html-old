<?php
/**
 * Adiciona as funcionalidades de criar novos objetos de plugins e definir seus atributos de tag
 *
 * Created by: André Moreira
 * Date: 11/12/18
 * Time: 00:10
 */

namespace PhpHtml\Traits;


use PhpHtml\Errors\MethodNonexistentError;
use PhpHtml\Errors\PluginNonexistentError;
use PhpHtml\Plugins\Grid\Col;
use PhpHtml\Plugins\Grid\Row;

trait PluginTrait
{

    /**
     * @var array Armazena os objetos de plugins
     */
    private $plugins = [];

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
        $this->plugins[] = $this->rowCurrent = $rowCurrent;
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
        $prefix = substr($name, 0,3);

        if ($prefix == 'add') {
            // NECESSÁRIO PORQUE ESTE PARÂMETRO JÁ VEM DO MÉTODO __call DA Row O TRANSFORMA AUTOMATICAMENTE EM UM VETOR
            $arguments = $arguments[0];

            $pluginClass = substr($name, 3); // IGNORANDO O PREFIXO add

            $class = "PhpHtml\Plugins\\$pluginClass"; // NOME DA CLASSE COM NAMESPACE PARA CRIAR O OBJETO

            // LANÇA UM ERRO CASO O ARQUIVO DA CLASSE NÃO EXISTA
            if (!file_exists(__DIR__ . "/../Plugins/$pluginClass.php"))
                throw new PluginNonexistentError("Plugin $class does not exist!");

            if ($this instanceof Col) {
                $arguments = !is_array($arguments) ? [$arguments] : $arguments; //!!!!!!!!!!!!!!!
                $this->plugins[] = $obj = new $class(...$arguments); // CRIANDO OBJETO
                $obj->setCol($this); // GUARDANDO REFERÊNCIA DA COLUNA NO PLUGIN
                $obj->setRow($this->row); // GUARDANDO REFERÊNCIA DA LINHA NO PLUGIN

                return $obj;
            } else {
                if (($this->rowCurrent->totalColumns() == 12)
                    or ($name == 'row'))
                    $this->plugins[] = $this->rowCurrent = new Row();

                if ($name == 'row')
                    return $this->rowCurrent;
                else
                    return $this->rowCurrent->addCol($name, $arguments);
            }
        } elseif ($prefix == 'attr') {
            $attribute = mb_strtolower(substr($name, 3));
            $this->attributes[$attribute] = $arguments[0]; // ARMAZENA O ATRIBUTO E SEU VALOR

            return $this;
        } else
            // CASO O PREFIXO DO MÉTODO CHAMADO NÃO SEJA add UM ERRO DE MÉTODO INEXISTENTE É LANÇADO
            throw new MethodNonexistentError("Method $name does not exist!");
    }

}