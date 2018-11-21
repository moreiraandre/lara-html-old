<?php
/**
 * Responsável por gerar o HTML geral da tela.
 *
 * User: andre
 * Date: 20/11/18
 * Time: 23:37
 */

namespace PhpHtml\Abstracts;


use PhpHtml\Interfaces\ScreenInterface;
use PhpHtml\PhpHtml;

abstract class ScreenAbstract implements ScreenInterface
{

    protected $phpHtml;

    public function __construct(PhpHtml $phpHtml)
    {
        $this->phpHtml = $phpHtml;
    }

    /**
     * Gera e retorna o HTML da classe filha.
     *
     * @return string
     */
    public final function getHtml(): string
    {
        static::run();
        return $this->phpHtml->getHtml();
    }

    public function __toString()
    {
        return 'Tá aqui';
    }

}