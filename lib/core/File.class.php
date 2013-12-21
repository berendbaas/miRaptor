<?php
namespace lib\core;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class File {
	private $user;
	private $website;
	private $path;
	private $directory;
	private $file;

	/**
	 * Constructs a File object.
	 *
	 * @param User    $user
	 * @param Website $website
	 * @param String  $path = ''
	 */
	public function __construct(User $user, Website $website, $path = '') {
		$this->user = $user;
		$this->website = $website;

		// Split URI in directory, file
		$pos = strrpos($path, '/') + 1;

		// Set directory, file & path.
		$this->directory = substr($path, 0, $pos);
		$this->file = strlen($path) > $pos ? substr($path, $pos) : '';
		$this->path = $this->directory . $this->file;
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
		return $this->name;
	}

	/**
	 * Returns the time of the last modification as a unixtimestap.
	 *
	 * @return int the time of the last modification as a unixtimestap.
	 */
	public function getLastModified() {
		return filemtime($this->path);
	}

	/**
	 * Return the numer of bytes in the file.
	 *
	 *
	 */
	public function getLength() {
		return filesize($this->path);
	}

	/**
	 *
	 */
	public function listAll() {
		if(!$this->isDirectory()) {
			return NULL;
		}
	}

	/**
	 *
	 */
	public function listFiles() {
		if(!$this->isDirectory()) {
			return NULL;
		}
	}

	/**
	 *
	 */
	public function listDirectories() {
		if(!$this->isDirectory()) {
			return NULL;
		}
	}

	/**
	 *
	 */
	public function create() {

	}

	/**
	 *
	 */
	public function move($new, $override = FALSE) {
		return !exists($new) || $override ? rename($old, $new) : FALSE;
	}

	/**
	 *
	 */
	public function remove() {
		return unlink($this->path);
	}

	/**
	 *
	 */
	public function rename($file) {
		$this->

		return rename($this->path, $new);
	}
}

?>
