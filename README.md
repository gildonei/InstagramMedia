# InstagramMedia [![Build Status](https://api.travis-ci.org/gildonei/instagrammedia.png)](https://travis-ci.org/gildonei/instagrammedia)
Retorna os posts de um perfil público do instagram

### Versão PHP
5.6+

### Exemplo de uso
```
<?php
$userId = 'perfil-do-instagram';
$objInstagram = new InstagramMedia($userId);
$data = $objInstagram->getMedia(10);
/*
Retorna um array com os dados
[0] => [
       'link' => URL do Post
       'type' => Tipo do Post,
       'thumb' => URL da imagem do thumbnail,
       'low' => URL da imagem em baixa resolução
       'std' => URL da imagem em resolução padrão
       'qtd_likes' => Quantidade de likes
       'qtd_comments' => Quantidade de comentários
    ]
]...
*/
?>
```
### Composer

Adicione `{ "gildonei/instagrammedia": "dev-master" }` no require do seu projeto.

### License

* MIT License
