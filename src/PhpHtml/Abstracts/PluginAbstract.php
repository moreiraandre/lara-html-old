<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:40
 */

namespace PhpHtml\Abstracts;

use PhpHtml\Errors\MethodNonexistentError;
use PhpHtml\Interfaces\PluginInterface;
use PhpHtml\Plugins\Col;
use PhpHtml\Plugins\Row;
use PhpHtml\Traits\PluginTrait;

abstract class PluginAbstract implements PluginInterface
{
    use PluginTrait;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * Referência da linha pai
     *
     * @var \PhpHtml\Plugins\Row
     */
    private $row;

    /**
     * Referência da coluna pai
     *
     * @var \PhpHtml\Plugins\Col
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
     * Define atributos de tag ou cria plugins dentro do atual
     *
     * @param $name
     * @param $arguments
     * @return $this
     * @throws \Throwable
     */
    /*public function __call($name, $arguments)
    {
        $prefix = substr($name, 0, 3);

        if ($prefix == 'attr') {
            $attribute = mb_strtolower(substr($name, 3));
            $this->attributes[$attribute] = $arguments[0]; // ARMAZENA O ATRIBUTO E SEU VALOR

            return $this;
        }  else
            // CASO O PREFIXO DO MÉTODO CHAMADO NÃO SEJA set UM ERRO DE MÉTODO INEXISTENTE É LANÇADO
            throw new MethodNonexistentError("Method $name does not exist!");
    }*/

    /**
     * Retorna os atributos formatados para adicionar a tag HTML
     *
     * @return string
     */
    public function getAttributesTag()
    {
        $html = '';
        foreach ($this->attributes as $attr => $value)
            $html .= "$attr=\"$value\"";

        return $html;
    }
}