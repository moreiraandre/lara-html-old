<?php
/**
 * Define o Padrão de um Plugin
 *
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:40
 */

namespace PhpHtml\Abstracts;

use PhpHtml\Errors\MethodNonexistentError;
use PhpHtml\Interfaces\PluginOutHtmlInterface;
use PhpHtml\Plugins\Grid\Col;
use PhpHtml\Plugins\Grid\Row;
use PhpHtml\Traits\CreatePluginTrait;

/**
 * Class PluginAbstract
 * @package PhpHtml\Abstracts
 */
abstract class PluginAbstract implements PluginOutHtmlInterface
{
    use CreatePluginTrait;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * Referência da linha pai
     *
     * @var Row
     */
    private $row;

    /**
     * Referência da coluna pai
     *
     * @var Col
     */
    private $col;

    /**
     * @return Row
     */
    public function getRow(): Row
    {
        return $this->row;
    }

    /**
     * @param Row $row
     */
    public function setRow(Row $row): void
    {
        $this->row = $row;
    }

    /**
     * @return Col
     */
    public function getCol(): Col
    {
        return $this->col;
    }

    /**
     * @param Col $col
     */
    public function setCol(Col $col): void
    {
        $this->col = $col;
    }

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
        }  else
            // CASO O PREFIXO DO MÉTODO CHAMADO NÃO SEJA attr UM ERRO DE MÉTODO INEXISTENTE É LANÇADO
            throw new MethodNonexistentError("Method $name does not exist!");
    }

    /**
     * Retorna os atributos formatados para adicionar a tag HTML
     *
     * @return string
     */
    public function getAttributesTag()
    {
        $html = '';
        foreach ($this->attributes as $attr => $value)
            $html .= " $attr=\"$value\"";

        return ltrim($html); // RETIRA PRIMEIRO ESPAÇO ANTES DE RETORNAR
    }
}