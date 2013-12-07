<?php
namespace lib\module\admin;

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class ModulePageDashboard extends ModulePageAbstract {
	private $website;

	public function __construct(\lib\pdbc\PDBC $pdbc, \lib\core\URL $url, $redirect, $website) {
		parent::__construct($pdbc, $url, $redirect);
		$this->website = $website;

		$this->isNamespace = TRUE;
	}

	public function run() {
		// Check session
		if(!$this->session->isSignedIn()) {
			throw new \lib\core\StatusCodeException($this->redirect, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
		}

		// Check dashboard
		if($this->url->getFile() === '') {
			$this->result = $this->dashboardPage($this->dashboardGet());
			return;
		}

		$id = intval($this->url->getFile());

		// Check numeric & website access
		if(!is_numeric($this->url->getFile()) || !$this->session->hasAccessWebsite($id)) {
			throw new \lib\core\StatusCodeException($this->redirect, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
		}

		$this->result = $this->settingsPage($_SERVER['REQUEST_METHOD'] === 'POST' ? $this->settingsPost($id) : $this->settingsGet($id));

	}

	/**
	 *
	 */
	private function settingsGet($id) {
		$this->pdbc->query('SELECT `name`, `domain`, `active`
		                    FROM `website`
		                    WHERE `id` = ' . $this->pdbc->quote($id) . '
		                    AND`uid` = ' . $this->pdbc->quote($this->session->getUserID()));

		return $this->pdbc->fetch() + array(
			'message' => ''
		);
	}

	/**
	 *
	 */
	private function settingsPost($id) {
		if(!isset($_POST['name'], $_POST['domain'])) {
			$fields = $this->settingsGet($id);
			$fields['message'] = '<p class="msg-warning">Require name and domain.</p>';
			return $fields;
		}

		$fields = array(
			'name' => $_POST['name'],
			'domain' => $_POST['domain'],
			'active' => (isset($_POST['active']) ? 1 : 0),
			'message' => ''
		);

		$this->pdbc->query('UPDATE `website`
		                    SET `name` =  "' . $this->pdbc->quote($fields['name']) . '",
		                        `domain` =  "' . $this->pdbc->quote($fields['domain']) . '",
					`active` =  "' . $this->pdbc->quote($fields['active']) . '"
		                    WHERE `id` = "' . $this->pdbc->quote($id) . '"
		                    AND `uid` = "' . $this->pdbc->quote($this->session->getUserID()) . '"');

		if($this->pdbc->rowCount()) {
			$fields['message'] = '<p class="msg-succes">Your changes have been saved successfully</p>';
		}

		return $fields;
	}

	/**
	 *
	 */
	private function settingsPage($fields) {

		$form = new \lib\html\HTMLFormStacked();

		$form->addInput('Name', array(
			'type' => 'text',
			'id' => 'form-name',
			'name' => 'name',
			'placeholder' => 'Name',
			'value' => $fields['name']
		));

		$form->addInput('Domain', array(
			'type' => 'text',
			'id' => 'form-domain',
			'name' => 'domain',
			'placeholder' => 'Domain',
			'value' => $fields['domain']
		));

		$form->addInput('Active', array(
			'type' => 'checkbox',
			'id' => 'form-active',
			'name' => 'active',
			'value' => '1'
		) + ($fields['active'] ? array('checked' => 'checked') : array()));

		$form->addContent('<a href="' . $this->url->getDirectory() . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-settings">Website settings</h2>' . $fields['message'] . $form->__toString();
	}

	/**
	 *
	 */
	private function dashboardGet() {
		$this->pdbc->query('SELECT `id`,`name`,`active`
		                    FROM `website`
		                    WHERE `uid` = ' . $this->pdbc->quote($this->session->getUserID()) . '
				    ORDER BY `id`ASC');

		return $this->pdbc->fetchAll();
	}

	/**
	 *
	 */
	private function dashboardPage($fieldsRow) {
		$table = new \lib\html\HTMLTable();
		$table->addHeaderRow(array('#','Website','Status','Settings'));

		foreach($fieldsRow as $fields) {
			$table->openRow();
			$table->addColumn($fields['id']);
			$table->addColumn('<a href="' . $this->website . $fields['id'] . '">' . $fields['name'] . '</a>');
			$table->addColumn('<span class="icon icon-active-' . $fields['active'] . '"></span>');
			$table->addColumn('<a class="icon icon-settings" href="' . $this->url->getDirectory() . $fields['id'] . '"></a>');
			$table->closeRow();
		}

		return '<h2 class="icon icon-dashboard">Dashboard</h2>' . $table->__toString();
	}
}

?>
