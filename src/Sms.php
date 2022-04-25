
<?php

require 'vendor/autoload.php';
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class Sms {

    private string $apiKey;
    private string $url;

    /**
     * 
     */
    public function __construct(string $apiKey, string $url) {
        $this->apiKey = $apiKey;
        $this->url = $url;
    }

    /**
     * @param string $message
     * @param string $to 
     * should to be int?
     */
    public function send( string $message, string $to)
    {
        // if ( empty( $to ) ) {
        //     // Throw receiver error
        // }
        try {
            $client = new Client();
            $payload = [];
            if ( ! empty($message)) {
                $payload = ['message' => $message];
            }
            $payload = array_merge( $payload, [ 'to' => $to ] );
            $headers = ['Authorization' => $this->apiKey];
            $headers = array_merge ( $headers, ['Content-Type' => 'application/json']);

            $request = new Request('POST', $this->url, $headers, json_encode($payload));

            $response = $client->send($request);

            return $response->getBody()->getContents();
        } catch (GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            return $response->getBody()->getContents();
        }
        
    }
}

?>