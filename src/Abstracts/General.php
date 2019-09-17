<?php

/**
 * Comum a todas as classes.
 */

namespace LaraHtml\Abstracts;

use Illuminate\Support\Str;
use LaraHtml\Exceptions\LaraHtmlConfigNotFoundException;
use LaraHtml\Exceptions\LaraHtmlMethodNotFoundException;
use LaraHtml\Interfaces\PluginOutHtmlInterface;
use LaraHtml\Traits\RowCol;
use LaraHtml\Traits\StoreData;

/**
 * Class General
 *
 * @package LaraHtml\Abstracts
 */
abstract class General implements PluginOutHtmlInterface
{
    use
        RowCol, // Definições de Linha e Coluna do Objeto.
        StoreData; // Armazenando Dados em Massa.

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
    private $attributes = [];

    /**
     * Meta dados.
     *
     * @var array
     */
    private $metas = [];

    /**
     * Se o Template não for definido por troca do valor na classe CustomScreen ele será chamado da configuração.
     *
     * @param string|null $template
     * @throws LaraHtmlConfigNotFoundException
     */
    public function __construct(string $template = null)
    {
        $this->template = $template ?: config('larahtml.config.default');
        if (!file_exists(config_path("larahtml/{$this->template}.php")))
            throw new LaraHtmlConfigNotFoundException("Config 'larahtml/{$this->template}.php' not found!");
    }

    /**
     * Define atributos de tag concatenando com os valores da configuração.
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
            $attribute = Str::kebab(substr($name, 4));
            if (!empty($this->attributes[$attribute])) // SE O ATRIBUTO JÁ POSSUIR VALOR
                $this->attributes[$attribute] .= " {$arguments[0]}"; // O NOVO VALOR SERÁ CONCATENADO NO FIM
            else
                $this->attributes[$attribute] = $arguments[0]; // ARMAZENA O ATRIBUTO E SEU VALOR

            return $this; // RETORNA O PRÓPRIO PLUGIN
        } elseif ($prefix == 'meta') {
            // PULA OS 4 CARACTERES DO PREFIXO E ARMAZENA O RESTANTE EM CAIXA BAIXA
            $meta = Str::kebab(substr($name, 4));
            if (!empty($this->metas[$meta])) // SE O ATRIBUTO JÁ POSSUIR VALOR
                $this->metas[$meta] .= " {$arguments[0]}"; // O NOVO VALOR SERÁ CONCATENADO NO FIM
            else
                $this->metas[$meta] = $arguments[0]; // ARMAZENA O ATRIBUTO E SEU VALOR

            return $this; // RETORNA O PRÓPRIO PLUGIN
        } else
            // CASO O PREFIXO DO MÉTODO CHAMADO NÃO SEJA attr UM ERRO DE MÉTODO INEXISTENTE É LANÇADO
            throw new LaraHtmlMethodNotFoundException("Method $name does not exist!");
    }

    /**
     * Define atributos de tag substituindo os valores da configuração.
     *
     * @param $name
     * @param $value
     * @return $this
     * @throws LaraHtmlMethodNotFoundException
     */
    public function __set($name, $value)
    {
        $prefix = substr($name, 0, 4); // ARMAZENA OS 4 PRIMEIROS CARACTERES

        // SE O PREFIXO DO COMANDO INVOCADO FOR attr ENTÃO NO ATRIBUTO SERÁ CRIADO
        if ($prefix == 'attr') {
            // PULA OS 4 CARACTERES DO PREFIXO E ARMAZENA O RESTANTE EM CAIXA BAIXA
            $attribute = Str::kebab(substr($name, 4));
            $this->attributes[$attribute] = $value; // ARMAZENA O ATRIBUTO E SEU VALOR

            return $this; // RETORNA O PRÓPRIO PLUGIN
        } elseif ($prefix == 'meta') {
            // PULA OS 4 CARACTERES DO PREFIXO E ARMAZENA O RESTANTE EM CAIXA BAIXA
            $meta = Str::kebab(substr($name, 4));
            $this->metas[$meta] = $value; // ARMAZENA O ATRIBUTO E SEU VALOR

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
     * @return array
     */
    public function getAttr()
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    public function getMeta()
    {
        return $this->metas;
    }

    /**
     * Se o meta atributo já existir o próximo valor será concatenado com um espaço no início.
     *
     * @param $meta
     * @param $value
     */
    public function addMeta($meta, $value)
    {
        if (isset($this->metas[$meta]))
            $this->metas[$meta] .= trim(" $value");
        else
            $this->metas[$meta] = $value;
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
     * @param array|null $storeData
     * @return string
     */
    protected function getHtmlElements(?array $elements, ?array $storeData = null): string
    {
        $html = '';
        $elements = $elements ?: [];
        $total = count($elements);
        foreach ($elements as $idx => $e) {
//            dd("getHtmlPlugins: " . get_class($this) . ' - ' . get_class($plugin));
            $html .= $e->getHtml([
                'total' => $total,
                'idx' => $idx,
                'storeData' => $storeData,
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
