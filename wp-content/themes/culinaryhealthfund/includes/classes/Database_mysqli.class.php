<?php
class Database_mysqli implements IDatabase
{
  const RESULT_ASSOC  = MYSQLI_ASSOC;
  const RESULT_NUMERIC = MYSQLI_NUM;
  const RESULT_BOTH  = MYSQLI_BOTH;

  private $writer_connected = false;
  private $dbw = null;

  private $reader_connected = false;
  private $dbr = null;

  private $search_connected = false;
  private $dbs = null;

  private $connection_mode;
  private $dbh = null;

  private $host;
  private $port;
  private $username;
  private $password;
  private $database;
  private $slaveinfo;
  private $searchinfo;
  private $counters;
  private $query_list = array(); // array of queries that were successfull executed for debug purposes.

  private $result_type = self::RESULT_ASSOC;

  private $query_comment = "";

  /*******************************************************************************************
	* Description
	*   Class constructor (initializes variables)
	*
	* Input
	*   $host 		= database server ip or hostname
	*   $username 	= user name
	*   $password 	= valid password
	*   $database 	= (optional) database name
	*   $port 		= (optional) database server port
	*******************************************************************************************/
  public function __construct($host, $username, $password, $database=null, $port=3306, $slaveinfo=null, $searchinfo=null)
  {
    $this->host = $host;
    $this->port = $port;
    $this->username = $username;
    $this->password = $password;
    $this->database = $database;
    $this->slaveinfo = $this->setSlaveDefaults($slaveinfo);
    $this->searchinfo = $this->setSlaveDefaults($searchinfo);

    $this->counters = array(
      'TotalQueries' => 0,
      'MasterQueries' => 0,
      'SlaveQueries' => 0,
      'SearchQueries' => 0,
      'ReadQueries' => 0,
      'MultiQueries' => 0,
      'QueryErrors' => 0
    );

    // set the default connection mode
    $this->setConnectionMode(Database::WRITER);
  }

  public function getPDO()
  {
    $dsn = "mysql:host=".$this->host.";port=".$this->port.";dbname=".$this->database;

    return new PDO($dsn, $this->username, $this->password);
  }

  /*******************************************************************************************
	* Description
	*   Sets defaults for slave boxes if value is not in array
	*******************************************************************************************/
  private function setSlaveDefaults($slaveinfo=null)
  {
    if (!empty($slaveinfo))
    {
      $slaveinfo['username'] = empty($slaveinfo['username']) ? $this->username : $slaveinfo['username'];
      $slaveinfo['password'] = empty($slaveinfo['password']) ? $this->password : $slaveinfo['password'];
      $slaveinfo['database'] = empty($slaveinfo['database']) ? $this->database : $slaveinfo['database'];
      $slaveinfo['port']   = empty($slaveinfo['port']) ? $this->port : $slaveinfo['port'];
    }
    return $slaveinfo;
  }

  /*******************************************************************************************
	* Description
	*   Sets comment for the query
	*******************************************************************************************/
  public function setQueryComment($comment)
  {
    $this->query_comment = $this->escape($comment);
  }

  /*******************************************************************************************
	* Description
	*   Sets the current connection handle
	*******************************************************************************************/
  public function setConnectionMode($connection_mode)
  {
    if ($connection_mode == Database::READER)
    {
      $this->connection_mode = Database::READER;
      $this->dbh = &$this->dbr;
    }
    elseif ($connection_mode == Database::SEARCH)
    {
      $this->connection_mode = Database::SEARCH;
      $this->dbh = &$this->dbs;
    }
    else
    {
      $this->connection_mode = Database::WRITER;
      $this->dbh = &$this->dbw;
    }
  }

  /*******************************************************************************************
	* Description
	*   Connects to a database server and specific database
	*
	* Output
	*   true/false = success/failure
	*******************************************************************************************/
  public function connect()
  {
    $connected = false;

    if ($this->connection_mode == Database::READER)
    {
      $connected = $this->connectReader();
      $this->dbh = &$this->dbr;
    }
    elseif ($this->connection_mode == Database::SEARCH)
    {
      $connected = $this->connectSearch();
      $this->dbh = &$this->dbs;
    }
    else
    {
      $connected = $this->connectWriter();
      $this->dbh = &$this->dbw;
    }

    return $connected;
  }

  /*******************************************************************************************
	* Description
	*   Connects to a database master server and specific database (read & write)
	*
	* Output
	*   true/false = success/failure
	*******************************************************************************************/
  private function connectWriter()
  {
    if (!$this->writer_connected)
    {
      $dbw = mysqli_connect($this->host, $this->username, $this->password , $this->database, $this->port);

      if (mysqli_connect_errno())
      {
        error_log('Database connection failed: ' . mysqli_connect_error() . "\n" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
      }
      elseif ($dbw)
      {
        $this->dbw = $dbw;
        $this->writer_connected = true;
      }
    }
    return $this->writer_connected;
  }

  /*******************************************************************************************
	* Description
	*   Connects to a database slave server (read-only)
	*
	* Output
	*   true/false = success/failure
	*******************************************************************************************/
  private function connectReader()
  {
    if (!$this->reader_connected)
    {
      // Connect to slave if slave info was provided otherwise set it to the same handle as the writer
      if (is_array($this->slaveinfo))
      {
        $dbr = @mysqli_connect($this->slaveinfo['host'], $this->slaveinfo['username'], $this->slaveinfo['password'], $this->slaveinfo['database'], $this->slaveinfo['port']);

        if (mysqli_connect_errno())
        {
          // if our connection to the slave fails, failover to the master
          $this->reader_connected = $this->connectWriter();
          $this->dbr = &$this->dbw;
        }
        elseif ($dbr)
        {
          $this->dbr = $dbr;
          $this->reader_connected = true;
        }
      }
      else
      {
        $this->reader_connected = $this->connectWriter();
        $this->dbr = &$this->dbw;
      }
    }
    return $this->reader_connected;
  }

  /*******************************************************************************************
	* Description
	*   Connects to a database search server (read-only)
	*
	* Output
	*   true/false = success/failure
	*******************************************************************************************/
  private function connectSearch()
  {
    if (!$this->search_connected)
    {
      // Connect to slave if slave info was provided otherwise set it to the same handle as the writer
      if (is_array($this->searchinfo))
      {
        $dbs = @mysqli_connect($this->searchinfo['host'], $this->searchinfo['username'], $this->searchinfo['password'], $this->searchinfo['database'], $this->searchinfo['port']);

        if (mysqli_connect_errno())
        {
          // if our connection to the slave fails, failover to the master
          $this->search_connected = $this->connectReader();
          $this->dbs = &$this->dbr;
        }
        elseif ($dbs)
        {
          $this->dbs = $dbs;
          $this->search_connected = true;
        }
      }
      else
      {
        $this->search_connected = $this->connectReader();
        $this->dbs = &$this->dbr;
      }
    }
    return $this->search_connected;
  }

  /*******************************************************************************************
	* Description
	*   Closes the connection to a database
	*
	* Output
	*   true/false = success/failure
	*******************************************************************************************/
  public function close()
  {
    $success = false;

    if (is_resource($this->dbw))
    {
      $success = mysqli_close($this->dbw);

      $this->dbw = null;
      $this->writer_connected = false;
    }

    if (is_resource($this->dbr))
    {
      $success = mysqli_close($this->dbr);

      $this->dbr = null;
      $this->reader_connected = false;
    }

    if (is_resource($this->dbs))
    {
      $success = mysqli_close($this->dbs);

      $this->dbs = null;
      $this->search_connected = false;
    }

    return $success;
  }

  /*******************************************************************************************
	* Description
	*   Pings the connections
	*
	* Output
	*   true/false = success/failure
	*******************************************************************************************/
  public function ping()
  {
    return mysqli_ping($this->dbh);
  }

  /*******************************************************************************************
	* Description
	*   Selects a specific database on the server
	*
	* Input
	*   $db_name = database name
	*
	* Output
	*   true/false = success/failure
	*******************************************************************************************/
  public function selectDatabase($db_name)
  {
    $success = mysqli_select_db($this->dbh, $db_name);

    if (mysqli_errno($this->dbh) != 0)
    {
      error_log('Error selecting database ' . $db_name . ': ' . mysqli_error($this->dbh) . ', URL: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    }

    return $success;
  }

  /*******************************************************************************************
	* Description
	*   Closes the connection to a database
	*
	* Output
	*   true/false = success/failure
	*******************************************************************************************/
  public function setCharset($charset)
  {
    $success = mysqli_set_charset($this->dbh, $charset);

    if (!$success)
    {
      error_log('Error loading character set ' . $charset . ': ' . mysqli_error($this->dbh) . ', URL: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    }

    return $success;
  }

  /*******************************************************************************************
	* Description
	*   Closes the connection to a database
	*
	* Output
	*   true/false = success/failure
	*******************************************************************************************/
  public function setResultType($result_type)
  {
    switch ($result_type)
    {
    case self::RESULT_ASSOC:
    case self::RESULT_NUMERIC:
    case self::RESULT_BOTH:
      $this->result_type = $result_type;
      break;

    default:
      $this->result_type = self::RESULT_ASSOC;
      throw new DatabaseException("Unknown result type specified to setResultType()");
      break;
    }
  }

  /*******************************************************************************************
	* Description
	*   Determines if a query is read only
	*
	* Input
	*   $sql = SQL statement to use for query\
	*******************************************************************************************/
  private function isReadQuery($sql)
  {
    $sql_cmd = strtoupper(substr(ltrim($sql), 0, 6));
    $is_read = strcmp($sql_cmd, 'SELECT') == 0;

    if ($is_read) {
      $this->counters['ReadQueries']++;
    }

    return $is_read;
  }

  /*******************************************************************************************
	* Description
	*   Queries a database
	*
	* Input
	*   $sql = SQL statement to use for query
	*
	* Output
	*   mixed: true/false or a valid MySQL result set (depending on type of query)
	*******************************************************************************************/
  public function query($sql, $connection_mode=Database::WRITER)
  {
    $this->setConnectionMode($connection_mode);

    $retval = false;

    $this->connect();

    $http  = "/*http://";
    $http .= isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
    $http .= isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '';
    $http .= "*/\n";

    $result = mysqli_query($this->dbh, $http . (!empty($this->query_comment) ? "/*Comment:\n$this->query_comment*/\n" : "") . $sql);

    // clear use comment
    $this->query_comment = "";

    if (mysqli_errno($this->dbh) != 0)
    {
      $this->counters['QueryErrors']++;
      error_log(mysqli_error($this->dbh) . "\nSQL: " . $sql . "\nURL: " . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    }
    else
    {
      if ($result) {
        $retval = $result;
      }

      $this->counters['TotalQueries']++;

      if ($this->reader_connected && $this->dbh === $this->dbr) {
        $this->counters['SlaveQueries']++;
      }
      else {
        $this->counters['MasterQueries']++;
      }

      if (defined("DEBUG_QUERIES") && DEBUG_QUERIES) {
        array_push($this->query_list, $sql);
      }
    }

    return $retval;
  }

  public function readQuery($sql)
  {
    if ($this->isReadQuery($sql))
    {
      return $this->query($sql, Database::READER);
    }
    else
    {
      throw new DatabaseQueryException("Attempting to perform a write action with the database reader (read-only) connection");
    }
  }

  /*******************************************************************************************
	* Description
	*   Returns query stats for a DB instance
	*
	* Output
	*   array
	*******************************************************************************************/
  public function getQueryStats()
  {
    return $this->counters;
  }

  /*******************************************************************************************
	* Description
	*   Returns list of successfully executed queries for debug purposes
	*   REQUIREMENT: define("DEBUG_QUERIES", 1);
	*
	* Output
	*   array
	*******************************************************************************************/
  public function getQueryList()
  {
    return $this->query_list;
  }

  /*******************************************************************************************
	* Description
	*   Sends miltiple queries to a database
	*
	* Input
	*   $sql = SQL statement to use for query
	*
	* Output
	*   mixed: true/false on success
	*******************************************************************************************/
  public function queryMultiple($sql, $connection_mode=Database::WRITER)
  {
    $this->setConnectionMode($connection_mode);

    $success = false;

    $this->connect();
    $success = mysqli_multi_query($this->dbh, '/*http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "*/\n" . $sql);

    if (mysqli_errno($this->dbh) != 0)
    {
      $this->counters['QueryErrors']++;
      error_log(mysqli_error($this->dbh) . "\nSQL: " . $sql . "\nURL: " . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    }
    else
    {
      $this->counters['MultiQueries']++;
    }

    return $success;
  }

  public function readQueryMultiple($sql)
  {
    if ($this->isReadQuery($sql))
    {
      return $this->queryMultiple($sql, Database::READER);
    }
    else
    {
      throw new DatabaseQueryException("Attempting to perform a write action with the database reader (read-only) connection");
    }
  }

  public function useResult()
  {
    return mysqli_use_result($this->dbh);
  }
  public function storeResult()
  {
    return mysqli_store_result($this->dbh);
  }
  public function moreResults()
  {
    return mysqli_more_results($this->dbh);
  }
  public function nextResult()
  {
    return mysqli_next_result($this->dbh);
  }

  /*******************************************************************************************
	 * Description
	 *   Queries a database and returns an associative array of the first row()
	 *
	 * Input
	 *   $sql = SQL statement to use for query
	 *
	 * Output
	 *   mixed: array
	 *******************************************************************************************/
  public function queryFirst($sql, $result_type=self::RESULT_ASSOC, $connection_mode=Database::WRITER)
  {
    if ($result = $this->query($sql, $connection_mode))
    {
      $row = $this->fetch($result, $result_type);
      $this->freeResult($result);
      return $row;
    }
    else
    {
      return false;
    }
  }

  public function readQueryFirst($sql, $result_type=self::RESULT_ASSOC)
  {
    if ($this->isReadQuery($sql))
    {
      return $this->queryFirst($sql, $result_type, Database::READER);
    }
    else
    {
      throw new DatabaseQueryException("Attempting to perform a write action with the database reader (read-only) connection");
    }
  }

  /*******************************************************************************************
	* Description
	*   Fetches all rows into an associative array and frees the result
	*
	* Input
	*   $result = the result set to use
	*
	* Output
	*   mixed: row[]/false = row array/failure
	*******************************************************************************************/
  public function queryAll($sql, $connection_mode=Database::WRITER)
  {
    $rows = array();
    $result = $this->query($sql, $connection_mode);

    if ($result)
    {
      while ($row = $this->fetch($result, $this->result_type))
      {
        $rows[] = $row;
      }
      $this->freeResult($result);
    }

    return $rows;
  }

  public function query_all($sql, $connection_mode=Database::WRITER)
  {
    return $this->queryAll($sql, $connection_mode);
  }

  public function readQueryAll($sql)
  {
    if ($this->isReadQuery($sql))
    {
      return $this->queryAll($sql, Database::READER);
    }
    else
    {
      throw new DatabaseQueryException("Attempting to perform a write action with the database reader (read-only) connection");
    }
  }

  /*******************************************************************************************
	* Description
	*   Frees the memory allocated to a result set
	*
	* Input
	*   $result = the result set to use
	*
	* Output
	*   true/false = success/failure
	*******************************************************************************************/
  public function freeResult($result)
  {
    if ($result)
    {
      mysqli_free_result($result);

      if (mysqli_errno($this->dbh) != 0)
      {
        error_log(mysqli_error($this->dbh) . ', URL: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
      }
    }
  }

  /*******************************************************************************************
	* Description
	*   Fetches the next row as an associated array, enumerated array or combination
	*
	* Input
	*   $result = the result set to use
	*
	* Output
	*   mixed: row[]/false = row array/failure
	*******************************************************************************************/
  public function fetch($result, $result_type=self::RESULT_ASSOC)
  {
    if ($result)
    {
      $row = mysqli_fetch_array($result, $result_type);

      if (mysqli_errno($this->dbh) != 0)
      {
        error_log(mysqli_error($this->dbh) . ', URL: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
      }

      return $row;
    }

    return false;
  }
  public function fetchRow($result)   { return $this->fetch($result, self::RESULT_NUMERIC); }
  public function fetchArray($result) { return $this->fetch($result, self::RESULT_BOTH);    }
  public function fetchAssoc($result) { return $this->fetch($result, self::RESULT_ASSOC);   }

  /*******************************************************************************************
	* Description
	*   Fetches the next row as an object
	*
	* Input
	*   $result = the result set to use
	*
	* Output
	*   mixed: row[]/false = row array/failure
	*******************************************************************************************/
  public function fetchObject($result)
  {
    if ($result)
    {
      $row = mysqli_fetch_object($result);

      if (mysqli_errno($this->dbh) != 0)
      {
        error_log(mysqli_error($this->dbh) . ', URL: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
      }

      return $row;
    }

    return false;
  }

  /*******************************************************************************************
	* Description
	*   Sets internal data pointer to the row specified
	*
	* Input
	*   $result     = the result set to use
	*   $row_number = the row number to seek to (default: 0, will reset the pointer)
	*
	* Output
	*   boolean     = returns true if operation was successful
	*******************************************************************************************/
  public function seek($result, $row_number=0)
  {
    $success = false;

    if ($result)
    {
      $success = mysqli_data_seek($result, $row_number);
    }

    return $success;
  }

  /*******************************************************************************************
	* Description
	*   Gets number of rows in result set
	*
	* Input
	*   $result = the result set to use
	*
	* Output
	*   mixed: int/false = number of rows in the result set/failure
	*******************************************************************************************/
  public function numRows($result)
  {
    $retval = 0;

    if ($result)
    {
      $retval = mysqli_num_rows($result);

      if (mysqli_errno($this->dbh) != 0)
      {
        error_log(mysqli_error($this->dbh) . ', URL: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
      }
    }

    return $retval;
  }


  /*******************************************************************************************
	* Description
	*   Gets number of FOUND_ROWS following a SQL_CALC_FOUND_ROWS query
	*
	* Output
	*   mixed: int = number of FOUND_ROWS (total rows that would have been returned without LIMIT
	*******************************************************************************************/
  public function foundRows()
  {
    $row = $this->queryFirst("SELECT FOUND_ROWS()", self::RESULT_NUMERIC, $this->connection_mode);

    if (mysqli_errno($this->dbh) != 0)
    {
      error_log(mysqli_error($this->dbh) . ', URL: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    }

    return (int)$row[0];
  }

  /*******************************************************************************************
	* Description
	*   Gets number of rows affected by last query
	*
	* Input
	*   $result = the result set to use
	*
	* Output
	*    mixed: int/false = number of rows affected by last query/failure
	*******************************************************************************************/
  public function affectedRows()
  {
    $num = (int)mysqli_affected_rows($this->dbw);

    if (mysqli_errno($this->dbw) != 0)
    {
      error_log(mysqli_error($this->dbw) . ', URL: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    }

    return $num;
  }

  /*******************************************************************************************
	* Description
	*   Gets id of last INSERT operation
	*
	* Output
	*    mixed: int/false = id generated by last INSERT operation
	*******************************************************************************************/
  public function insertId()
  {
    $id = (int)mysqli_insert_id($this->dbw);

    if (mysqli_errno($this->dbw) != 0)
    {
      error_log(mysqli_error($this->dbw) . ', URL: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    }

    return $id > 0 ? $id : false;
  }

  /*******************************************************************************************
	* Description
	*   Readies a value for database insert
	*
	* Input
	*   $value = the string to ready
	*   $type = type of value (defaults to string)
	*   $allowNull = whether to return the keyword NULL or and empty string ('')
	*
	* Output
	*    string: database safe string
	*******************************************************************************************/
  public function quote($value, $allowNull=false, $type='string')
  {
    $this->connect();

    if (!empty($value))
    {
      switch ($type)
      {
      case 'int':
      case 'bool':
        $retval = (int)$value;
        break;

      case 'float':
        $retval = (float)$value;
        break;

      default:
        $retval = "'" . mysqli_real_escape_string($this->dbh, $value) .  "'";
        break;
      }

    }
    else
    {
      $retval = $allowNull ? 'NULL' : "''";
    }

    return $retval;
  }

  /*******************************************************************************************
	* Description
	*   Readies a string for database insert
	*
	* Input
	*   $string = the string to ready
	*   $allow_nulls = whether to return the keyword NULL or and empty string ('')
	*
	* Output
	*    string: database safe string
	*******************************************************************************************/
  public function escape(&$mixed, $allowNulls=true)
  {
    $this->connect();

    if (is_array($mixed))
    {
      $tmp = array();
      foreach ($mixed as $k => $v)
      {
        $tmp[$k] = $this->escape($v, $allowNulls);
      }
      $retval = $tmp;
    }
    else
    {
      if (!empty($mixed) || (is_numeric($mixed) && $mixed == 0))
      {
        $retval = "'" . mysqli_real_escape_string($this->dbh, $mixed) .  "'";
      }
      else
      {
        $retval = $allowNulls ? 'NULL' : "''";
      }
    }

    return $retval;
  }

  /*******************************************************************************************
	* Description
	*   Readies a SQL string with placeholders for execution
	*
	* Input
	*   $args = array of arguments, first argument is the SQL query the following are the placehodler values
	*
	* Output
	*    string: database safe SQL string
	*******************************************************************************************/
  private function parseSafeQuery($args)
  {
    $sql = array_shift($args);
    $i  = 0;
    $pos = strpos($sql, '%');

    $this->connect();

    while ($pos !== false)
    {
      $skip = false;
      $type = substr($sql, $pos, 2);

      switch ($type)
      {
      case '%%':
        $r_value = '%';
        $skip = true;
        break;

      case '%d':
        $r_value = (int)$args[$i];
        break;

      case '%f':
        $r_value = '\'' . (float)$args[$i] . '\'';
        break;

      case '%s':
        $r_value = '\'' . mysqli_real_escape_string($this->dbh, $args[$i]) . '\'';
        break;

      case '%S':
        $r_value = strlen($args[$i]) ? '\'' . mysqli_real_escape_string($this->dbh, $args[$i]) . '\'' : 'NULL';
        break;
      }

      $sql = substr($sql, 0, $pos) . $r_value . substr($sql, $pos + 2);

      $offset = (int)($pos + strlen($r_value) + 1);
      $pos = @strpos($sql, '%', $offset);

      //allows skipping of %% values
      $i += $skip ? 0 : 1;
    }

    return $sql;
  }

  public function safeQuery()
  {
    $sql = $this->parseSafeQuery(func_get_args());
    return $this->query($sql);
  }

  public function safeQueryFirst()
  {
    $sql = $this->parseSafeQuery(func_get_args());
    return $this->queryFirst($sql);
  }

  public function safeQueryAll()
  {
    $sql = $this->parseSafeQuery(func_get_args());
    return $this->queryAll($sql);
  }

  public function safeQueryDebug()
  {
    $sql = $this->parseSafeQuery(func_get_args());

    echo $sql;
    return $sql;
  }

  public function safeQueryDebugNoEcho()
  {
    $sql = $this->parseSafeQuery(func_get_args());

    return $sql;
  }

  public function safeReadQuery()
  {
    $this->setConnectionMode(Database::READER);
    $sql = $this->parseSafeQuery(func_get_args());

    return $this->query($sql, Database::READER);
  }

  public function safeReadQueryFirst()
  {
    $this->setConnectionMode(Database::READER);
    $sql = $this->parseSafeQuery(func_get_args());

    return $this->queryFirst($sql, self::RESULT_ASSOC, Database::READER);
  }

  public function safeReadQueryAll()
  {
    $this->setConnectionMode(Database::READER);
    $sql = $this->parseSafeQuery(func_get_args());

    return $this->queryAll($sql, Database::READER);
  }

  public function safeSearchQuery()
  {
    $this->setConnectionMode(Database::SEARCH);
    $sql = $this->parseSafeQuery(func_get_args());

    return $this->query($sql, Database::SEARCH);
  }

  public function safeSearchQueryFirst()
  {
    $this->setConnectionMode(Database::SEARCH);
    $sql = $this->parseSafeQuery(func_get_args());

    return $this->queryFirst($sql, self::RESULT_ASSOC, Database::SEARCH);
  }

  public function safeSearchQueryAll()
  {
    $this->setConnectionMode(Database::SEARCH);
    $sql = $this->parseSafeQuery(func_get_args());

    return $this->queryAll($sql, Database::SEARCH);
  }
}
?>
