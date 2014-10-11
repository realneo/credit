<?php

class Logs {

	const DEBUG = 1;
	const INFO = 2;
	const WARN = 3;
	const ERROR = 4;
	const FATAL = 5;

	private static $logs = array();

	private static $maxLevel = 1;

	private static $save = true;

	private static function prepareArgs( $args ) {
		$result = '';
		foreach( $args as $arg ) {
			try {
				if( is_array( $arg ) || is_object( $arg ) ) {
					$result .= var_export( $arg, true );
				}
				else {
					$result .= '' . $arg;
				}
			}
			catch( Exception $e ) {
				$result .= '[Can\'t convert arg to string]';
			}
		}
		return str_replace( "\n", ' ', $result );
	}

	public static function debug( $log ) {
		if( ! self::$save ) {
			return;
		}
		self::$logs[] = '[debug] ' . self::prepareArgs( func_get_args() );
	}

	public static function info( $log ) {
		if( ! self::$save ) {
			return;
		}
		if( self::$maxLevel < self::INFO) {
			self::$maxLevel = self::INFO;
		}
		self::$logs[] = '[info] ' . self::prepareArgs( func_get_args() );
	}

	public static function warn( $log ) {
		if( ! self::$save ) {
			return;
		}
		if( self::$maxLevel < self::WARN) {
			self::$maxLevel = self::WARN;
		}
		self::$logs[] = '[warn] ' . self::prepareArgs( func_get_args() );
	}

	public static function error( $log ) {
		if( ! self::$save ) {
			return;
		}
		if( self::$maxLevel < self::ERROR) {
			self::$maxLevel = self::ERROR;
		}
		self::$logs[] = '[error] ' . self::prepareArgs( func_get_args() );
	}

	public static function fatal( $log ) {
		if( ! self::$save ) {
			return;
		}
		if( self::$maxLevel < self::FATAL) {
			self::$maxLevel = self::FATAL;
		}
		self::$logs[] = '[FATAL] ' . self::prepareArgs( func_get_args() );
	}

	public static function getLogs() {
		return self::$logs;
	}

	public static function clearLogs() {
        self::$logs = array();
	}
    
    public static function printLogs($preformat=false) {
        if($preformat) echo('<pre>');
        foreach(self::$logs as $log) echo $log, "\n";
        if($preformat) echo('</pre>');
    }

	public static function getLevel() {
		return self::$maxLevel;
	}

	public static function setSave( $save ) {
		self::$save = $save;
	}

	public static function isSave() {
		return self::$save;
	}

}
?>