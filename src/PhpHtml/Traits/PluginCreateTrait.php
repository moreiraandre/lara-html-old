<?php
/**
 * Adiciona a funcionalidade de criar novos objetos de plugins
 *
 * Created by: André Moreira
 * Date: 11/12/18
 * Time: 00:10
 */

namespace PhpHtml\Traits;


use PhpHtml\Errors\MethodNonexistentError;
use PhpHtml\Errors\PluginNonexistentError;
use PhpHtml\Plugins\Col;

trait PluginCreateTrait
{

    /**
     * @var array Armazena os objetos de plugins
     */
    private $plugins = [];

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
            // NECESSÁRIO PORQUE ESTE PARÂMETRO JÁ VEM DO MÉTODO __call DA Row O QUALO TRANSFORMA AUTOMATICAMENTE EM UM VETOR
            $arguments = $arguments[0];

            $pluginClass = substr($name, 3); // IGNORANDDO O TEXTO add

            $class = "PhpHtml\Plugins\\$pluginClass"; // NOME DA CLASSE COM NAMESPACE PARA CRIAR O OBJETO

            // LANÇA UM ERRO CASO O ARQUIVO DA CLASSE NÃO EXISTA
            if (!file_exists(__DIR__ . "/../Plugins/$pluginClass.php"))
                throw new PluginNonexistentError("Plugin $class does not exist!");

            $arguments = !is_array($arguments) ? [$arguments] : $arguments; //!!!!!!!!!!!!!!!
            $this->plugins[] = $obj = new $class(...$arguments); // CRIANDO OBJETO
            $col = $this instanceof Col ? $this : $this->getCol(); //!!!!!!!!!!!!!!!
            $obj->setCol($col); // GUARDANDO REFERÊNCIA DA COLUNA NO PLUGIN
            $obj->setRow($this->row); // GUARDANDO REFERÊNCIA DA LINHA NO PLUGIN

            return $obj;
        } else
            // CASO O PREFIXO DO MÉTODO CHAMADO NÃO SEJA add UM ERRO DE MÉTODO INEXISTENTE É LANÇADO
            throw new MethodNonexistentError("Method $name does not exist!");
    }

    /**
     * Retorna o HTML concatenado dos plugins
     *
     * @return string
     */
    protected function getPluginsHtml()
    {
        dd($this->plugins);
        $html = '';
        foreach ($this->plugins as $plugin)
            $html .= "<div class='col-sm'>{$plugin->getHtml()}</div>";

        return $html;
    }

}