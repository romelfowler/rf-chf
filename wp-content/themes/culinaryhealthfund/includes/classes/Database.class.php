<?php
interface IDatabase
{
  public function connect();
  public function close();
  public function query($sql);
  //public function queryFirst($sql, $result_type);
  public function queryAll($sql);
  //public function quote($value, $allowNull, $type);
}

class DatabaseException extends Exception {}
class DatabaseConnectionException extends Exception {}
class DatabaseQueryException extends Exception {}

class Database
{
  const WRITER = 1;
  const READER = 2;
  const SEARCH = 3;

  public static function factory($config)
  {
    if (!is_array($config))
    {
      error_log('Invalid configuration array.');
      return false;
    }

    $class_name = 'Database_' . $config['dbms'];

    if (!defined($class_name . '_LOADED'))
    {
      if (require(dirname(__FILE__) . '/' . $class_name . '.class.php'))
      {
        define($class_name . '_LOADED', true);
      }
      else
      {
        error_log('Database factorying failed. DBMS implementation not found: ' . $config['dbms']);
        return false;
      }
    }

    if (!array_key_exists('slave', $config))
    {
      $config['slave'] = FALSE;
    }

    if (!array_key_exists('search', $config))
    {
      $config['search'] = FALSE;
    }
    $config['port'] = array_key_exists('port', $config) ? $config['port'] : 3306;
    return new $class_name($config['host'], $config['username'], $config['password'], $config['database'], $config['port'], $config['slave'], $config['search']);
  }
}
?>