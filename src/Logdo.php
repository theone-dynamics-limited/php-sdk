<?php
namespace LogdoPhp;

use Appwrite\Client;
use LogdoPhp\Contracts\Goable;
use LogdoPhp\Helpers\Constants;
use LogdoPhp\Services\Database;

class Logdo {
    
    // Usage example.
    // Logdo::instance()
    //    ->logger()
    //    ->log('$log')
    //    ->as('$env['local', ' production', 'staging']')
    //    ->with('$stack_trace')
    //    ->level('type[info,warning,error]');
    //    ->go();

    private Client $client;
    private Goable $service;
    private static $logdo = null;

    public function __construct()
    {
        $client = new Client();
        $client->setEndpoint(Constants::SERVICE_URL)
            ->setProject(Constants::PROJECT_ID)
            ->setKey(Constants::SECRET_KEY)
            ->setSelfSigned(); // Use only on dev mode with a self-signed SSL cert
        $this->client = $client;
    }

    /**
     * Get an fresh instance of LogDo
     *
     * @return Logdo object
     */
    public static function instance(): Logdo
    {
        if (is_null(self::$logdo)) {
            self::$logdo = new Logdo();
        }
        return self::$logdo;
    }

    public function logger()
    {
        $this->service = new Database($this->client);
        return $this->service;
    }

    public function go()
    {
        return $this->service->go();
    }
}