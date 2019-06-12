<?php

/**
 * Colunas
 */

namespace LaraHtml\Grid;


use LaraHtml\Abstracts\General;
use LaraHtml\Traits\StoresRows;
use LaraHtml\Grid\Plugin\General as Plugin;

/**
 * Class Col
 * @package LaraHtml\Grid
 */
final class Col extends General
{

    use StoresRows;

    /**
     * @var null|array
     */
    private $plugins = null;

    public function __construct(Row $row)
    {
        parent::__construct();

        $this->setRow($row);
    }

    public function countPlugins()
    {
        return count($this->plugins ?: []);
    }

    /**
     * Adiciona plugin a coluna.
     *
     * @param Plugin $plugin
     * @return Plugin
     */
    public function newPlugin(Plugin $plugin)
    {
        $plugin->setCol($this);
        return $this->plugins[] = $plugin;
    }

    protected function changePluginRows() {
        $this->newRow(new Row);
        $col = new Col($this->currentRow); // CRIANDO COLUNA
        $this->currentRow->newCol($col);
        $col->newPlugin($this->plugins[0]);
        $this->plugins = null;
    }

    /**
     * Retorna o HTML da classe.
     *
     * @return string
     */
    public function getHtml(): string
    {
        $data = [
            'class' => $this->config('css.col.md'),
            'elements' => $this->getHtmlElements($this->plugins ?: $this->rows),
            'attributes' => $this->getAttributesTag(),
        ];

        return $this->getView('col', $data);
    }

}
