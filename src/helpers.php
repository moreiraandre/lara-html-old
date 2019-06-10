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
            throw new Exception('Parameter is not an object!');

        $firstRow = new LaraHtml\Finals\Row;
        $customScreen->run($firstRow);

        return $customScreen->getHtml();
    }
}
