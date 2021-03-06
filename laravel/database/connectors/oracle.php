<?php namespace Laravel\Database\Connectors; use PDO;

/**
 * @author zacwasielewski
 * @link   https://github.com/zacwasielewski/laravel-pdo-oci-driver
 */
class Oracle extends Connector {

	/**
         * The PDO connection options.
         *
         * @var array
         */
         protected $options = array(
             PDO::ATTR_CASE => PDO::CASE_UPPER,
             PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
             PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
         );
         
	/**
	 * Establish a PDO database connection.
	 *
	 * @param array $config
	 * @return PDO
	 */
	public function connect($config)
	{
		extract($config);

		// The developer has the freedom of specifying a port for the Oracle database
		// or no port will be used to make the connection by PDO.
		if (isset($config['port']))
		{
			$port = ":{$config['port']}";
		}
		else
		{
			$port = "";
		}
		        
		// If no host is specified, the database name must be defined in the
		// tnsnames.ora file in %ORACLE_HOME%\network\admin
		if (isset($config['host']))
		{
			$dsn = "oci:dbname={$config['host']}{$port}/{$config['database']}";
		}
		else
		{
			$dsn = "oci:dbname={$config['database']}";
		}

		// If a character set has been specified, we'll execute a query against
		// the database to set the correct character set. By default, this is
		// set to UTF-8 which should be fine for most scenarios.
		if (isset($config['charset']))
		{
			$dsn .= ";charset={$config['charset']}";
		} else {
			$dsn .= ";charset=AL32UTF8";
		}

		$connection = new PDO($dsn, $username, $password, $this->options($config));

		return $connection;
	}

}
