<?php
/**
 * Created by: André Moreira
 * Date: 21/11/18
 * Time: 02:06
 */

namespace PhpHtml\Finals;

use PhpHtml\Abstracts\Plugins\ContainerRowAbstract;

/**
 * Class Col
 * @package PhpHtml\Plugins
 */
final class Col extends ContainerRowAbstract
{
    /**
     * Col constructor.
     * @param Row $row Linha mãe
     */
    public function __construct(Row $row)
    {
        $this->setRow($row);
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        $html = $this->getHtmlPlugins();

        return "<div class='col-sm'>$html</div>";
    }
}
