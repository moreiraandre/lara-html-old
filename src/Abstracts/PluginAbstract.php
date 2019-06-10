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

use Illuminate\Container\Container as Container;
use Illuminate\Support\Facades\Facade as Facade;

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
     * @param string $template
     * @param array $data
     * @return string
     */
    protected function getTemplate(string $template, array $data): string
    {
//        $template = file_get_contents(__DIR__ . "/../Template/bootstrap4/$template.php");
//        $template = View::first(['php-html.Form', 'Form'], $data);

        $app = new Container();
        $app->singleton('app', 'Illuminate\Container\Container');

        Facade::setFacadeApplication($app);
//        $app->bind(View::class, 'Illuminate\Support\Facades\View');

//        $template = View::make('Form', $data);
        $template = $app->make('view')->make('mi-vista');
        return $template;
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
