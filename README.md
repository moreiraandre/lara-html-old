# Problema
Perda de tempo com edição HTML pré-definida.

# Contexto
Para escrita do HTML devem ser criados arquivos _views_, o problema é que isso 
causa reescrita de HTML pré-definido ([Bootstrap](http://getbootstrap.com/)) 
cujas futuras mudanças no padrão do HTML devem ser alteradas em cada arquivo 
_view_ aumentando assim o grau de dificuldade na manutenção pois a marcação HTML 
torna o conteúdo do arquivo grande e menos legível do que usar uma padrão para 
abstração de métodos para geração do HTML.

# Solução
Criar conjunto de classes PHP para gerar HTML pré-definido passando apenas 
parâmetros necessários para geração dinâmica.

# Plugins recebendo plugins
É padrão utilizar `add` antes do nome do plugin para adicioná-lo a outro.
```php
$form = $this->phpHtml->addForm('/');
$form->addText('apelido');
```
> O exemplo acima adiciona o plugin `text` ao plugin `form`.

```php
class PessoasForm
{
    public function run(PhpHtml $phpHtml)
    {
        $form = $phpHtml->addForm('/');
        $form->addText('nome');
        $colEndereco = $form->addText('endereco')->getCol();
        $colEndereco->addText('numero');
        $colEndereco->addText('bairro');
        $colEndereco->addUF('uf');
        $colEndereco->addCidade('cidade');
        $form->addDate('dt_nasc');
        $containerDocs = $form->addCpf('cpf')->getCol();
        $containerDocs->addText('rg');
        $form->addSubmit('Salvar');
    }
}
```

```html
<form method="POST" action="/">
    <div class="row">
        <div class='form-group'>
            <label>Nome</label>
            <input class="form-control form-control-sm" name="nome">
        </div>
        <div class="col-md-12">
            <div class='form-group'>
                <label>Endereco</label>
                <input class="form-control form-control-sm" name="endereco">
            </div>
            <div class='form-group'>
                <label>Numero</label>
                <input class="form-control form-control-sm" name="numero">
            </div>
            <div class='form-group'>
                <label>Bairro</label>
                <input class="form-control form-control-sm" name="bairro">
            </div>
            <div class='form-group'>
                <label>Uf</label>
                <input class="form-control form-control-sm inputUf" name="uf">
            </div>
            <div class='form-group'>
                <label>Cidade</label>
                <input class="form-control form-control-sm inputCidade" name="cidade">
            </div>
        </div>
    </div>
    <div class='form-group'>
        <label>Data nascimento</label>
        <input class="form-control form-control-sm" name="dt_nasc">
    </div>
    <div class="row">
        <div class='form-group'>
            <label>Cpf</label>
            <input class="form-control form-control-sm inputCpf" name="cpf">
        </div>
        <div class='form-group'>
            <label>Rg</label>
            <input class="form-control form-control-sm inputRg" name="rg">
        </div>
    </div>
    <div class="row">
        <div class='form-group'>
            <button type="submit">Salvar</button>
        </div>
    </div>
</form>
```