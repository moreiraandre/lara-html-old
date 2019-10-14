<?php

namespace App\Screens;

use App\User;
use LaraHtml\Grid\Screen;

class PersonForm
{

    /*
     * Sobrescrevendo a configuração.
     */
//    public $template = '';
//    public $extendView = '';

    /**
     * @var null|mixed Dados para a tela.
     */
    private $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    /**
     * Escreva aqui os elementos da sua tela.
     *
     * @param Screen $screen
     */
    public function run(Screen $screen)
    {
        // COL ESQ
        $colNome = $screen->addText('nome')->getCol();
        $colNome->addText('endereco', 'Endereço');
        $colNome->row();
        $colNome->addText('dt_nasc', 'Data de nascimento');
        // COL DIR
        $colCpf = $screen->addText('cpf')->getCol();
        $colCpf->row();
        $colCpf->addText('rg');
        $colCpf->row();
        $colCpf->addText('tit_eleitor');
        $colCpf->row();
        $colCpf->addText('certidao_nasc');
        $colCpf->addText('certidao_nasc_ano');
        $screen->row();
        $screen->addButton('Salvar');
    }
}
