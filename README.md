# OpenGatryAPI
API que coleta as promoções do site Gatry (http://www.gatry.com)

Propriedades do JSON
------------------
- type: Fala se é um *Promocao* ou *Comentario*
- totalResults: Número de resultados retornados
- results: Lista uma array das últimas promoções postadas ou as últimas promoções *comentadas*
  - id: Código único da promoção
  - name: Título da promoção
  - price: Preço
  - image: Link da imagem
  - link: Link para o site da promoção
  - userLink: Link de detalhes do úsuário que postou a promoção
  - userImage: Link do avatar do usuário
  - store: Nome da loja que o produto esta sendo anunciado 
  - likes: Quantidade de likes do produto
  - comments: Quantidade de comentários do produto
  - date: Data de postagem da promoção
  - moreinfo: Mais informações da promoção, link para o site do Gatry.

Como usar?
------------------
Coloque a classe no seu arquivo PHP

	include_once "GatryAPI.class.php";

Inicialize o objeto

	$gatry = new Gatry\GatryAPI;


Promoções
------------------
- Para exbir o JSON com as últimas 9 promoções basta usar o argumento `onlyPromocao` e setar como `true`
  - `http://localhost:8888/gatry/index.php?onlyPromocao=true`
- As mesmas informações também podem ser acessadas usando o argumento `qtde` com o valor 0
  - `http://localhost:8888/gatry/index.php?onlyPromocao=true&qtde=0`
- Para poder coletar todas as promoções igual o `infinite scroll` presente no site, lendo as demais promoções incremente a `qtde` de 9 em 9. Ex.: 9, 18, 27, 36...
  - `http://localhost:8888/gatry/index.php?onlyPromocao=true&qtde=9`

Comentários
------------------
- Para pegar os últimos comentários basta alterar o valor do `onlyPromocao` para `false`
  - `http://localhost:8888/gatry/index.php?onlyPromocao=false` ou `http://localhost:8888/gatry/index.php?onlyPromocao=false&qtde=0`
- Para ler os demais cometários fazer exatamente igual faria para ler mais promoções

ToDo
------------------
- Coletar as informações da área "Avaliações"
