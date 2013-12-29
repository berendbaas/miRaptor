<?php
namespace lib\module\file;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Admin extends \lib\core\AbstractAdmin {
	const FOLDER_DEFAULT = '/';
	const FOLDER_FILESYSTEM = '/_file';
	const FOLDER_HOME = 'Files';

	const ACTION_NEW = 'new';
	const ACTION_UPLOAD = 'upload';
	const ACTION_RENAME = 'rename';
	const ACTION_MOVE = 'move';
	const ACTION_REMOVE = 'remove';

	private $folder;
	private $file;
	private $fileURL;

	public function __construct(\lib\pdbc\PDBC $pdbc, \lib\core\URL $url, \lib\core\User $user, \lib\core\Website $website) {
		parent::__construct($pdbc, $url, $user, $website);

		// Check get
		if(!isset($_GET['folder']) || strpos($_GET['folder'],'..') !== FALSE) {
			throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?module=file&folder=' . self::FOLDER_DEFAULT, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
		}

		$this->folder = $_GET['folder'];
		$this->file = new \lib\core\File(getcwd() . '/users' . $user->getDirectory() . $website->getDirectory() . self::FOLDER_FILESYSTEM . $this->folder);
		$this->fileURL = '//' . $website->getDomain() . self::FOLDER_FILESYSTEM . $this->folder;

		// Check exists
		if(!$this->file->exists()) {
			throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?module=file&folder=' . self::FOLDER_DEFAULT, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
		}
	}

	public function run() {
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

			case self::ACTION_MOVE:
				$this->result = $this->movePage($_SERVER['REQUEST_METHOD'] === 'POST' ? $this->movePost() : $this->moveGet());
			break;

			case self::ACTION_REMOVE:
				$this->result = $this->removePage($_SERVER['REQUEST_METHOD'] === 'POST' ? $this->removePost() : $this->removeGet());
			break;

			default:
				throw new \lib\core\StatusCodeException($this->url->getURLPath() . '?module=file&folder=' . self::FOLDER_DEFAULT, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
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
		$segment[0] = self::FOLDER_HOME;
		$length = count($segment) - 1;

		$breadcrumb = '<ul class="breadcrumb">';
		$folder = self::FOLDER_DEFAULT;

		for($i = 0; $i < $length; $i++) {
			$breadcrumb .= '<li><a href="' . $this->url->getPath() . '?module=file&amp;folder=' . $folder . '">' . $segment[$i] . '</a></li>';
			$folder .= $segment[$i + 1] . DIRECTORY_SEPARATOR;
		}

		$breadcrumb .= '</ul>' . PHP_EOL;

		// Tables
		$table = new \lib\html\HTMLTable();
		$table->addHeaderRow(array('#','Name','Rename','Move','Delete'));
		$number = 0;

		// Directories
		$directories = $this->file->listDirectories();
		sort($directories);

		foreach($directories as $directory) {
			$table->openRow();
			$table->addColumn(++$number);
			$table->addColumn('<a class="icon icon-folder" href="' . $this->url->getPath() . '?module=file&amp;folder=' . $this->folder . $directory . '/">' . $directory . '</a');
			$table->addColumn('<a class="icon icon-rename" href="' . $this->url->getPath() . '?module=file&amp;action=' . self::ACTION_RENAME . '&amp;folder=' . $this->folder . $directory . '/"></a>');
			$table->addColumn('<a class="icon icon-move" href="' . $this->url->getPath() . '?module=file&amp;action=' . self::ACTION_MOVE . '&amp;folder=' . $this->folder . $directory . '/"></a>');
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
			$table->addColumn('<a class="icon icon-move" href="' . $this->url->getPath() . '?module=file&amp;action=' . self::ACTION_MOVE . '&amp;folder=' . $this->folder . $file . '"></a>');
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
			'message' => ''
		);
	}

	/**
	 *
	 */
	public function newPost() {
		$field = $this->newGet();

		// Check fields
		if(!isset($field['name'])) {
			$field['message'] = '<p class="msg-warning">Require name.</p>';
			return $field;
		}

		$field['name'] = $_POST['name'];
		$directory = new \lib\core\File($this->file->getPath() . DIRECTORY_SEPARATOR . $field['name']);

		// Create directory
		if(!$directory->makeDirectory()) {
			$field['message'] = '<p class="msg-warning">Directory already exists.</p>';
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

		return '<h2 class="icon icon-module-file">New directory</h2>' . $field['message'] . $form->__toString();
	}

	/**
	 *
	 */
	public function uploadGet() {
		return array('message' => '');
	}

	/**
	 *
	 */
	public function uploadPost() {
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

			return array(
				'message' => '<p class="msg-error">The following files weren\'t uploaded correctly.</p>' . $list
			);
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

		return '<h2 class="icon icon-module-file">Upload files</h2>' . $field['message'] . $form->__toString();
	}

	/**
	 *
	 */
	public function renameGet() {
		return array(
			'name' => $this->file->getName(),
			'message' => ''
		);
	}

	/**
	 *
	 */
	public function renamePost() {
		return '';
	}

	/**
	 *
	 */
	public function renamePage($field) {
		return $field['name'];
	}

	/**
	 *
	 */
	public function moveGet() {
		return '';
	}

	/**
	 *
	 */
	public function movePost() {
		return '';
	}

	/**
	 *
	 */
	public function movePage($field) {
		return '';
	}

	/**
	 *
	 */
	public function removeGet() {
		return array(
			'message' => ''
		);
	}

	/**
	 *
	 */
	public function removePost() {
		if($this->file->isDirectory()) {
			if($this->file->getPath === self::FOLDER_DEFAULT || !$this->file->removeDirectory(TRUE)) {
				return array(
					'message' => '<p class="msg-error">Can\'t remove this directory. Please try again.</p>'
				);
			}
		} else {
			if(!$this->file->removeFile()) {
				return array(
					'message' => '<p class="msg-error">Can\'t remove this file. Please try again.</p>'
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

		if($this->file->isDirectory()) {
			$form->addContent('<p>Are you sure you want to remove this directory? This action can\'t be undone!</p>');
		} else {
			$form->addContent('<p>Are you sure you want to remove this file? This action can\'t be undone!</p>');
		}

		$form->addContent('<a href="' . $this->url->getPath() . '?module=file' . '"><button type="button">No</button></a>');

		$form->addButton('Yes', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-module-theme">Remove file</h2>' . $field['message'] . $form->__toString();
	}
}

?>
