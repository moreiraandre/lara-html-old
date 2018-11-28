<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:43
 */

namespace PhpHtml\Plugins\Layout;


use PhpHtml\Interfaces\PluginInterface;
use Symfony\Component\Debug\Exception\FatalThrowableError;

class Row implements PluginInterface
{
    private $columns = [];

    public function addCol(PluginInterface $plugin)
    {
        return $this->columns[] = $plugin;
    }

    public function getHtml(): string
    {
        $html = $htmlRow = ''; // INICIANDO VARIAVEIS DO HTML GERAL E DE CADA LINHA
        $countCol = 0; // INICIANDO CONTADOR DE COLUNA
        foreach ($this->columns as $col) {
            // CASO O TOTAL DE COLUNAS SEJA 12 O HTML DA LINHA É ADICIONADO AO HTML GERAL E NOVA LINHA É INICIADA
            if ($countCol == 12) {
                $countCol = 0;
                $html .= "<div class='row'>$htmlRow</div>";
                $htmlRow = '';
            }
            $countCol++;
        }
        if ($countCol > 0)
            $html .= "<div class='row'>$htmlRow</div>";

        return $html;
    }
}