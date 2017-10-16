# GoogleUrlShortener
Classe PHP com objetivo de facilitar a utilização do serviço [Url Shortener do Google](https://goo.gl/)

## O que você precisa

Você precisa gerar uma “API key” do Google. Para isso acesse [Google Developers](https://developers.google.com/url-shortener/v1/getting_started) e clique no botão “Get a Key”.

## Como utilizar

A classe tem basicamente dois métodos que você irá utilizar:

**encurtar($url)**
Este método recebe como parâmetro uma URL de um site e retorna a URL encurtada pelo Google.

**urlOriginal($url)**
Este método recebe como parâmetro uma URL encurtada e retorna a URL original.

## Exemplo
```
<?php

include "GoogleUrlShortener.php";

$google = new GoogleUrlShortener('SUA_API_KEY_AQUI');

$url_encurtada = $google->encurtar("https://pt.wikipedia.org/wiki/PHP");

echo "URL ENCURTADA: $url_encurtada\n";

$url_original = $google->urlOriginal($url_encurtada);

echo "URL ORIGINAL: $url_original";

```
