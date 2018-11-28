<?php
/**
 * Prove acesso as classes gestoras de plugins.
 *
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:52
 */

namespace PhpHtml;


use PhpHtml\Managers\Form;
//use PhpHtml\Managers\Layout;

use PhpHtml\Managers;
use PhpHtml\Plugins\Layout\Col;
use PhpHtml\Plugins\Layout\Row;


/**
 * Class PhpHtml
 * @package PhpHtml
 */
class PhpHtml
{
    private $plugins = [];

    public function row()
    {
        return $this->plugins[] = new Row();
    }

    public function col()
    {
        return $this->plugins[] = new Col();
    }

    public function plugin()
    {
        return $this->plugins[] = new Col();
    }


    /**
     * @return string
     */
    public function getHtml()
    {
        $html = '';
        $countCol = 0;
        $row = $this->layout()->row();
        // PERCORRE TODOS OS GESTOES DE PLUGINS
        foreach ($this->objManagers as $manager) {
            // PERCORRE TODOS OS PLUGINS DO GESTOR
            foreach ($manager->getPlugins() as $plugin) {
                $row->addCol($plugin);
//                exit(var_dump($row->getHtml()));

//                $html .= $this->layout()->col($plugin->getHtml(), 12 / 2)->getHtml();
            }
        }

        return "<form>{$row->getHtml()}</form>";
        return "<form><div class='row'>$html</div></form>";
    }

}