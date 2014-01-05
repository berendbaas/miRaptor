<?php
namespace lib\module\file;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Admin extends \lib\core\AbstractAdmin {
	const ROOT_NAME = 'Files';
	const ROOT_FOLDER = '/_file';
	const ROOT_URL = '/';

	const ACTION_NEW = 'new';
	const ACTION_UPLOAD = 'upload';
	const ACTION_RENAME = 'rename';
	const ACTION_REMOVE = 'remove';

	private $folder;
	private $file;
	private $fileURL;

	public function __construct(\lib\pdbc\PDBC $pdbc, \lib\core\URL $url, \lib\core\User $user, \lib\core\Website $website) {
		parent::__construct($pdbc, $url, $user, $website);

		// Check folder
		if(!isset($_GET['folder']) || strpos($_GET['folder'],'..') !== FALSE || strpos($_GET['folder'],'//') !== FALSE) {
			throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?module=file&folder=' . self::ROOT_URL, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
		}

		$this->folder = $_GET['folder'];
		$this->file = new \lib\core\File(getcwd() . '/users' . $user->getDirectory() . $website->getDirectory() . self::ROOT_FOLDER . $this->folder);
		$this->fileURL = '//' . $website->getHost() . self::ROOT_FOLDER . $this->folder;
	}

	public function run() {
		// Check file
		if(!$this->file->exists()) {
			// Check if root try to create the directory
			if($this->folder !== self::ROOT_URL || $this->file->makeDirectory(TRUE)) {
				throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?module=file&folder=' . self::ROOT_URL, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
			}

			$this->result = '<h2 class="icon icon-module-file">File</h2><p>The file module directory doesn\'t exists. Contact your system administrator.</p>';
			return;
		}

		// Check action
		if(!isset($_GET['action'])) {
			$this->result = $this->overviewPage();
			return;
		}

		switch($_GET['action']) {
			case self::ACTION_NEW:
				$this->result = $this->newPage($_SERVER['REQUEST_METHOD'] === 'POST' ? $this->newPost() : $this->newGet());
			break;

			case self::ACTION_UPLOAD:
				$this->result = $this->uploadPage($_SERVER['REQUEST_METHOD'] === 'POST' ? $this->uploadPost() : $this->uploadGet());
			break;

			case self::ACTION_RENAME:
				$this->result = $this->renamePage($_SERVER['REQUEST_METHOD'] === 'POST' ? $this->renamePost() : $this->renameGet());
			break;

			case self::ACTION_REMOVE:
				$this->result = $this->removePage($_SERVER['REQUEST_METHOD'] === 'POST' ? $this->removePost() : $this->removeGet());
			break;

			default:
				throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?module=file&folder=' . self::ROOT_URL, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
			break;
		}
	}

	/**
	 *
	 */
	public function overviewPage() {
		// Check directory
		if(!$this->file->isDirectory()) {
			throw new \lib\core\StatusCodeException($this->fileURL, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
		}

		// Breadcrumb
		$segment = explode('/', $this->folder);
		$segment[0] = self::ROOT_NAME;
		$length = count($segment) - 1;

		$breadcrumb = '<ul class="breadcrumb">';
		$folder = self::ROOT_URL;

		for($i = 0; $i < $length; $i++) {
			$breadcrumb .= '<li><a href="' . $this->url->getPath() . '?module=file&amp;folder=' . $folder . '">' . $segment[$i] . '</a></li>';
			$folder .= $segment[$i + 1] . DIRECTORY_SEPARATOR;
		}

		$breadcrumb .= '</ul>' . PHP_EOL;

		// Tables
		$table = new \lib\html\HTMLTable();
		$table->addHeaderRow(array('#','Name','Rename','Delete'));
		$number = 0;

		// Directories
		$directories = $this->file->listDirectories();
		sort($directories);

		foreach($directories as $directory) {
			$table->openRow();
			$table->addColumn(++$number);
			$table->addColumn('<a class="icon icon-folder" href="' . $this->url->getPath() . '?module=file&amp;folder=' . $this->folder . $directory . '/">' . $directory . '</a');
			$table->addColumn('<a class="icon icon-rename" href="' . $this->url->getPath() . '?module=file&amp;action=' . self::ACTION_RENAME . '&amp;folder=' . $this->folder . $directory . '/"></a>');
			$table->addColumn('<a class="icon icon-remove" href="' . $this->url->getPath() . '?module=file&amp;action=' . self::ACTION_REMOVE . '&amp;folder=' . $this->folder . $directory . '/"></a>');
			$table->closeRow();
		}

		// Files
		$files = $this->file->listFiles();
		sort($files);

		foreach($files as $file) {
			$table->openRow();
			$table->addColumn(++$number);
			$table->addColumn('<a class="icon icon-file" href="' . $this->fileURL . $file . '" target="_blank">' . $file . '</span>');
			$table->addColumn('<a class="icon icon-rename" href="' . $this->url->getPath() . '?module=file&amp;action=' . self::ACTION_RENAME . '&amp;folder=' . $this->folder . $file . '"></a>');
			$table->addColumn('<a class="icon icon-remove" href="' . $this->url->getPath() . '?module=file&amp;action=' . self::ACTION_REMOVE . '&amp;folder=' . $this->folder . $file . '"></a>');
			$table->closeRow();
		}

		return '<h2 class="icon icon-module-file">File</h2>' . $breadcrumb . $table . '<p><a class="icon icon-new" href="' . $this->url->getPath() . '?module=file&amp;action=' . self::ACTION_NEW . '&amp;folder=' . $this->folder . '">New folder</a><a class="icon icon-upload" href="' . $this->url->getPath() . '?module=file&amp;action=' . self::ACTION_UPLOAD . '&amp;folder=' . $this->folder . '">Upload files</a></p>';
	}

	/**
	 *
	 */
	public function newGet() {
		return array(
			'name' => '',
			'error' => ''
		);
	}

	/**
	 *
	 */
	public function newPost() {
		$field = $this->newGet();

		// Check fields
		if(!isset($_POST['name'])) {
			$field['error'] = '<p class="msg-warning">Require name.</p>';
			return $field;
		}

		$field['name'] = $_POST['name'];
		$directory = new \lib\core\File($this->file->getPath() . DIRECTORY_SEPARATOR . $field['name']);

		// Create directory
		if(!$directory->makeDirectory()) {
			$field['error'] = '<p class="msg-error">Directory already exists.</p>';
			return $field;
		}

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?module=file&folder=' . $this->folder, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	public function newPage($field) {
		$form = new \lib\html\HTMLFormStacked();

		$form->addInput('Name', array(
			'type' => 'text',
			'id' => 'form-name',
			'name' => 'name',
			'placeholder' => 'Name',
			'value' => $field['name']
		));

		$form->addContent('<a href="' . $this->url->getPath() . '?module=file&amp;folder=' . $this->folder . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-file">New directory</h2>' . $field['error'] . $form->__toString();
	}

	/**
	 *
	 */
	public function uploadGet() {
		return array('error' => '');
	}

	/**
	 *
	 */
	public function uploadPost() {
		$field = $this->uploadGet();

		// Check fields
		if(!isset($_FILES['file'])) {
			$field['error'] = '<p class="msg-warning">Require file.</p>';
			return $field;
		}

		// Check folder
		if(!$this->file->isDirectory()) {
			$field['error'] = '<p class="msg-warning">You can only upload to an existing folder.</p>';
			return $field;
		}

		// Check upload
		$uploads = \lib\core\File::multiUpload($_FILES['file'], $this->file->getPath(), TRUE);
		$errors = array();

		foreach($uploads as $upload) {
			if($upload['file'] === NULL) {
				$errors[] = $upload['name'];
			}
		}

		if($errors !== array()) {
			$list = new \lib\html\HTMLList();
			$list->addItems($errors);

			$field['error'] = '<p class="msg-error">The following files weren\'t uploaded correctly.</p>' . $list;
			return $field;
		}

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?module=file&folder=' . $this->folder, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	public function uploadPage($field) {
		$form = new \lib\html\HTMLFormStacked(array(
			'method' => 'post',
			'action' => '',
			'enctype' => 'multipart/form-data'
		));

		$form->addInput('File', array(
			'type' => 'file',
			'id' => 'form-name',
			'name' => 'file[]',
			'placeholder' => 'File',
			'multiple' => 'multiple'
		));

		$form->addContent('<a href="' . $this->url->getPath() . '?module=file&amp;folder=' . $this->folder . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-file">Upload files</h2>' . $field['error'] . $form->__toString();
	}

	/**
	 *
	 */
	public function renameGet() {
		return array(
			'name' => $this->file->getName(),
			'error' => ''
		);
	}

	/**
	 *
	 */
	public function renamePost() {
		$field = $this->renameGet();

		// Check root
		if($this->folder === self::ROOT_URL) {
			$field['error'] = '<p class="msg-warning">Can\'t rename the root folder.</p>';
			return $field;
		}

		// Check fields
		if(!isset($_POST['name'])) {
			$field['error'] = '<p class="msg-warning">Require name.</p>';
			return $field;
		}

		$field['name'] = $_POST['name'];
		$file = new \lib\core\File();

		// Rename
		if(!$this->file->rename($field['name'])) {
			$field['error'] = '<p class="msg-warning">The given name is in use.</p>';
			return $field;
		}

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?module=file&folder=' . dirname($this->folder) . '/', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	public function renamePage($field) {
		$form = new \lib\html\HTMLFormStacked();

		$form->addInput('Name', array(
			'type' => 'text',
			'id' => 'form-name',
			'name' => 'name',
			'placeholder' => 'Name',
			'value' => $field['name']
		));

		$form->addContent('<a href="' . $this->url->getPath() . '?module=file&amp;folder=' . dirname($this->folder) . '/"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-file">Rename file</h2>' . $field['error'] . $form->__toString();
	}

	/**
	 *
	 */
	public function removeGet() {
		return array(
			'error' => ''
		);
	}

	/**
	 *
	 */
	public function removePost() {
		if($this->file->isDirectory()) {
			if($this->folder === self::ROOT_URL || !$this->file->removeDirectory(TRUE)) {
				return array(
					'error' => '<p class="msg-error">Can\'t remove this directory. Please try again.</p>'
				);
			}
		} else {
			if(!$this->file->removeFile()) {
				return array(
					'error' => '<p class="msg-error">Can\'t remove this file. Please try again.</p>'
				);
			}
		}

		throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?module=file&folder=' . dirname($this->folder) . '/', \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
	}

	/**
	 *
	 */
	public function removePage($field) {
		$form = new \lib\html\HTMLFormStacked();

		// Check directory
		if($this->file->isDirectory()) {
			$files = $this->file->listAll(TRUE);

			// Check files
			if($files !== array()) {
				$list = new \lib\html\HTMLList();
				$list->addItems($files);

				$form->addContent('<p>This folder contains the following items.</p>' . $list);
			}
		}

		$form->addContent('<p>Are you sure you want to permanently remove this ' . ($this->file->isDirectory() ? 'directory' : 'file') . '? This action can\'t be undone!</p>');

		$form->addContent('<a href="' . $this->url->getPath() . '?module=file&amp;folder=' . dirname($this->folder) . '/"><button type="button">Back</button></a>');

		$form->addButton('Yes', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-file">Remove file</h2>' . $field['error'] . $form->__toString();
	}
}

?>
