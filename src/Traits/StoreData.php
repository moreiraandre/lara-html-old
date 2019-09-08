<?php

/**
 * Define "dados em massa" no 'plugin container' para um grupo de plugins.
 */

namespace LaraHtml\Traits;

trait StoreData
{

    /**
     * @var null|array
     */
    private $storeData = null;

    public function setData(array $data = null, array $config = null)
    {
        $this->storeData = $data;
    }

    protected function getStoreData()
    {
        return $this->storeData;
    }

}
