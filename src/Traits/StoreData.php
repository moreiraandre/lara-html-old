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

    private $attrFind = 'name';

    private $attrValue = 'value';

    /**
     * Armazena os dados par atribuição em massa.
     *
     * @param array|null $data
     * @return $this
     */
    public function setData(array $data = null)
    {
        $this->storeData = $data;
        return $this;
    }

    /**
     * Define a configuração de qual atributo será utilizado para localizar o elemento e qual atributo será utilizado
     * para receber o valor.
     *
     * @param string $attrFind
     * @param string $attrValue
     * @return $this
     */
    public function setConfigData(string $attrFind, string $attrValue)
    {
        $this->attrFind = $attrFind;
        $this->attrValue = $attrValue;
        return $this;
    }

    /**
     * @return string
     */
    public function getAttrFind(): string
    {
        return $this->attrFind;
    }

    /**
     * @return string
     */
    public function getAttrValue(): string
    {
        return $this->attrValue;
    }

    /**
     * @return array|null
     */
    protected function getStoreData()
    {
        return $this->storeData;
    }

}
