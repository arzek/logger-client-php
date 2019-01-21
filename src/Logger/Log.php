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
    private static function sendLog($level, $message, $context) {
        $data = [
            'token' => getenv('LOGGER_TOKEN'),
            'env' => self::getRealIpAddr(),
            'level' => $level,
            'message' => $message,
            'context' => $context
        ];

        $data_string = json_encode($data);

        $ch = curl_init(getenv('LOGGER_URL'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);
    }

    /**
     * @param $message
     * @param $context
     */
    public static function info($message, $context) {
        self::sendLog('INFO', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public static function debug($message, $context) {
        self::sendLog('DEBUG', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public static function notice($message, $context) {
        self::sendLog('NOTICE', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public static function warning($message, $context) {
        self::sendLog('WARNING', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public static function error($message, $context) {
        self::sendLog('ERROR', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public static function critical($message, $context) {
        self::sendLog('CRITICAL', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public static function alert($message, $context) {
        self::sendLog('ALERT', $message, $context);
    }

    /**
     * @param $message
     * @param $context
     */
    public static function emergency($message, $context) {
        self::sendLog('EMERGENCY', $message, $context);
    }

    /**
     * @return mixed
     */
    private static function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

}