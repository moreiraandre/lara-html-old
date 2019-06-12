<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:41
 */

namespace LaraHtml\Plugins;


use LaraHtml\Grid\Plugin\Container;

/**
 * Class Text
 * @package LaraHtml\Plugins
 */
class Form extends Container
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
        parent::__construct();

        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        $data = [
            'action' => $this->action,
            'elements' => $this->getHtmlElements($this->getRows()),
            'attributes' => $this->getAttributesTag(),
        ];

        return $this->getView('form', $data);
    }
}
