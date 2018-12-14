<?php
/**
 * Created by: André Moreira
 * Date: 14/12/18
 * Time: 23:43
 */

namespace PhpHtml\Plugins\Grid;

final class GetItems
{
    private $items = [];

    /**
     * GetItems constructor.
     * @param array $items
     */
    public function __construct(array &$items)
    {
        $this->items = $items;
    }

    /**
     * @return mixed|null
     */
    public function first()
    {
        return count($this->items) > 0 ? $this->items[0] : null;
    }

    /**
     * @param int $index
     * @return mixed|null
     */
    public function index(int $index)
    {
        return isset($this->items[$index]) ? $this->items[$index] : null;
    }

    /**
     * @return mixed|null
     */
    public function last()
    {
        return count($this->items) > 0 ? end($this->items) : null;
    }

}