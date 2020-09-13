<?php
namespace Logdo;

use GuzzleHttp\Client;
use Logdo\Helpers\StringHelper;
use Logdo\Exceptions\LogdoException;

class Logdo {

    // Usage example.
    // Logdo::createInstance('api_token', 'app_id')
    //    ->log('$log')
    //    ->to('backend_base_url')
    //    ->as('type[info,warning,error]');

    // Confirm is the logging was successful
    // $logdo->wasSuccessful() -TRUE/FALSE
    // if FALSE, $logdo->getErrorMessage();

    const INFO = 'info';
    const ERROR = 'error';
    const WARNING = 'warning';
    
    const LOG_URI = '/api/v1/logs/log-it';

    const LOG_STATUS_ACCEPTED = 202;
    const LOG_STATUS_SERVER_ERROR = 500;
    const LOG_STATUS_BAD_REQUEST = 400;
    const LOG_STATUS_UNPROCESSABLE = 422;

    const LOG_LEVELS = [
        self::INFO,
        self::ERROR,
        self::WARNING,
    ];

    private $log;
    private $app_id;
    private $api_token;
    private $was_successful;
    private $backend_base_url;
    private $response_error_message;

    public function __construct($api_token, $app_id)
    {
        $this->api_token = $api_token;
        $this->app_id = $app_id;
    }

    /**
     * Creates a fresh instance for the current logging
     * thats about to happen.
     * 
     * @param String api_token to access the remote 
     *  log server api
     * @param String app_id of the app on the 
     *  remote server
     * 
     * @return Logdo object
     */
    public static function createInstance(string $api_token, string $app_id): Logdo
    {
        $logdo = new Logdo($api_token, $app_id);
        return $logdo;
    }

    /**
     * Set the log to be sent to the remote 
     * server
     * 
     * @param String log to be logged to the 
     *  remote server
     * 
     * @return Logdo object
     */
    public function log(string $log)
    {
        $this->log = $log;
        if (!$this->log) {
            throw new LogdoException('You need to provide the log. See /docs for proper usage', 1);
        }

        return $this;
    }

    /**
     * Set the remote log server base url
     * 
     * @param String backend_base_url of the remote 
     *  logging server. Default is https//logdo.dev cloud
     * 
     * @return Logdo object
     */
    public function to($backend_base_url = 'https://logdo.dev')
    {
        if (!filter_var($backend_base_url, FILTER_VALIDATE_URL)) {
            throw new LogdoException('You need to provide a valid Logdo backend url. See /docs for more.', 1);
        }

        if (StringHelper::endsWith($backend_base_url, '/')) {
            throw new LogdoException('Logdo backend url cannot end with "/". See /docs for more.', 1);
        }

        $this->backend_base_url = $backend_base_url;
        return $this;
    }

    /**
     * Send the log to the remote server and save
     * the request status.
     * 
     * @param String log_level is the severity of 
     *  the log. Three levels are supported currently i.e 
     *  error, info and warning. Default is info.
     * 
     * @return Logdo object
     */
    public function as($log_level = Logdo::INFO)
    {
        if (!in_array($log_level, Logdo::LOG_LEVELS)) {
            throw new LogdoException('You need to provide a valid log severity. See /docs for log levels', 1);
        }

        $this->log_level = $log_level;
        
        $client = new Client();
        $data = [
            'log' => $this->log,
            'appId' => $this->app_id,
            'logLevel' => $this->log_level,
        ];

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$this->api_token,
        ];

        try {
            $response = $client->request('POST', $this->backend_base_url.Logdo::LOG_URI, 
            [
                'json' => $data,
                'headers' => $headers,
            ]);

            if($code = $response->getStatusCode() == Logdo::LOG_STATUS_ACCEPTED){
                $this->was_successful = true;
            } else {
                $response_body = $response->getBody();
                $message = "Sorry, something went wrong";
                try {
                    $message = json_decode($response_body->getContents(), TRUE)['message'];
                } catch (\Throwable $th) {
                    $message = "Sorry, something went wrong in  library. Please open an issue on github.";
                }
    
                $this->was_successful = false;
                $this->response_error_message = $message;
            }

        } catch (\GuzzleHttp\Exception\ClientException $th) {
            $this->was_successful = false;
            $this->response_error_message = $th->getMessage();
        }
        
        return $this;
    }

    /**
     * Determine if the logging to the remote
     * backend was successful.
     * 
     * @return Boolean true if it was successful
     */
    public function wasSuccessful()
    {
        return $this->was_successful;
    }

    /**
     * Get response error message
     * when the logging to the server fails
     * 
     * @return String response_error_message
     */
    public function getErrorMessage()
    {
        return $this->response_error_message;
    }
}