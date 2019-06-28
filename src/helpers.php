<?php

use LaraHtml\Grid\Screen;

if (!function_exists('lhtml')) {
    /**
     * Retorna o HTML.
     *
     * @param $customScreen
     * @return string
     * @throws Exception
     */
    function lhtml(Object $customScreen)
    {
        // Verificando se a função para popular a tela está presente na tela customizada.
        if (!in_array('run', get_class_methods($customScreen)))
            throw new Exception("'Run' function not found!");

        $screen = new Screen($customScreen->template ?? null,
            $customScreen->extendView ?? null); // CRIANDO NOVA TELA
        $screen->row(); // ADICIONANDO LINHA INICIAL NA TELA
        $customScreen->run($screen); // POPULANDO TELA COM PLUGINS DEFINIDOS PELO DEV

        return $screen->getHtml(); // RETORNANDO HTML DA TELA
    }
}
