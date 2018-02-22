# InstagramMedia

[![Build Status](https://api.travis-ci.org/gildonei/instagrammedia.png)](https://travis-ci.org/gildonei/instagrammedia)
[![Latest Stable Version](https://poser.pugx.org/gildonei/instagrammedia/v/stable.svg)](https://packagist.org/packages/gildonei/instagrammedia)

Permite ao usuário obter as imagens do Instagram após o registro da App dentro
do instagram. - https://www.instagram.com/developer/

### Versão PHP
5.6+

### Exemplo de uso
```
<?php
// Pode ser obtido em: https://smashballoon.com/instagram-feed/find-instagram-user-id/
$userId = 'self';
// Tutorial de como obter o access token - https://blog.difluir.com/2016/06/como-criar-um-aplicativo-e-pegar-o-access-token-no-instagram/
$accessToken = 'xxxxxxxxxx.xxxxxxx.xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
$objInstagram = new InstagramMedia\InstagramMedia($userId, $accessToken);
$data = $objInstagram->getMedia(10); // Máximo de 20
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
