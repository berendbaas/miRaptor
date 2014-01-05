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
	 * Constructs a File object with the given path.
	 *
	 * @param String $path
	 */
	public function __construct($path) {
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
	 * Returns the time of the last modification as a unixtimestap, or -1 on failure.
	 *
	 * @return int the time of the last modification as a unixtimestap, or -1 on failure.
	 */
	public function lastModified() {
		return ($result = filemtime($this->path)) === FALSE ? -1 : $result;
	}

	/**
	 * Returns the numer of bytes in the file, or -1 on failure.
	 *
	 * @return int the number of bytes in the file, or -1 on failure.
	 */
	public function length() {
		return ($result = filesize($this->path)) === FALSE ? -1 : $result;
	}

	/**
	 * Returns an array with the files in the current directory.
	 *
	 * @param  boolean $recursive = FALSE
	 * @param  boolean $showHidden = FALSE
	 * @return array   an array with the files in the current directory.
	 */
	public function listAll($recursive = FALSE, $showHidden = FALSE) {
		// Check file
		if(!$this->isDirectory()) {
			return NULL;
		}

		// Check flags
		$flags = \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_FILEINFO;

		if(!$showHidden) {
			$flags = $flags | \FilesystemIterator::SKIP_DOTS;
		}

		// Check recursive
		if($recursive) { //
			$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->path, $flags), \RecursiveIteratorIterator::SELF_FIRST);
		} else {
			$iterator = new \FilesystemIterator($this->path, $flags);
		}

		// Iterate
		$list = array();

		foreach($iterator as $index => $element) {
			$list[] = $element->getFilename();
		}

		return $list;
	}

	/**
	 * Returns an array with the files in the current directory.
	 *
	 * @param  boolean $recursive = FALSE
	 * @param  boolean $showHidden = FALSE
	 * @return array   an array with the files in the current directory.
	 */
	public function listFiles($recursive = FALSE, $showHidden = FALSE) {
		// Check file
		if(!$this->isDirectory()) {
			return NULL;
		}

		// Check flags
		$flags = \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_FILEINFO;

		if(!$showHidden) {
			$flags = $flags | \FilesystemIterator::SKIP_DOTS;
		}

		// Check recursive
		if($recursive) { //
			$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->path, $flags), \RecursiveIteratorIterator::SELF_FIRST);
		} else {
			$iterator = new \FilesystemIterator($this->path, $flags);
		}

		// Iterate
		$list = array();

		foreach($iterator as $index => $element) {
			if($element->isFile()) {
				$list[] = $element->getFilename();
			}
		}

		return $list;
	}

	/**
	 * Returns an array with the directories in the current directory.
	 *
	 * @param  boolean $recursive = FALSE
	 * @param  boolean $showHidden = FALSE
	 * @return array   an array with the directories in the current directory.
	 */
	public function listDirectories($recursive = FALSE, $showHidden = FALSE) {
		// Check file
		if(!$this->isDirectory()) {
			return NULL;
		}

		// Check flags
		$flags = \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_FILEINFO;

		if(!$showHidden) {
			$flags = $flags | \FilesystemIterator::SKIP_DOTS;
		}

		// Check recursive
		if($recursive) { //
			$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->path, $flags), \RecursiveIteratorIterator::SELF_FIRST);
		} else {
			$iterator = new \FilesystemIterator($this->path, $flags);
		}

		// Iterate
		$list = array();

		foreach($iterator as $index => $element) {
			if($element->isDir()) {
				$list[] = $element->getFilename();
			}
		}

		return $list;
	}

	/**
	 * Returns true if the file has been created.
	 *
	 * @param  boolean $override = FALSE
	 * @return boolean true if the file has been created.
	 */
	public function makeFile($override = FALSE) {
		return !$this->exists() || $override ? (file_put_contents($this->path, '') === FALSE ? TRUE : FALSE) : FALSE;
	}

	/**
	 * Returns true if the directory has been created.
	 *
	 * @param  boolean $recursive = FALSE
	 * @param  int     $permissions = 0755
	 * @return boolean true if the directory has been created.
	 */
	public function makeDirectory($recursive = FALSE, $permissions = 0775) {
		$old = umask(0777 - $permissions);
		$result = mkdir($this->path, $permissions, $recursive);
		umask($old);

		return $result;
	}

	/**
	 * Returns true if the file is succesfully moved.
	 *
	 * @param  String  $path
	 * @param  boolean $override = FALSE
	 * @return boolean true if the file is succesfully moved.
	 */
	public function move($path, $override = FALSE) {
		// Check if the file exists
		if(file_exists($path) && !$override) {
			return FALSE;
		}

		// Rename the file
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
	public function removeFile() {
		return unlink($this->path);
	}

	/**
	 * Returns true if the directory is succesfully removed.
	 *
	 * @param  boolean $recursive = FALSE
	 * @return boolean true if the directory is succesfully removed.
	 */
	public function removeDirectory($recursive = FALSE) {
		if($recursive) {
			foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->path, \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST) as $path) {
   				$path->isFile() ? unlink($path->getPathname()) : rmdir($path->getPathname());
			}
		}

		return rmdir($this->path);
	}

	/**
	 * Returns true if the file is succesfully renamed.
	 *
	 * @param  String  $file
	 * @param  boolean $override = FALSE
	 * @return boolean true if the file is succesfully renamed.
	 */
	public function rename($file, $override = FALSE) {
		$path = $this->directory . DIRECTORY_SEPARATOR . basename($file);

		// Check if the file exists
		if(file_exists($path) && !$override) {
			return FALSE;
		}

		// Rename the file
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
		// Check vars
		if(!isset($file['tmp_name'], $file['name'], $file['error'])) {
			return NULL;
		}

		// Check errors
		if(!is_uploaded_file($file['tmp_name']) || $file['error'] > 0) {
			return NULL;
		}

		$upload = new File($directory . DIRECTORY_SEPARATOR . $file['name']);

		// Check file
		if($upload->exists() && !$override) {
			return NULL;
		}

		return move_uploaded_file($file['tmp_name'], $upload->getPath()) ? $upload  : NULL;
	}

	/**
	 * Returns an array with the uploaded files.
	 *
	 * array(
	 *     index => array(
	 *         'name' => $filename,
	 *         'file' => new File($directory . $filename)
	 *     )
	 * )
	 *
	 * @param  array   $files
	 * @param  string  $directory
	 * @param  boolean $override = FALSE
	 * @return array an array with the uploaded files.
	 */
	public static function multiUpload($files, $directory, $override = FALSE) {
		$result = array();

		foreach($files['name'] as $key => $value) {
			// New
			$new = array(
				'name' => $files['name'][$key],
				'file' => NULL
			);

			// Check vars
			if(!isset($files['tmp_name'][$key], $files['error'][$key])) {
				$result[] = $new;
				continue;
			}

			// Check errors
			if(!is_uploaded_file($files['tmp_name'][$key]) || $files['error'][$key] > 0) {
				$result[] = $new;
				continue;
			}

			$upload = new File($directory . DIRECTORY_SEPARATOR . $files['name'][$key]);

			// Check file
			if($upload->exists() && !$override) {
				$result[] = $new;
				continue;
			}

			// Add file
			$new['file'] = (move_uploaded_file($files['tmp_name'][$key], $upload->getPath()) ? $upload : NULL);
			$result[] = $new;
		}

		return $result;
	}
}

?>