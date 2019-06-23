<?php

use LaraHtml\Grid\Screen;

if (!function_exists('lhtml')) {
    /**
     * Retorna o HTML
     *
     * @param $customScreen
     * @return string
     * @throws Exception
     */
    function lhtml(Object $customScreen)
    {
        $screen = new Screen; // CRIANDO NOVA TELA
        $screen->row(); // ADICIONANDO LINHA INICIAL NA TELA
        $customScreen->run($screen); // POPULANDO TELA COM PLUGINS DEFINIDOS PELO DEV

        return $screen->getHtml(); // RETORNANDO HTML DA TELA
    }
}
