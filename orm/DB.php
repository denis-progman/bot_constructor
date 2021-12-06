<?php


namespace BotConstructor\ORM;

use BotConstructor\core\ModelFather;
use PDO;
use BotConstructor\core\Loger;
/**
 * Class DB
 * @package BotConstructor\ORM
 */
class DB extends ModelFather
{

    protected static $debug = 1;
    protected $connection = null;
    public static ?array $config = null;

    /**
     * DB constructor.
     */
    public function __construct()
    {
        $this->connection = $this->getConnection();
    }

    public static function builder() {
        self::$config = (include 'app_config.php')['db'];
    }

    /**
     * @return PDO|bool
     */
    public function getConnection(): ?PDO
    {
        try {
            $configs = static::$config;
            $connection = new PDO(
                "mysql:dbname={$configs['name']}" .
                ";host={$configs['host']}" .
                (@$configs['port'] ? (';port=' . $configs['port']) : ''),
                $configs['user'],
                $configs['password']
            );
            $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->exec("set names utf8");
            $connection->exec("SET SESSION group_concat_max_len = 1000000");
            $connection->exec("SET sql_mode=''");
            return $connection;
        } catch (\Exception $e) {
            Loger::log($e->getMessage());
            return null;
        }
    }

    /**
     * @param array|null $configs
     */
    public function setConfigs(array $configs)
    {
        static::$config = $configs;
    }

    /**
     * @return array|null
     */
    public function getConfigs()
    {
        return static::$config;
    }

    public function q($sql, $params = array(), $repeat_params = 0) // запрос к базе — короткое имя для удобства
    {
        $dbConnection = $this->getConnection();
        try
        {
            if ($repeat_params) { // для повтора именованых параметров в одном запросе (DanBarkov)
                prepareMsSqlQueryParams($sql, $params);
            }

            $stmt = $dbConnection->prepare($sql);

            $stmt->execute($params);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch(\Exception $e)
        {
            if(in_array($_SERVER['SERVER_NAME'], ["test-genesis.alef.im", "devtest-genesis.alef.im", "localhost"]) || 1)
            {
                echo "<pre>";
                print_r($e);
                echo "\n\n\n------- \n\n\n";
                echo $sql;
                echo "\n\n\n------- \n\n\n";
                print_r($params);
                die("<br /> <a href='engine/exit.php'>Выход</a>");
            }else
            {
                die("Произошла ошибка в SQL-запросе. Обратитесь к Вашему менеджеру. <br /> <a href='engine/exit.php'>Выход</a>");
            }
        }
    }

    public function q1($sql, $params) //запрос одной строчки
    {
        try
        {
            $dbConnection = $this->getConnection();
            $stmt = $dbConnection->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
        catch(\Exception $e)
        {
            if(in_array($_SERVER['SERVER_NAME'], ["test-genesis.alef.im", "devtest-genesis.alef.im", "localhost"]) || static::$debug)
            {
                echo "<pre>";
                print_r($e);
                echo "\n\n\n------- \n\n\n";
                echo $sql;
                echo "\n\n\n------- \n\n\n";
                print_r($params);
                die("<br /> <a href='engine/exit.php'>Выход</a>");
            }else
            {
                die("Произошла ошибка в SQL-запросе. Обратитесь к Вашему менеджеру.<br /> <a href='engine/exit.php'>Выход</a>");
            }
        }
    }

    public function qi($sql, $params, $ignore_exceptions = 0, $repeat_params = 0) // Используется для insert и update
    {
        try
        {
            $dbConnection = $this->getConnection();

            if ($repeat_params) { // для повтора именованых параметров в одном запросе (DanBarkov)
                prepareMsSqlQueryParams($sql, $params);
            }

            $stmt = $dbConnection->prepare($sql);

            if($stmt->execute($params))
            {
                /*return true;*/ return $dbConnection->lastInsertId(); // изменил для возврата id строки вместо true (DanBarkov)
            }
            else return false;
        }
        catch(\Exception $e)
        {
            if($ignore_exceptions)
            {
                return false;
            }
            if(in_array($_SERVER['SERVER_NAME'], ["test-genesis.alef.im", "devtest-genesis.alef.im", "localhost"]) || static::$debug)
            {
                echo "<pre>";
                print_r($e);
                echo "\n\n\n------- \n\n\n";
                echo $sql;
                echo "\n\n\n------- \n\n\n";
                print_r($params);
                die("<br /> <a href='engine/exit.php'>Выход</a>");
            }else
            {
                die("Произошла ошибка в SQL-запросе. Обратитесь к Вашему менеджеру.<br /> <a href='engine/exit.php'>Выход</a>");
            }
        }

    }

    public function qCount($sql, $params){ // Выводит количество записей
        $dbConnection = $this->getConnection();
        $stmt = $dbConnection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    public function qRows(){ // Выводит кол-во строк другим способом
        $dbConnection = $this->getConnection();
        $stmt = $dbConnection->query('SELECT FOUND_ROWS() as num');
        return $stmt->fetchColumn(0);
    }

    function qInsertId(){ // Последнйи автоинкриментный ID
        global $dbConnection;
        return $dbConnection->lastInsertId();
    }

    private static function prepareSQL($request_params) {
        $sql_str = '';
        $sql_params = array();
        if (is_array($request_params) && !empty($request_params)) {
            foreach ($request_params as $key_param => $one_param) {
                $sql_str .= " `$key_param` = ? " . ((count($request_params) > 1) ? ', ' : '');
                $sql_params[] = $one_param;
                unset($request_params[$key_param]);
            }
        } else
            return false;
        return ['sql' => $sql_str, 'params' => $sql_params];
    }

    function qiArr($table, $paramsArr, $ignore_exceptions = 1) {
        $prepareArr = self::prepareSQL($paramsArr);
        if (is_array($prepareArr)) {
            return qi("INSERT INTO `{$table}` SET {$prepareArr['sql']}", $prepareArr['params'], $ignore_exceptions);
        }
        return false;
    }

    function quArr($table, $paramsArr, $id, $ignore_exceptions = 1) {
        $prepareArr = self::prepareSQL($paramsArr);
        if (is_array($prepareArr)) {
            return qi("UPDATE `{$table}` SET {$prepareArr['sql']} WHERE `id` = ?", $prepareArr['params'] + ['id' => $id], $ignore_exceptions);
        }
        return false;
    }


    function prepareMsSqlQueryParams(&$query, &$params) // функция для повторных именованых параметров в одном запросе (DanBarkov)
    {
        foreach ($params as $key_param => $one_param) {
            $pattern = "/(\:$key_param)/";
            $count = 0;
            $query = preg_replace_callback($pattern, function ($matches) use (&$count, &$new_params, &$params){
                $count ++;
                $added_params = $matches[1] . $count;
                $params[$added_params] = $params[$matches[1]];
                return $added_params;
            }, $query);
            unset($params[$key_param]);
        }
    }

}