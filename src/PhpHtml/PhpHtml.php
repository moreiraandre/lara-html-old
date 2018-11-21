<?php
/**
 * Prove acesso as classes gestoras de plugins.
 *
 * User: andre
 * Date: 20/11/18
 * Time: 23:52
 */

namespace PhpHtml;


use PhpHtml\Managers\Form;
use PhpHtml\Managers\Layout;

class PhpHtml
{

    private $objManagers = [];

    public function form()
    {
        return $this->objManagers[] = new Form();
    }

    public function layout()
    {
        return $this->objManagers[] = new Layout();
    }



    public function getHtml()
    {
        $html = '';
        foreach ($this->objManagers as $manager)
            foreach ($manager->getPlugins() as $plugin)
//                $html .= $plugin->getHtml();
                $html .= $this->layout()->column($plugin->getHtml(), 12/2)->getHtml();

        return "<form><div class='row'>$html</div></form>";
        return "<div class='row'><div class='col-md-12'><form>$html</form></div></div>";
    }

}