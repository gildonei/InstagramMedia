<?php
namespace InstagramMedia;

use Exception;

/**
 * Classe simples para obter as postagens para um determinado perfil público no
 * instagram e retornar os dados básicos da postagem
 *
 * @author Gildonei Mendes Anacleto Junior
 * @version 1.0
 * @license The MIT License (MIT)
 */
class InstagramMedia
{
    /**
     * URL do instagram
     * @access public
     * @var string
     */
    const URL = 'https://api.instagram.com/v1/users/';

    /**
     * Nome da conta de usuário para obter as mídias
     * @access private
     * @var string
     */
    private $userId = '';

    /**
     * Access Token para acesso à API do Instagram
     * @access private
     * @var string
     */
    private $accessToken = '';

    /**
     * Construtor da classe
     * @param string $userId
     * @param string $accessToken
     * @return \InstagramMedia
     */
    public function __construct($userId = '', $accessToken = '')
    {
        if (!empty($userId)) {
            $this->setUserId($userId);
        }
        if (!empty($userId)) {
            $this->setAccessToken($accessToken);
        }
    }

    /**
     * @access public
     * @param string $userId
     * @return \InstagramMedia
     * @throws Exception
     */
    public function setUserId($userId = '')
    {
        if (empty($userId)) {
            throw new Exception(__('ID do usuário não informado!'));
        }
        $this->userId = $userId;

        return $this;
    }

    /**
     * Retorna o nome de usuário o qual se quer obter os posts
     * @access public
     * @return string
     * @throws Exception
     */
    public function getUserId()
    {
        if (empty($this->userId)) {
            throw new Exception('Usuário não informado');
        } else {
            return $this->userId;
        }
    }

    /**
     * @access public
     * @param string $accessToken
     * @return \InstagramMedia
     * @throws Exception
     */
    public function setAccessToken($accessToken = '')
    {
        if (empty($accessToken)) {
            throw new Exception(__('Access Token não informado!'));
        }
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Retorna o nome de usuário o qual se quer obter os posts
     * @access public
     * @return string
     * @throws Exception
     */
    public function getAccessToken()
    {
        if (empty($this->accessToken)) {
            throw new Exception('Access Token não informado');
        } else {
            return $this->accessToken;
        }
    }

    /**
     * Retorna a lista de posts que o usuário informado possui contendo também
     * os likes, comentários e dados relacionados à postagem
     *
     * @access public
     * @param integer $qtd Quantidade de mídias a serem retornada
     * @return array
     *    [
     *         'link' => URL do Post
     *         'type' => Tipo do Post,
     *         'thumb' => URL da imagem do thumbnail,
     *         'low' => URL da imagem em baixa resolução
     *         'std' => URL da imagem em resolução padrão
     *         'qtd_likes' => Quantidade de likes
     *         'qtd_comments' => Quantidade de comentários,
     *         'caption' => Texto do post
     *     ]
     */
    public function getMedia($qtd = 20)
    {
        $data = json_decode($this->getJsonMedia());
        if (!isset($data->data)) {
            return [];
        }
        $retorno = [];
        $i = 0;
        foreach ($data->data as $post) {
            $retorno[] = [
                'link' => $post->link,
                'type' => $post->type,
                'thumb' => $post->images->thumbnail->url,
                'low' => $post->images->low_resolution->url,
                'std' => $post->images->standard_resolution->url,
                'qtd_likes' => $post->likes->count,
                'qtd_comments' => $post->comments->count,
                'caption' => (isset($post->caption->text)) ? $post->caption->text : ''
            ];
            $i++;
            if ($i >= $qtd) {
                break;
            }
        }
        return $retorno;
    }

    /**
     * Efetua a chamada à URL
     * @access private
     * @return string JSON com os dados dos posts
     */
    private function getJsonMedia()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::URL . $this->getUserId() . '/media/recent/?access_token=' . $this->getAccessToken());
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
