<?php
/**
 * Responsável por gerar o HTML geral da tela.
 *
 * Created by: André Moreira
 * Date: 20/11/18
 * Time: 23:37
 */

namespace PhpHtml\Abstracts;

use PhpHtml\Interfaces\ScreenInterface;
use PhpHtml\PhpHtml;

/**
 * Class ScreenAbstract
 * @package PhpHtml\Abstracts
 */
abstract class ScreenAbstract implements ScreenInterface
{

    /**
     * @var PhpHtml
     */
    protected $phpHtml;

    /**
     * ScreenAbstract constructor.
     * @param PhpHtml $phpHtml
     */
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

}