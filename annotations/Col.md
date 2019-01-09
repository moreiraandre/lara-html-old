# Col
## Armazenando um plugin
- Não utiliza a classe pai `ContainerRows`
- Toda lógica é específica da classe

## Armazenando Linhas
Toda lógica acontece na classe pai

## Diferenciação de plugin _único_ para _linhas_
caso a variável `private $plugin` estiver _nula_ então a classe está armazenando linhas, caso contrário está armazenando
 o plugin.