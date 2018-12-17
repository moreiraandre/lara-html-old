<?php
/**
 * Define o Padrão de um Plugin simples, o qual NÃO armazena outros plugins
 *
 * Created by: André Moreira
 * Date: 16/12/18
 * Time: 22:45
 */

namespace PhpHtml\Abstracts\Plugins;

use PhpHtml\Errors\PhpHtmlMethodNotFoundError;
use PhpHtml\Interfaces\PluginOutHtmlInterface;

abstract class SinglePluginAbstract extends PluginAbstract implements PluginOutHtmlInterface
{
    /**
     * Define atributos de tag
     *
     * @param $name
     * @param $arguments
     * @return $this
     * @throws \Throwable
     */
    public function __call($name, $arguments)
    {
        $prefix = substr($name, 0, 4); // ARMAZENA OS 4 PRIMEIROS CARACTERES

        // SE O PREFIXO DO COMANDO INVOCADO FOR attr ENTÃO NO ATRIBUTO SERÁ CRIADO
        if ($prefix == 'attr') {
            // PULA OS 4 CARACTERES DO PREFIXO E ARMAZENA O RESTANTE EM CAIXA BAIXA
            $attribute = mb_strtolower(substr($name, 4));
            $this->attributes[$attribute] = $arguments[0]; // ARMAZENA O ATRIBUTO E SEU VALOR

            return $this; // RETORNA O PRÓPRIO PLUGIN
        } else
            // CASO O PREFIXO DO MÉTODO CHAMADO NÃO SEJA attr UM ERRO DE MÉTODO INEXISTENTE É LANÇADO
            throw new PhpHtmlMethodNotFoundError("Method $name does not exist!");
    }
}