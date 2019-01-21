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

    /**
     * @param $level
     * @param $message
     * @param $context
     */
    private static function sendLog($level, $message,$context = null)
    {
        $data = [
            'token' => getenv('LOGGER_TOKEN'),
            'env' => 'localhost',
            'level' => $level,
            'message' => $message
        ];

        if ($context) {
            $data['context'] = $context;
        }

        $url = getenv('LOGGER_URL');

        $ch = curl_init($url);

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
    public static function info($message, $context = null)
    {
        self::sendLog('INFO', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public static function debug($message,$context = null)
    {
        self::sendLog('DEBUG', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public static function notice($message,$context = null)
    {
        self::sendLog('NOTICE', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public static function warning($message,$context = null)
    {
        self::sendLog('WARNING', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public static function error($message,$context = null)
    {
        self::sendLog('ERROR', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public static function critical($message,$context = null)
    {
        self::sendLog('CRITICAL', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public static function alert($message,$context = null)
    {
        self::sendLog('ALERT', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public static function emergency($message,$context = null)
    {
        self::sendLog('EMERGENCY', $message, $context);
    }

}