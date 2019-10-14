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
    private $storeData = [];

    private $attrFind = 'name';

    private $attrValue = 'value';

    /**
     * Armazena os dados par atribuição em massa.
     *
     * @param array|null $data
     * @return $this
     */
    public function setData(?array $data = []): self
    {
        $this->storeData = $data;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getData(): array
    {
        return $this->storeData;
    }

    /**
     * Define a configuração de qual atributo será utilizado para localizar o elemento.
     *
     * @param string $key
     * @return $this
     */
    public function setDataAttrFind(string $key): self
    {
        $this->attrFind = $key;
        return $this;
    }

    /**
     * Define a configuração de qual atributo será utilizado para receber o valor.
     *
     * @param string $key
     * @return $this
     */
    public function setDataAttrValue(string $key): self
    {
        $this->attrValue = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataAttrFind(): string
    {
        return $this->attrFind;
    }

    /**
     * @return string
     */
    public function getDataAttrValue(): string
    {
        return $this->attrValue;
    }

}
