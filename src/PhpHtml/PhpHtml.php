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
use PhpHtml\Managers\Layout;

/**
 * Class PhpHtml
 * @package PhpHtml
 */
class PhpHtml
{

    /**
     * @var array
     */
    private $objManagers = [];

    /**
     * @return Form
     */
    public function form()
    {
        return $this->objManagers[] = new Form();
    }

    /**
     * @return Layout
     */
    public function layout()
    {
        return $this->objManagers[] = new Layout();
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