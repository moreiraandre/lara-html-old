<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 14/12/18
 * Time: 14:37
 */

class GetHtmlRecursive
{

    private $rows = [];
    private $html = '';

    public function getHtml($rowsCurrent = null)
    {
        $rowsCurrent = $rowsCurrent ?: $this->rows;

        foreach ($rowsCurrent as $row) {
            foreach ($row->getCols() as $col) {
                foreach ($col->getPlugins as $plugin) {
                    if ($plugin instanceof Row)
                        $this->getHtml();
                    else
                        $this->html .= $plugin->getHtml();
                }
            }
        }
    }

}