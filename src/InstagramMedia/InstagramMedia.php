<?php
namespace InstagramMedia;

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
    const URL = 'https://www.instagram.com/';

    /**
     * Nome da conta de usuário para obter as mídias
     * @access private
     * @var string
     */
    private $userId = '';

    /**
     * Construtor da classe
     * @param string $userId
     */
    public function __construct($userId = '')
    {
        $this->setUserId($userId);
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
     *         'qtd_comments' => Quantidade de comentários
     *     ]
     */
    public function getMedia($qtd = 20)
    {
        $data = json_decode($this->getJsonMedia());
        if (!isset($data->items)) {
            return [];
        }
        $retorno = [];
        $i = 0;
        foreach ($data->items as $post) {
            $retorno[] = [
                'link' => $post->link,
                'type' => $post->type,
                'thumb' => $post->images->thumbnail->url,
                'low' => $post->images->low_resolution->url,
                'std' => $post->images->standard_resolution->url,
                'qtd_likes' => $post->likes->count,
                'qtd_comments' => $post->comments->count,
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
        curl_setopt($ch, CURLOPT_URL, self::URL . $this->getUserId() . '/media');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
