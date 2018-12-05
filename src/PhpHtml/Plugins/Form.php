<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:41
 */

namespace PhpHtml\Plugins;


use PhpHtml\Abstracts\PluginAbstract;

/**
 * Class Text
 * @package PhpHtml\Plugins
 */
class Form extends PluginAbstract
{
    private
        /**
         * @var array
         */
        $items = [],
        /**
         * @var string
         */
        $action;

    /**
     * Form constructor.
     * @param string $action
     */
    public function __construct(string $action)
    {
        $this->action = $action;
    }

    public function __call($name, $arguments)
    {
        if (substr($name, 0, 3) == 'add') {
            $name = substr($name, 3);
            $class = "PhpHtml\Plugins\\$name";
            $obj =  new $class(...$arguments);
            return $this->items[] = $obj;
        } else
            parent::__call($name, $arguments);
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        $html = '';
        foreach ($this->items as $item)
            $html .= $item->getHtml();

        return
            "<form>
                <div class='form-row'>$html</div>
            </form>";
    }
}