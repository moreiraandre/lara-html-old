<?php

/**
 * Comum a todas as classes.
 */

namespace LaraHtml\Abstracts;


use LaraHtml\Exceptions\LaraHtmlConfigNotFoundException;
use LaraHtml\Exceptions\LaraHtmlMethodNotFoundException;
use LaraHtml\Interfaces\PluginOutHtmlInterface;
use LaraHtml\Traits\RowCol;

/**
 * Class General
 * @package LaraHtml\Abstracts
 */
abstract class General implements PluginOutHtmlInterface
{
    use RowCol;

    /**
     * Template para a definição do HTML.
     *
     * @var string
     */
    protected $template = null;

    /**
     * Armazena atributos de tag HTML
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Se o Template não for definido por troca do valor na classe filha ele será chamado da configuração.
     *
     * General constructor.
     */
    public function __construct()
    {
        $this->template = $this->template ?: config('larahtml.config.default');
        if (!file_exists(config_path("larahtml/{$this->template}.php")))
            throw new LaraHtmlConfigNotFoundException("Config 'larahtml/{$this->template}.php' not found!");
    }

    /**
     * Define atributos de tag
     *
     * @param $name
     * @param $arguments
     * @return $this
     * @throws LaraHtmlMethodNotFoundException
     */
    public function __call($name, $arguments)
    {
        $prefix = substr($name, 0, 4); // ARMAZENA OS 4 PRIMEIROS CARACTERES

        // SE O PREFIXO DO COMANDO INVOCADO FOR attr ENTÃO NO ATRIBUTO SERÁ CRIADO
        if ($prefix == 'attr') {
            // PULA OS 4 CARACTERES DO PREFIXO E ARMAZENA O RESTANTE EM CAIXA BAIXA
            $attribute = mb_strtolower(substr($name, 4));
            if (!empty($this->attributes[$attribute])) // SE O ATRIBUTO JÁ POSSUIR VALOR
                $this->attributes[$attribute] .= " {$arguments[0]}"; // O NOVO VALOR SERÁ CONCATENADO NO FIM
            else
                $this->attributes[$attribute] = $arguments[0]; // ARMAZENA O ATRIBUTO E SEU VALOR

            return $this; // RETORNA O PRÓPRIO PLUGIN
        } else
            // CASO O PREFIXO DO MÉTODO CHAMADO NÃO SEJA attr UM ERRO DE MÉTODO INEXISTENTE É LANÇADO
            throw new LaraHtmlMethodNotFoundException("Method $name does not exist!");
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
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

    /**
     * Retorna a view blade.
     *
     * @param string $viewName
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function getView(string $viewName, array $data)
    {
        return view('larahtml::' . $this->getTemplate() . '.' . $viewName, $data);
    }

    /**
     * Retorna o HTML de todos os elementos passados.
     *
     * @param array|null $elements
     * @return string
     */
    protected function getHtmlElements(?array $elements): string
    {
        $html = '';
        $elements = $elements ?: [];
        $total = count($elements);
        foreach ($elements as $idx => $e) {
//            dd("getHtmlPlugins: " . get_class($this) . ' - ' . get_class($plugin));
            $html .= $e->getHtml([
                'total' => $total,
                'idx' => $idx,
            ]);
        }
        return $html;
    }

    /**
     * Retorna uma configuração do template padrão.
     *
     * @param string $config
     * @return \Illuminate\Config\Repository|mixed
     */
    protected function config(string $config)
    {
        return config("larahtml." . $this->getTemplate() . ".$config");
    }
}
