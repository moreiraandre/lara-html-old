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
        if (!is_object($customScreen))
            throw new \Exception('Parameter is not an object!');

        $screen = new \LaraHtml\LaraHtmlScreen;
        $customScreen->run($screen);

        return $screen->getHtml();
    }
}
