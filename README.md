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