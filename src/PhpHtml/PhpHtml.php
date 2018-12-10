<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:52
 */

namespace PhpHtml;

use PhpHtml\Errors\PluginNonexistentError;
use PhpHtml\Interfaces\PluginInterface;
use PhpHtml\Plugins\Col;
use PhpHtml\Plugins\Row;

/**
 * Class PhpHtml
 * @package PhpHtml
 */
class PhpHtml
{
    /**
     * @var array
     */
    private $rows = [];

    /**
     * @var Row Linha atual
     */
    private $rowCurrent;

    /**
     * Inicia a linha atual
     *
     * PhpHtml constructor.
     * @param Row $rowCurrent
     */
    public function __construct(Row $rowCurrent)
    {
        $this->rows[] = $this->rowCurrent = $rowCurrent;
    }

    /**
     * Cria plugins dinamicamente pelo nome da classe invocada.
     *
     * @param $name
     * @param $arguments
     * @return PluginInterface
     * @throws \Throwable
     */
    public function __call($name, $arguments)
    {
        if (($this->rowCurrent->totalColumns() == 12)
            or ($name == 'row'))
            $this->rows[] = $this->rowCurrent = new Row();

        if ($name == 'row')
            return $this->rowCurrent;
        else {
            $name = ucfirst($name);
            $class = "PhpHtml\Plugins\\$name";

            try {
                return $this->rowCurrent->addCol($name, $arguments);
            } catch (\Error $e) {
                echo $e->getMessage();
                throw new PluginNonexistentError("Plugin $class does not exist!");
            }
        }
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        $html = '';
        foreach ($this->rows as $row)
            $html .= $row->getHtml();

        return $html;
    }

}