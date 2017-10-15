<?php

/**
* Classe criada para facilitar a utilização da API Google URL Shortener  
*
* @author Eduardo Cintra <eduardocintramaia@gmail.com>
* @version 0.1
*/

class GoogleUrlShortener{

	private $api_key;
	private $url_api = "https://www.googleapis.com/urlshortener/v1/url";


	public function __construct($api_key){
		$this->api_key = $api_key;
	}

    /**
     * Realiza um post utilizando CURL
     *
     * @param     array $data
     * @return    string JSON
     */
	protected function post($data = null){

		try {
			$ch = curl_init($this->url_api."?key=".$this->api_key);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
				'Content-Type: application/json',                                                                                
				'Content-Length: ' . strlen($data))                                                                       
			);                
			$result = curl_exec($ch);
			if ($result == FALSE)
				throw new Exception(curl_error($ch), curl_errno($ch));
		
			curl_close($ch);
		} catch(Exception $e) {

			trigger_error(sprintf('Curl failed with error #%d: %s',$e->getCode(), $e->getMessage()),E_USER_ERROR);
		
		}

		return $result;

	}

    /**
     * Realiza um requisição HTTP GET utilizando CURL
     *
     * @param     string $url
     * @return    string JSON
     */
	protected function get($url){

		try {
			$ch = curl_init($this->url_api."?key=".$this->api_key."&shortUrl=".$url);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);     
			$result = curl_exec($ch);
			if ($result == FALSE)
				throw new Exception(curl_error($ch), curl_errno($ch));

			curl_close($ch);
		
		} catch(Exception $e) {

			trigger_error(sprintf('Curl failed with error #%d: %s',$e->getCode(), $e->getMessage()),E_USER_ERROR);
		
		}

		return $result;

	}

    /**
     * Método público utilizado para encurtar uma URL
     *
     * @param     string $url
     * @return    string JSON
     */
	public function encurtar($url){

		$data = json_encode(["longUrl"=>$url]);
		$result = $this->post($data);
		if($result){
			$result = (array) json_decode($result);
			if(isset($result['id']))
				return $result['id'];
		}
        
	}

	/**
	 * Método público utilizado para reverter o processo de encurtamento de uma URL, ou seja, retorna a URL original a partir de uma URL encurtada
	 *
	 * @param     string $url
	 * @return    string JSON
	 */
	public function urlOriginal($url){

		$result = $this->get($url);
		if($result){
			$result = (array) json_decode($result);
			if(isset($result['longUrl']))
				return $result['longUrl'];
		}

	}

}