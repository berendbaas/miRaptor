<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class Admin implements Module {
	private $pdbc;
	private $page;
	private $args;
        private $user;

	/**
	 *
	 */
	public function __construct(PDBC $pdbc, $page, array $args) {
		$this->pdbc = $pdbc;
		$this->page = $page;
		$this->args = $args;

		include('config.php');

		$this->user = new User(new Mysql($config['mysql']));
	}

	/**
	 *
	 */
	public function isStatic() {
		return FALSE;
	}

	/**
	 *
	 */
	public function get() {
		if($this->user->isLoggedIn()) {
			return $this->handleAdmin();
		} else {
			return $this->handleLogIn();
		}
	}

	/**
	 *
	 */
	private function handleLogIn() {
		if(isset($this->args['get']) && $this->args['get'] == 'login') {
			return $this->user->loginFields('overview/');
		} else {
			header('location: http://admin.miraptor.nl/', TRUE, 303);
			return '';
		}
	}

	/**
	 *
	 */
	private function handleAdmin() {
		if(isset($this->args['get'])) {
			switch($this->args['get']) {
				case 'login':
					header('location: http://admin.miraptor.nl/overview/', TRUE, 303); 
					return '';
				break;
				case 'logout':
					$this->user->logout();
					header('location: http://admin.miraptor.nl/', TRUE, 303);
					return '';
				break;
				case 'overview':
					return $this->handleAdminOverview();
				break;
				case 'websites':
					return $this->handleAdminWebsites();
				break;
				case 'domains':
					return $this->handleAdminDomains();
				break;
				case 'settings':
					return $this->handleAdminSettings();
				break;
				case 'website':
					return $this->handleAdminWebsite();
				break;
				case 'renamewebsite':
					return $this->handleAdminRenameWebsite();
				break;
				case 'websitestats':
					return $this->handleAdminStats();
				break;
			}

			throw new exception('"Get" Argument not supported.');
		}
	}

	/**
	 *
	 */
	private function handleAdminOverview() {
		/* TODO
		 * - Updates
		 * - Nieuws
		 */
		$ret = '<p>Welcome back, ' . $this->user->get_name() . '.</p>';



		return $ret;
	}

	/**
	 *
	 */
	private function handleAdminStats() {

		$ret = 'Stats, motherfucker. Do you has them?';

		return $ret;
	}

	/**
	 *
	 */
	private function handleAdminRenameWebsite() {

		$ret = '<h2>Rename website</h2>';


		if( isset( $_POST['name'] ) )
		{
			$this->user->update_sitename( $_POST['site'], $_POST['name'] );

			header('location: http://admin.miraptor.nl/websites/', TRUE, 303);
		}

		$site = isset( $_GET['site'] ) ? $_GET['site'] : 0;

		if( $this->user->hasAccessToSite( $site ) )
		{
			$curname = $this->user->get_sitename( $site );

			$ret .= "<form action='' method='post'>";
			$ret .= "<input type='hidden' value='" . $site . "' id='site' name='site' />";
			$ret .=    "<label for='name'>";
			$ret .=       "Name: <input type='text' id='name' name='name' value='" . $curname . "' />";
			$ret .=    "</label>";
			$ret .=    "<input type='submit' value='save'>";
			$ret .= "</form>";
		}else{
			$ret .= "<p>You don't have access to this website.</p><p>Return to the <a href='websites/'>website overview</a></p>";
		}

		return $ret;
	}

	/**
	 *
	 */
	private function handleAdminWebsites() {

		$ret = '<h2>Websites</h2>';


		if( isset( $_GET['togglestatus'] ) )
		{
			$this->user->toggle_website_status( $_GET['togglestatus'] );
		}

		if( isset( $_GET['newsite'] ) && trim( $_GET['newsite'] ) != '' )
		{
			$this->user->new_website( $_GET['newsite'] );
		}


		$ret .= '<p>This page lists all your websites. Click on the name of a website to edit that website, or click on the status icon to toggle the website on/offline.</p>';

		$ret .= '<table><thead><tr><th>name</th><th>status</th><th></th></tr></thead><tbody>';

		foreach( $this->user->get_websites() as $website )
		{
			$status = $website['status'] == 1 ? 'online' : 'offline';

			$ret .= '<tr>';

			$ret .=    "<td><a href='website/?siteid=" . $website['id'] . "'>" . $website['name'] . "</a></td>";

			$ret .=    "<td>";
			$ret .=       "<a href='websites/?togglestatus=" . $website['id'] . "'>";
			$ret .=          "<img src='_media/images/status_" . $status . ".png' alt='Site is " . $status . "' title='Site is " . $status . "' />";
			$ret .=       "</a>";
			$ret .=    "</td>";

			$ret .=    "<td>";
			$ret .=       "<a href='websites/rename/?site=" . $website['id'] . "'>";
			$ret .=          "<img src='_media/images/rename.png' alt='Rename website' title='Rename website' />";
			$ret .=       "</a>";

			$ret .=    "</td>";
			$ret .=    "<td>";
			$ret .=       "<a href='websites/stats/?site=" . $website['id'] . "'>";
			$ret .=          "<img src='_media/images/stats.png' alt='Website statistics' title='Website statistics' />";
			$ret .=       "</a>";
			$ret .=    "</td>";

			$ret .= '</tr>';
		}


		$ret .= '</tbody></table>';


		$ret .= '<h3>Add new site</h3>';
		$ret .= "<form action='websites/' method='get'>";
		$ret .=    "<label for='newsite'>";
		$ret .=       "Name: <input type='text' id='newsite' name='newsite' />";
		$ret .=    "</label>";
		$ret .=    "<input type='submit' value='create' />";
                $ret .= "</form>";

		return $ret;
	}

	/**
	 *
	 */
	private function handleAdminDomains() {
		/* TODO
		 * - Domeinen van de gebruiker
		 * - Redirects
		 */
		return '<p>Unknown page (yet?), check <code>{admin get="' . $this->args['get'] . '"}</code></p>';
	}

	/**
	 *
	 */
	private function handleAdminSettings() {
		/* TODO
		 * - Username
		 * - Password
		 * - First name
		 * - Last name
		 * - Adres
		 * - E-mail
		 * - Telefoon
		 */
		return '<p>Unknown page (yet?), check <code>{admin get="' . $this->args['get'] . '"}</code></p>';
	}

	/**
	 *
	 */
	private function handleAdminWebsite() {
		/* TODO
		 * Parse menu (default modules + modules van de gebruikers)
		 * Fix content (admin.php van de betreffende module)
		 */
		return '<div id="menu"></div><div id="content"><p>Unknown page (yet?), check <code>{admin get="' . $this->args['get'] . '"}</code></p></div>';
	}
}

?>
