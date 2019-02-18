<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 1/21/2019
 * Time: 9:04 PM
 */

namespace Logger;

/**
 * Class Log
 * @package Logger
 */
class Log
{
    private $token;

    private $api;

    public function __construct($token, $api) {
      $this->token = $token;
      $this->api = $api;
    }

    /**
     * @param $level
     * @param $message
     * @param $context
     */
    private function sendLog($level, $message,$context = null)
    {
        $data = [
            'token' => $this->token,
            'env' => 'localhost',
            'level' => $level,
            'message' => $message
        ];

        if ($context) {
            $data['context'] = $context;
        }

        $ch = curl_init($this->api);

        $jsonDataEncoded = json_encode($data);

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_exec($ch);
    }

    /**
     * @param $message
     * @param $context
     */
    public function info($message, $context = null)
    {
        $this->sendLog('INFO', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public function debug($message,$context = null)
    {
        $this->sendLog('DEBUG', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public function notice($message,$context = null)
    {
        $this->sendLog('NOTICE', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public function warning($message,$context = null)
    {
        $this->sendLog('WARNING', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public function error($message,$context = null)
    {
        $this->sendLog('ERROR', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public function critical($message,$context = null)
    {
        $this->sendLog('CRITICAL', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public function alert($message,$context = null)
    {
        $this->sendLog('ALERT', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public function emergency($message,$context = null)
    {
        $this->sendLog('EMERGENCY', $message, $context);
    }

}