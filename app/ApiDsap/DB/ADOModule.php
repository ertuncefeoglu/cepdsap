<?php namespace ApiDsap\DB;

/**
 * Define logging function for ADODB
 */
define('ADODB_OUTP', 'pradoAdoLogger');
/**
 * Define ADODB fetch method
 */
define('ADODB_ASSOC_CASE', 1);

/**
 * include ADODB files
 */
/*
require_once ('adodb/adodb-exceptions.inc.php');
require_once ('adodb/adodb.inc.php');
require_once ('adodb/adodb-perf.inc.php');
*/
/**
 * ADOModule class.
 *
 * ADOModule class is used for configuring and establishing database
 * connections.
 *
 * This class uses ADODB library for database layer and forwards ADODB function
 * calls to appropriate ADODB class. Database connection is only established
 * when a first call to any ADODB function.
 *
 * Following parameters can be used for configuring database connection;
 * <ul>
 * 	<li><b>Driver</b>:Database Driver. For available values please refer to ADODB manual.</li>
 * 	<li><b>Host</b>:Hostname of the database server</li>
 * 	<li><b>Username</b>:Username used to connect to server</li>
 * 	<li><b>Password</b>:Password used to connect to server</li>
 * 	<li><b>Database</b>:Schema name or database name on the server</li>
 * 	<li><b>Persistent</b>:Determines whether to establish persistent connections or not.
 * Default ise false (no persistent connection)</li>
 * 	<li><b>Debug</b>:Sets ADODB to run in debug mode or not. Default ise false (not in debug mode)</li>
 * 	<li><b>CharSet</b>:Charset used by the database server. Default value is null (use database servers settings)</li>
 * 	<li><b>Cache</b>:Path for ADODB cache folder. Specified in namespace format.(dot notation)
 * If not specified then a folder called 'ado' under runtime path will be created and used.</li>
 * 	<li><b>LogSQL</b>:Weather to log SQL queries to log table or not. Queries are logged to table
 *  specified by {@link setSQLLogTable SQLLogTable} property.</li>
 * 	<li><b>SQLLogTable</b>:Name of SQL log table. If not specified then
	 * default ADODB log table name will be used, which is "adodb_logsql". For more detailed info see {@link SQLLogTable}.</li>
 * </ul>
 *
 */
class ADOModule {

	private $db = null;
	private $_Driver;
	private $_Host;
	private $_Username;
	private $_Password;
	private $_Database;
	private $_Persistent = false;
	private $_Debug = false;
	private $_CharSet = null;
	private $_Cache = null;
	private $_LogSQL = false;
	private $_SQLLogTable = null;
	private $_PerfMon = null;
	private $_bulkBind = false; 

	/**
	 * Overriden function for controlling some of the require
	 * database parameters.
	 *
	 * Following parameters are required for this class;
	 * <ul>
	 * 	<li><b>Driver</b>:Database Driver</li>
	 * 	<li><b>Host</b>:Hostname of the database server</li>
	 * 	<li><b>Username</b>:Username used to connect to server</li>
	 * 	<li><b>Password</b>:Password used to connect to server</li>
	 * 	<li><b>Database</b>:Schema name or database name on the server</li>
	 * </ul>
	 * @see TModule::init()
	 */
	/*
	public function init($config) {
	
		//pre("ADOModule init");
		if (!$this->Driver) {
			throw new TConfigurationException('Missing param: Driver');
		}
		if (!$this->Host) {
			throw new TConfigurationException('Missing param: Host');
		}
		if (!$this->Username) {
			throw new TConfigurationException('Missing param: Username');
		}
		if (!$this->Password) {
			throw new TConfigurationException('Missing param: Password');
		}
		if (!$this->Database) {
			throw new TConfigurationException('Missing param: Database');
		}

		if (!$this->Cache) {
			$this->Cache = $this->getApplication()->getRunTimePath() . '/ado';
		} else {
			$this->Cache = Prado :: getPathOfNamespace($this->Cache);
		}

		if (!is_dir($this->Cache)) {
			Prado :: trace("Cache folder '{$this->Cache}' does not exists, created!", 'DB.ADOModule');
			mkdir($this->Cache);
		}

		if ($this->LogSQL && $this->SQLLogTable) {
			adodb_perf :: table($this->SQLLogTable);
		}

		global $ADODB_CACHE_DIR;
		$ADODB_CACHE_DIR = $this->Cache;

		parent :: init($config);
	}
	*/
	public function __construct() {

		$def_cfg = \Config::get('database.default');
		$config = \Config::get('database.connections.'.$def_cfg);

		$this->setDriver($config['driver']);
		$this->setHost($config['host'].':'.$config['port']);
		$this->setUsername($config['username']);
		$this->setPassword($config['password']);
		$this->setDatabase($config['database']);


	}

	/**
	 * Destructor, releases database connection.
	 */
	function __destruct() {
		$this->releaseDatabaseConnection();
	}

	/**
	 * PHP magic function.
	 * This method will pass all method calls to ADODB class/library.
	 */
	public function __call($method, $params) {
		//Prado::trace('ADOModule call forward ['.$method.']','DB.ADOModule');
		if ($this->db === null) {
			$this->createConnection();
		}
		return call_user_func_array(array (
			$this->db,
			$method
		), $params);
		
		$this->db->Execute();
		
	}

	protected function createConnection() {

		//$debug = $this->getDebug();
		/*
		if ($debug) {
			global $ADODB_EXTENSION;
			Prado :: trace('ADODB Extension Status : ' . (extension_loaded("adodb") ? "enabled (ver:${ADODB_EXTENSION})" : 'disabled'), 'DB.ADOModule');
		}
		*/
		$this->db = ADONewConnection($this->getDriver());

		$charset = $this->getCharSet();
		
		if (isset ($charset)) {
			$this->db->charSet = $charset;
			//server kitleniyor bunlar� kullan�nca.. ama t�rk�e deste�i i�in gerekli
			//			putenv('NLS_COMP=ANSI');
			//			putenv('NLS_SORT=XTURKISH');
			/*
			if ($debug) {
				Prado :: trace('Charset is=' . $charset, 'DB.ADOModule');
			}
			*/
		}
		/*
		$this->db->debug = $debug;
		*/
		$this->db->SetFetchMode(ADODB_FETCH_ASSOC);
		if ($this->getBulkBind())
			$this->db->bulkBind = true; // enable 2D Execute array
		
		if ($this->getPersistent()) {
			//For more see: http://phplens.com/lens/adodb/docs-adodb.htm#pconnect
			/*
			if ($debug) {
				Prado :: trace('New Persistent Connection', 'DB.ADOModule');
			}
			*/
			/**
			 * auto rollback �zelli�i PConnect �a��r�ld���nda
			 * otomatik rollback komutu g�nderiri ��nk�
			 * bir �nceki PHP kodu do�ru d�zg�n connection
			 * kapatmad�ysa sonraki php session'� bir �ncekinin
			 * yapt�klar�n� geri alabilmelidir. A�a��daki �zellik
			 * bunu sa�l�yor..
			 */
			$this->db->autoRollback = true; # default is false
			$this->db->PConnect($this->getHost(), $this->getUsername(), $this->getPassword(), $this->getDatabase());
		} else {
			//For more see: http://phplens.com/lens/adodb/docs-adodb.htm#connect
			/*
			if ($debug) {
				Prado :: trace('New Connection', 'DB.ADOModule');
			}
			*/
			$this->db->Connect($this->getHost(), $this->getUsername(), $this->getPassword(), $this->getDatabase());
			
		}
		/*
		if ($this->LogSQL)
			$this->db->LogSQL();
		*/	
		/*	
		Tools::pre2($this->db);
		die;
		*/
	
		return $this->db;
	}

	public function getPerfMonitor($forceCreate=false) {
		if ($this->_PerfMon===null || $forceCreate===true) {
			$this->_PerfMon = NewPerfMonitor($this->getDatabaseConnection());
		}
		return $this->_PerfMon;
	}

	public function SuspiciousSQL() {
		 return $this->getPerfMonitor()->SuspiciousSQL();
	}

	public function ExpensiveSQL() {
		 return $this->getPerfMonitor()->ExpensiveSQL();
	}

	/**
	 * Returns ADONewConnection object. if it is null then a new ADONewConnection
	 * object is created and then database connection is established.
	 * @return ADONewConnection ADODB connection object
	 */
	public function getDatabaseConnection() {
		if ($this->db === null) {
			$this->createConnection();
		}
		return $this->db;
	}

	/**
	 * Closes the database connection and destroys ADODBConnection object.
	 */
	public function releaseDatabaseConnection() {
		if ($this->db !== null) {
			$this->db->Close();
			$this->db = null;
			if ($this->getDebug()) {
				Prado :: trace('Connection Released', 'DB.ADOModule');
			}
		}
	}

	/**
	 * @return string ADODB database driver name
	 */
	public function getDriver() {
		return $this->_Driver;
	}

	/**
	 * @param string ADODB database driver name
	 */
	public function setDriver($value) {
		//$this->_Driver = TPropertyValue :: ensureString($value);
		$this->_Driver = $value;
	}

	/**
	 * @return string Hostname of the database server
	 */
	public function getHost() {
		return $this->_Host;
	}

	/**
	 * @param string Hostname of the database server
	 */
	public function setHost($value) {
		// $this->_Host = TPropertyValue :: ensureString($value);
		$this->_Host = $value;
	}

	/**
	 * @return string Username used to connect to database server
	 */
	public function getUsername() {
		return $this->_Username;
	}

	/**
	 * @param string Username used to connect to database server
	 */
	public function setUsername($value) {
		// $this->_Username = TPropertyValue :: ensureString($value);
		$this->_Username = $value;
	}

	/**
	 * @return string Password used to connect to database server
	 */
	public function getPassword() {
		return $this->_Password;
	}

	/**
	 * @param string Password used to connect to database server
	 */
	public function setPassword($value) {
		//	$this->_Password = TPropertyValue :: ensureString($value);
		$this->_Password = $value;
	}

	/**
	 * @return string Schema name or database name on the server
	 */
	public function getDatabase() {
		return $this->_Database;
	}

	/**
	 * @param string Schema name or database name on the server
	 */
	public function setDatabase($value) {
		// $this->_Database = TPropertyValue :: ensureString($value);
		$this->_Database = $value;
	}

	/**
	 * @return boolean Determines whether to establish persistent connections or not.
		 * Default ise false (no persistent connection)
	 */
	public function getPersistent() {
		return $this->_Persistent;
	}

	/**
	 * @param boolean Determines whether to establish persistent connections or not.
	 * Default ise false (no persistent connection)
	 */
	public function setPersistent($value) {
		$this->_Persistent = TPropertyValue :: ensureBoolean($value);
	}

	/**
	 * @return boolean Sets ADODB to run in debug mode or not. Default ise false (not in debug mode)
	 */
	public function getDebug() {
		return $this->_Debug;
	}

	/**
	 * @param boolean Sets ADODB to run in debug mode or not. Default ise false (not in debug mode)
	 */
	public function setDebug($value) {
		$this->_Debug = TPropertyValue :: ensureBoolean($value);
	}

	/**
	 * @return string Charset used by the database server. Default value is null (use database servers settings)
	 */
	public function getCharSet() {
		return $this->_CharSet;
	}

	/**
	 * @param string Charset used by the database server. Default value is null (use database servers settings)
	 */
	public function setCharSet($value) {
		$this->_CharSet = TPropertyValue :: ensureString($value);
	}

	/**
	 * @return string Path for ADODB cache folder. Specified in namespace format.(dot notation)
	 * If not specified then a folder called 'ado' under runtime path will be created and used.
	 */
	public function getCache() {
		return $this->_Cache;
	}

	/**
	 * @param string Path for ADODB cache folder. Specified in namespace format.(dot notation)
	 * If not specified then a folder called 'ado' under runtime path will be created and used.
	 */
	public function setCache($value) {
		$this->_Cache = TPropertyValue :: ensureString($value);
	}

	/**
	 * @return boolean Weather to log SQL queries to log table or not.
	 * Queries are logged to table specified by {@link setSQLLogTable SQLLogTable}
	 * property.
	 * @see setSQLLogTable
	 */
	public function getLogSQL() {
		return $this->_LogSQL;
	}

	/**
	 * @param boolean Weather to log SQL queries to log table or not.
	 * Queries are logged to table specified by {@link setSQLLogTable SQLLogTable}
	 * property. Default value is false
	 * @see setSQLLogTable
	 */
	public function setLogSQL($value) {
		$this->_LogSQL = TPropertyValue :: ensureBoolean($value);
	}

	/**
	 * @return string Name of SQL log table.
	 */
	public function getSQLLogTable() {
		return $this->_SQLLogTable;
	}

	/**
	 * @param string Name of SQL log table. If not specified then
	 * default ADODB log table name will be used, which is "adodb_logsql".
	 * If the adodb_logsql table does not exist, ADOdb will create
	 * the table if you have the appropriate permissions.
	 * DDL for some of the databases:
	 * <pre>
	 *
	 * 	mysql:
	 *	CREATE TABLE adodb_logsql (
	 * 	  created datetime NOT NULL,
	 *	  sql0 varchar(250) NOT NULL,
	 *	  sql1 text NOT NULL,
	 *	  params text NOT NULL,
	 *	  tracer text NOT NULL,
	 *	  timer decimal(16,6) NOT NULL
	 *	)
	 *
	 *	postgres:
	 *	CREATE TABLE adodb_logsql (
	 *	  created timestamp NOT NULL,
	 *	  sql0 varchar(250) NOT NULL,
	 *	  sql1 text NOT NULL,
	 *	  params text NOT NULL,
	 *	  tracer text NOT NULL,
	 *	  timer decimal(16,6) NOT NULL
	 *	)
	 *
	 *	mssql:
	 *	CREATE TABLE adodb_logsql (
	 *	  created datetime NOT NULL,
	 *	  sql0 varchar(250) NOT NULL,
	 *	  sql1 varchar(4000) NOT NULL,
	 *	  params varchar(3000) NOT NULL,
	 *	  tracer varchar(500) NOT NULL,
	 *	  timer decimal(16,6) NOT NULL
	 *	)
	 *
	 *	oci8:
	 *	CREATE TABLE adodb_logsql (
	 *	  created date NOT NULL,
	 *	  sql0 varchar(250) NOT NULL,
	 *	  sql1 varchar(4000) NOT NULL,
	 *	  params varchar(4000),
	 *	  tracer varchar(4000),
	 *	  timer decimal(16,6) NOT NULL
	 *	)
	 * </pre>
	 */
	public function setSQLLogTable($value) {
		$this->_SQLLogTable = TPropertyValue :: ensureString($value);
	}
	
	public function getBulkBind() {
		return $this->_bulkBind;
	}
	
	public function setBulkBind($value) {
		$this->_bulkBind = TPropertyValue :: ensureBoolean($value);
	}
}
?>