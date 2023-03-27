<?php
/**
 * @packageName cronjob
 * @packageDescription php cronjob
 * @packageVersion 1.0.1
 * @packageAuthor trfoxs
 * @packageLicense MIT License
 * 
 *  @link https://github.com/trfoxs/php-cronjobs 
 * 
 */
class cronjob {
	/**
	 * Error report
	 * @var	string
	 */
	private $error = null;
	
	/**
	 * cronjobs strings
	 * @var	string
	 */
	public $minute = '*/60', $hour = '*', $day = '*', 
		   $month = '*', $week = '*', $run;
	
	/**
	 * cronjobs exec output
	 * @var	string
	 */
	protected $output;
	
	/**
	 * cronjobs validate switch
	 * @var	string
	 */
	protected $type;
	
	/**
	 * cronjobs document root
	 * @var	string
	 */
	protected $rootpath = null;
	
	/**
	 * cronjobs exec status
	 * @var	int
	 */
	private $status;
	
	/**
	 * cronjobs exec statuslist
	 * Bash Exit Codes
	 * @var	array
	 */
	private $statuslist = array(
		0 => true, 
		1 => true, 
		2 => 'Missing keyword or command', 
		126=>'Permission problem or command is not an executable', 
		127=>'Command not found',
	);
	
	/**
	 * cronjobs crons full command
	 * @var	string
	 */
	private $crons;
	
	public function __construct() {
		if (preg_match( '/httpdocs$/i' , $_SERVER['DOCUMENT_ROOT'])) { /*plesk*/
			$this->rootpath = 'httpdocs/';
		}elseif(preg_match( '/public_html$/i' , $_SERVER['DOCUMENT_ROOT'])) { /*cpanel, vestacp, cyberpanel etc*/
			$this->rootpath = 'public_html/';
		}
	}
	
	/**
	 * cronjob insert crontab
	 */
	public function add() {
		$this->crons = "{$this->minute} {$this->hour} {$this->day} {$this->month} {$this->week} php -f {$this->rootpath}{$this->run}";

		$result = $this->_exec("(crontab -l ; echo '{$this->crons}') | sort | uniq | crontab");

		if (!$result) {
			$this->error = $this->output;
		}
	}
	
	/**
	 * cronjob remove crontab
	 */
	public function remove() {
		$query = $this->_exec("crontab -l");
		$cron_jobs = explode("\\n", $query);
		
		$this->crons = "{$this->minute} {$this->hour} {$this->day} {$this->month} {$this->week} php -f {$this->rootpath}{$this->run}";
		$removed = str_replace($this->crons,"",$query); 
		
		$result = $this->_exec("echo '{$removed}' | sort | uniq | crontab");

		if (!$result) {
			$this->error = $this->output;
		}
	}
	
	/**
	 * private (string) error
	 * error report
	 */
	public function error() {
		if ($this->valid($this->run, 'empty')) {
			$this->error = 'Komut dosya&yolu için veri gönderiniz!';
		}
		
		if ($this->statuslist[$this->status] !== true) {
			$this->error = $this->statuslist[$this->status];
		}

		return $this->error;
	}
	
	/**
	 * preg_match, empty, is_null validate
	 * type int|numeric, empty
	 * @link https://www.php.net/manual/en/function.preg-match
	 * 		 https://www.php.net/manual/en/function.empty
	 * 		 https://www.php.net/manual/en/function.is-null
	 */
	protected function valid($value, $type = 'word') {		
		if ($type == 'numeric' && $type == 'int') {
			if (preg_match('/^[1-9-][0-9-]+$/i',$value)) {
				return true;
			}else{
				return false;
			}
		}
		
		if ($type == 'empty') {
			if (empty($value) && is_null($value)) {
				return true;
			}else{
				return false;
			}
		}
	}
	
	/**
	 * php exec
	 * @var string & int
	 * @link https://www.php.net/manual/en/function.exec
	 */
	protected function _exec($value) {
		return exec($value, $this->output, $this->status);
	}
}