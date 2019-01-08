<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:41
 */

namespace PhpHtml\Plugins;

use PhpHtml\Abstracts\Plugins\ContainerRowAbstract;
use PhpHtml\Finals\Row;

/**
 * Class Text
 * @package PhpHtml\Plugins
 */
class Form extends ContainerRowAbstract
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
        parent::__construct(new Row());

        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        $html = parent::getHtmlPlugins();

        return
            "<form action='$this->action'>$html</form>";
    }
}