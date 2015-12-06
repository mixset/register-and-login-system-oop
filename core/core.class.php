<?php

/**
 * Class core
 */
class Core
{
    /**
     * @var array
     */
    public static $config;

    /**
     * @var array
     */
    private $configData = [
        0 => 'config/config.ini',
        1 => 'text/global.lang.php'
    ];

    /**
     * @param bool
     */
    public function __construct()
    {
        if (file_exists($this->configData[0]) && (filesize($this->configData[0]) !== 0)) {
            $file = parse_ini_file($this->configData[0], true);
            self::$config = $file;
        } else {
            return false;
        }

        header('Content-Type: text/html; charset=' . self::$config['system']['charset']);

        error_reporting(self::$config['system']['errorReporting']);

        if (phpversion() < self::$config['system']['PHPVersion']) {
            die('Your server must be in' . self::$config['system']['PHPVersion'] . ' PHP version or higher.');
        }

        return null;
    }

    /**
     * @return PDO|string
     */
    public function DBconnection()
    {
        $db = new PDO(self::$config['db']['driver'] . 'dbname=' . self::$config['db']['db_name'] . ';host=' . self::$config['db']['host'], self::$config['db']['user'], self::$config['db']['password']);

        return (!$db) ? 'Error during connection to database.' : $db;
    }
}

?>