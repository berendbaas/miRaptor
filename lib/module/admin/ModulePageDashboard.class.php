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
		// Check user
		if(!$this->user->isSignedIn()) {
			throw new \lib\core\StatusCodeException($this->redirect, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
		}

		// Check dashboard
		if($this->url->getFile() === '') {
			$this->result = $this->dashboardPage($this->dashboardGet());
			return;
		}

		$website = new \lib\core\Website($this->pdbc, $this->user, $this->url->getFile());

		// Check website access
		if(!$website->hasAccess()) {
			throw new \lib\core\StatusCodeException($this->redirect, \lib\core\StatusCodeException::REDIRECTION_SEE_OTHER);
		}

		$this->result = $this->settingsPage($_SERVER['REQUEST_METHOD'] === 'POST' ? $this->settingsPost($website) : $this->settingsGet($website));

	}

	/**
	 *
	 */
	private function dashboardGet() {
		$this->pdbc->query('SELECT `id`,`name`,`active`
		                    FROM `website`
		                    WHERE `uid` = ' . $this->pdbc->quote($this->user->getID()) . '
				    ORDER BY `id` ASC');

		return $this->pdbc->fetchAll();
	}

	/**
	 *
	 */
	private function dashboardPage($fieldRow) {
		$table = new \lib\html\HTMLTable();
		$table->addHeaderRow(array('#','Website','Status','Settings'));

		foreach($fieldRow as $number => $field) {
			$table->openRow();
			$table->addColumn(++$number);
			$table->addColumn('<a href="' . $this->website . $field['id'] . '">' . $field['name'] . '</a>');
			$table->addColumn('<span class="icon icon-active-' . $field['active'] . '"></span>');
			$table->addColumn('<a class="icon icon-settings" href="' . $this->url->getDirectory() . $field['id'] . '"></a>');
			$table->closeRow();
		}

		return '<h2 class="icon icon-dashboard">Dashboard</h2>' . $table->__toString();
	}

	/**
	 *
	 */
	private function settingsGet($website) {
		return array(
			'name' => $website->getName(),
			'domain' => $website->getDomain(),
			'active' => $website->getActive(),
			'error' => ''
		);
	}

	/**
	 *
	 */
	private function settingsPost($website) {
		$field = $this->settingsGet($website);

		if(!isset($_POST['name'], $_POST['domain'])) {
			$field['error'] = '<p class="msg-warning">Require name and domain.</p>';
			return $field;
		}

		$field['name'] = $_POST['name'];
		$field['domain'] = $_POST['domain'];
		$field['active'] = (isset($_POST['active']) ? 1 : 0);

		$this->pdbc->query('UPDATE `website`
		                    SET `name` =  "' . $this->pdbc->quote($field['name']) . '",
		                        `domain` =  "' . $this->pdbc->quote($field['domain']) . '",
					`active` =  "' . $this->pdbc->quote($field['active']) . '"
		                    WHERE `id` = "' . $this->pdbc->quote($website->getID()) . '"
		                    AND `uid` = "' . $this->pdbc->quote($this->user->getID()) . '"');

		if($this->pdbc->rowCount()) {
			$field['error'] = '<p class="msg-succes">Your changes have been saved successfully.</p>';
		}

		return $field;
	}

	/**
	 *
	 */
	private function settingsPage($field) {

		$form = new \lib\html\HTMLFormStacked();

		$form->addInput('Name', array(
			'type' => 'text',
			'id' => 'form-name',
			'name' => 'name',
			'placeholder' => 'Name',
			'value' => $field['name']
		));

		$form->addInput('Domain', array(
			'type' => 'text',
			'id' => 'form-domain',
			'name' => 'domain',
			'placeholder' => 'Domain',
			'value' => $field['domain']
		));

		$form->addInput('Active', array(
			'type' => 'checkbox',
			'id' => 'form-active',
			'name' => 'active',
			'value' => '1'
		) + ($field['active'] ? array('checked' => 'checked') : array()));

		$form->addContent('<a href="' . $this->url->getDirectory() . '"><button type="button">Back</button></a>');

		$form->addButton('Submit', array(
			'type' => 'submit'
		));

		return '<h2 class="icon icon-settings">Website settings</h2>' . $field['error'] . $form->__toString();
	}
}

?>
