<?php
namespace LogdoPhp\Services;

use Appwrite\ID;
use Carbon\Carbon;
use Appwrite\Client;
use LogdoPhp\Contracts\Goable;
use LogdoPhp\Helpers\Constants;
use Appwrite\Services\Databases;

class Database implements Goable{

    private Client $client;
    private Databases $database;

    const LOG_LEVELS = [
        self::INFO,
        self::ERROR,
        self::WARNING,
    ];

    const INFO = 'info';
    const ERROR = 'error';
    const WARNING = 'warning';

    private String $log;
    private String $app_id;
    private String $log_level;
    private String $incident_datetime;
    private String $stack_trace;
    private String $environment;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->database = new Databases($this->client);
    }

    public function for(String $app_id)
    {
        $this->app_id = $app_id;
        return $this;
    }

    public function log(String $log)
    {
        $this->log = $log;
        return $this;
    }

    public function at(String $incident_datetime)
    {
        $this->incident_datetime = $incident_datetime;
        return $this;
    }

    public function as($environment = Database::INFO)
    {
        $this->environment = $environment;
        return $this;
    }

    public function with(String $stack_trace = null)
    {
        $this->stack_trace = $stack_trace;
        return $this;
    }

    public function level($log_level = Database::INFO)
    {
        $this->log_level = $log_level;
        return $this;
    }

    public function go()
    {
        try {
            $this->database->createDocument(Constants::DATABASE_ID, 
            Constants::LOGS_COLLECTION_ID, 
            ID::unique(), [
                "app_id" => $this->app_id,
                "level" => $this->log_level,
                "environment" => $this->environment,
                "incident_datetime" => $this->incident_datetime ?? Carbon::now()->toDateTimeString(),
                "description" => $this->log,
                "stack_trace" => $this->stack_trace ?? null,
            ]);
        } catch (\Throwable $th) {}
    }
}