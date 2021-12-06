<?php
if((isset($_REQUEST['debug']) && $_REQUEST['debug']==1) || 1)
{
	ini_set("display_errors", "On");
	error_reporting(E_ALL & ~E_NOTICE);
}
else {
	ini_set("display_errors", "Off");
}

$dbConnection = new PDO('mysql:dbname='.BD[2].';host=' .BD[0]. (@BD[1]?(';port=' .BD[1]):'').';charset=utf8', BD[3], BD[4]); // дописана проверка указанного порта (DanBarkov)

$dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbConnection->exec("set names utf8");
$dbConnection->exec("SET SESSION group_concat_max_len = 1000000");
$dbConnection->exec("SET sql_mode=''");



function q($sql, $params = array(), $repeat_params = 0) // запрос к базе — короткое имя для удобства
{
    global $dbConnection, $debug;
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
	catch(Exception $e)
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

function q1($sql, $params) //запрос одной строчки
{
	global $debug;
	try
	{

		global $dbConnection;
		$stmt = $dbConnection->prepare($sql);
		$stmt->execute($params);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result;
    }
	catch(Exception $e)
	{
		if(in_array($_SERVER['SERVER_NAME'], ["test-genesis.alef.im", "devtest-genesis.alef.im", "localhost"]) || $debug)
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

function qi($sql, $params, $ignore_exceptions = 0, $repeat_params = 0) // Используется для insert и update
{
	try
	{
		global $dbConnection, $debug;

        if ($repeat_params) { // для повтора именованых параметров в одном запросе (DanBarkov)
            prepareMsSqlQueryParams($sql, $params);
        }

			$stmt = $dbConnection->prepare($sql);

		if($stmt->execute($params))
		{
            /*return true;*/ return (int) $dbConnection->lastInsertId(); // изменил для возврата id строки вместо true (DanBarkov)
		}
		else return false;
    }
	catch(Exception $e)
	{
		if($ignore_exceptions)
		{
			return false;
		}
		if(in_array($_SERVER['SERVER_NAME'], ["test-genesis.alef.im", "devtest-genesis.alef.im", "localhost"]) || $debug || 1)
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

function qCount($sql, $params){ // Выводит количество записей
    global $dbConnection;
    $stmt = $dbConnection->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchColumn();
}

function qRows(){ // Выводит кол-во строк другим способом
    global $dbConnection;
    $stmt = $dbConnection->query('SELECT FOUND_ROWS() as num');
    return $stmt->fetchColumn(0);
}

function qInsertId(){ // Последнйи автоинкриментный ID
    global $dbConnection;
    return $dbConnection->lastInsertId();
}

function qiPrepareWrite($table, $request_params, $ignore_exceptions = 1) {
    $sql_str = '';
    $sql_params = array();
    if (is_array($request_params) && !empty($request_params) && $table) {
        foreach ($request_params as $key_param => $one_param) {
            $sql_str .= " `$key_param` = ? " . ((count($request_params) > 1) ? ', ' : '');
            $sql_params[] = $one_param;
            unset($request_params[$key_param]);
        }
    } else
    	return false;

    return qi("INSERT INTO `{$table}` SET {$sql_str}", $sql_params, $ignore_exceptions);
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
