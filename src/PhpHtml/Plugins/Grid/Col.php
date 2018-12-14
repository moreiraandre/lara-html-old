<?php
/**
 * Created by: André Moreira
 * Date: 21/11/18
 * Time: 02:06
 */

namespace PhpHtml\Plugins\Grid;


use PhpHtml\Interfaces\PluginOutHtmlInterface;
use PhpHtml\Traits\CreatePluginTrait;

/**
 * Class Col
 * @package PhpHtml\Plugins
 */
final class Col implements PluginOutHtmlInterface
{
    use CreatePluginTrait;

    /**
     * @var Row Referência da linha
     */
    private $row;

    /**
     * Retorna a referência da linha
     *
     * @return Row
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * Guarda a referência da linha
     *
     * @param Row $row
     */
    public function setRow(Row $row)
    {
        $this->row = $row;
    }

    /**
     * Retorna o array que armazena os plugins
     *
     * @return array
     */
    public function getPlugins()
    {
        return $this->plugins;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        $html = '';
        foreach ($this->plugins as $plugin)
            $html .= $plugin->getHtml();

        return "<div class='col-sm'>$html</div>";
    }

}
