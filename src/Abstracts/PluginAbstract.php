<?php
/**
 * Define o Padrão de um Plugin
 *
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:40
 */

namespace LaraHtml\Abstracts;

use LaraHtml\Exceptions\LaraHtmlMethodNotFoundException;
use LaraHtml\Interfaces\PluginOutHtmlInterface;
use LaraHtml\Finals\Col;
use LaraHtml\Finals\Row;

abstract class PluginAbstract implements PluginOutHtmlInterface
{
    /**
     * Referência da linha pai
     *
     * @var Row
     */
    private $row = null;

    /**
     * Referência da coluna pai
     *
     * @var Col
     */
    private $col = null;

    /**
     * Template para a definição do HTML
     *
     * @var string
     */
    private $template = null;

    /**
     * Armazena atributos de tag HTML
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * @return null|Row
     */
    final public function getRow(): ?Row
    {
        return $this->row;
    }

    /**
     * @param Row $row
     */
    final public function setRow(Row $row): void
    {
        $this->row = $row;
    }

    /**
     * @return Col
     */
    final public function getCol(): Col
    {
        return $this->col;
    }

    /**
     * @param Col $col
     */
    final public function setCol(Col $col): void
    {
        $this->col = $col;
    }

    /**
     * PluginAbstract constructor.
     */
    public function __construct()
    {
        $this->template = config('larahtml.default');
    }

    /**
     * @return string
     */
    protected function getTemplate(): string
    {
//        echo get_class($this).' - '.$this->template.'<br>';
        return $this->template;
    }

    /**
     * Retorna a view blade.
     *
     * @param string $viewName
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getView(string $viewName, array $data)
    {
        return view('larahtml::' . $this->getTemplate() . '.' . $viewName, $data);
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
        } else
            // CASO O PREFIXO DO MÉTODO CHAMADO NÃO SEJA attr UM ERRO DE MÉTODO INEXISTENTE É LANÇADO
            throw new LaraHtmlMethodNotFoundException("Method $name does not exist!");
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
