<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:41
 */

namespace LaraHtml\Plugins;

use LaraHtml\Abstracts\PluginContainerAbstract;

/**
 * Class Text
 * @package LaraHtml\Plugins
 */
class Form extends PluginContainerAbstract
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
        $html = parent::getHtmlPlugins();

        $search = [
            '#ACTION#',
            '#HTML#',
        ];
        $replace = [
            $this->action,
            $html,
        ];

        return $this->getTemplate('Form', $search, $replace);
    }
}
