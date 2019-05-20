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
$form = $this->phpHtml->form('/');
$form->addText('apelido');
```
> O exemplo acima adiciona o plugin `text` ao plugin `form`.

```php
class PessoasForm
{
    public function run(PhpHtml $phpHtml)
    {
        $form = $phpHtml->form('/');
        $form->addText('nome');
        $containerEndereco = $form->addText('endereco');
        $containerEndereco->addText('numero');
        $containerEndereco->addText('bairro');
        $containerEndereco->addUF('uf');
        $containerEndereco->addCidade('cidade');
        $form->addDate('dt_nasc');
        $containerDocs = $form->addCpf('cpf');
        $containerDocs->addText('rg');
    }
}
```

```html
<form>
    <input name="nome">
    <div class="row">
        <input name="endereco">
        <input name="numero">
        <input name="bairro">
        <input name="uf">
        <input name="cidade">
    </div>
    <input name="dt_nasc">
    <div class="row">
        <input name="cpf">
        <input name="rg">
    </div>
</form>
```