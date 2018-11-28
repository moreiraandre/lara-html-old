<?php
/**
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:39
 */

namespace PhpHtml\Interfaces;


use PhpHtml\PhpHtml;

interface ScreenInterface
{
    /**
     * Método onde será escrito a lógica de montagem da tela.
     *
     * @return PhpHtml Classe que provê acesso as classes gestoras de plugins.
     */
    public function run();
}