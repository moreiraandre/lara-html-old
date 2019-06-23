<?php

if (!function_exists('lhtml')) {
    /**
     * Retorna o HTML
     *
     * @param $customScreen
     * @return string
     * @throws Exception
     */
    function lhtml($customScreen)
    {
        if (!$customScreen instanceof LaraHtml\Grid\Screen)
            throw new Exception('Parameter is not an instance of LaraHtml\Grid\Screen!');

        $customScreen->row();
        $customScreen->run();

        return $customScreen->getHtml();
    }
}
