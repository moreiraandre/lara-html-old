<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:41
 */

namespace PhpHtml\Plugins;


use PhpHtml\Abstracts\PluginAbstract;
use PhpHtml\Plugins\Grid\Col;

/**
 * Class Text
 * @package PhpHtml\Plugins
 */
//class Form extends PluginAbstract
class Form extends Col
{
    /**
     * @var string
     */
    private $action;

    /**
     * Form constructor.
     * @param string $action
     */
    public function __construct(string $action)
    {
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        $html = parent::getHtml();

        return
            "<form action='$this->action'>$html</form>";
    }
}