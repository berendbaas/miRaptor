<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class File {
	private $path;
	private $directory;
	private $file;

	/**
	 * Constructs a File object.
	 *
	 * @param String $path = ''
	 */
	public function __construct($path = '') {
		$this->directory = dirname($path);
		$this->file = basename($path);
		$this->path = $this->directory . DIRECTORY_SEPARATOR . $this->file;
	}

	/**
	 * Returns true if you can execute the file.
	 *
	 * @return boolean true if you can execute the file.
	 */
	public function canExecute() {
		return is_executable($this->path);
	}

	/**
	 * Returns true if you can read the file.
	 *
	 * @return boolean true if you can read the file.
	 */
	public function canRead() {
		return is_readable($this->path);
	}

	/**
	 * Returns true if you can write the file.
	 *
	 * @return boolean true if you can write the file.
	 */
	public function canWrite() {
		return is_writeable($this->path);
	}

	/**
	 * Returns true if the file exists.
	 *
	 * @return boolean true if the file exists.
	 */
	public function exists() {
		return file_exists($this->path);
	}

	/**
	 * Returns true if the file is a file.
	 *
	 * @return boolean true if the file is a file.
	 */
	public function isFile() {
		return is_file($this->path);
	}

	/**
	 * Returns true if the file is a directory.
	 *
	 * @return boolean true if the file is a directory.
	 */
	public function isDirectory() {
		return is_dir($this->path);
	}

	/**
	 * Returns the path of the file.
	 *
	 * @return string the path of the file.
	 */
	public function getPath() {
		return $this->path;
	}

	/**
	 * Returns the directory of the file.
	 *
	 * @return string the directory of the file.
	 */
	public function getDirectory() {
		return $this->directory;
	}

	/**
	 * Returns the name of the file.
	 *
	 * @return string the name of the file.
	 */
	public function getName() {
		return $this->file;
	}

	/**
	 * Returns the time of the last modification as a unixtimestap.
	 *
	 * @return int the time of the last modification as a unixtimestap.
	 */
	public function getLastModified() {
		return ($result = filemtime($this->path)) === FALSE ? -1 : $result;
	}

	/**
	 * Returns the numer of bytes in the file.
	 *
	 * @return int the number of bytes in the file.
	 */
	public function getLength() {
		return ($result = filesize($this->path)) === FALSE ? -1 : $result;
	}

	/**
	 * Returns an array with the files in the current directory.
	 *
	 * @return array an array with the files in the current directory.
	 */
	public function listAll() {
		if(!$this->isDirectory() || !($iterator = dir($this->path))) {
			return NULL;
		}

		$list = array();

		while(($item = $iterator->read()) !== FALSE) {
			$list[] = $item;
		}

		return $list;
	}

	/**
	 * Returns an array with the files in the current directory.
	 *
	 * @return array an array with the files in the current directory.
	 */
	public function listFiles() {
		if(!$this->isDirectory() || !($iterator = dir($this->path))) {
			return NULL;
		}

		$list = array();

		while(($item = $iterator->read()) !== FALSE) {
			if(is_file($this->path . DIRECTORY_SEPARATOR . $item)) {
				$list[] = $item;
			}
		}

		return $list;
	}

	/**
	 * Returns an array with the directory in the current directory.
	 *
	 * @return array an array with the directory in the current directory.
	 */
	public function listDirectories() {
		if(!$this->isDirectory() || !($iterator = dir($this->path))) {
			return NULL;
		}

		$list = array();

		while(($item = $iterator->read()) !== FALSE) {
			if(is_dir($this->path . DIRECTORY_SEPARATOR . $item)) {
				$list[] = $item;
			}
		}

		return $list;
	}

	/**
	 * Returns true if the file has been created.
	 *
	 * @return boolean true if the file has been created.
	 */
	public function create($override = FALSE) {
		return !exists($new) || $override ? (file_put_contents($this->path, '') === FALSE ? TRUE : FALSE) : FALSE;
	}

	/**
	 * Returns true if the file is succesfully moved.
	 *
	 * @param  String  $path
	 * @param  boolean $override = FALSE
	 * @return boolean true if the file is succesfully moved.
	 */
	public function move($path, $override = FALSE) {
		if(exists($new) && !$override) {
			return FALSE;
		}

		if(!rename($this->path, $path)) {
			return FALSE;
		}

		$this->path = $path;
		return TRUE;
	}

	/**
	 * Returns true if the file is succesfully removed.
	 *
	 * @return boolean true if the file is succesfully removed.
	 */
	public function remove() {
		return unlink($this->path);
	}

	/**
	 * Returns true if the file is succesfully renamed.
	 *
	 * @param  String  $file
	 * @param  boolean $override = FALSE
	 * @return boolean true if the file is succesfully renamed.
	 */
	public function rename($file, $override = FALSE) {
		if(exists($new) && !$override) {
			return FALSE;
		}

		$path = $this->directory . DIRECTORY_SEPARATOR . basename($file);

		if(!rename($this->path, $path)) {
			return FALSE;
		}

		$this->path = $path;
		return TRUE;
	}

	/**
	 * Returns the uploaded file, or NULL on failure.
	 *
	 * @param  array   $file
	 * @param  string  $directory
	 * @param  boolean $override = FALSE
	 * @return File the uploaded file or NULL on failure.
	 */
	public static function upload($file, $directory, $override = FALSE) {
		if(!isset($file['tmp_name'], $file['name'], $file['error']) && $file['error'] > 0) {
			return NULL;
		}

		$file = new File($file['tmp_name']);

		return $file->move($directory . DIRECTORY_SEPARATOR . $file['name'], $override) ? $file : NULL;
	}

	/**
	 * Returns an array with the uploaded files.
	 *
	 * @param  array   $files
	 * @param  string  $directory
	 * @param  boolean $override = FALSE
	 * @return array an array with the uploaded files.
	 */
	public static function multiUpload($files, $directory, $override = FALSE) {
		$result = array();

		foreach($files['name'] as $key => $value) {
			if($files['error'][$key] > 0) {
				$result[] = NULL;
				continue;
			}

			$file = new File($file['tmp_name'][$key]);
			$result[] = $file->move($directory . DIRECTORY_SEPARATOR . $value, $override) ? $file : NULL;
		}

		return $result;
	}
}

?>