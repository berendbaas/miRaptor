<?php

/**
 * @author miWebb <info@miwebb.com>
 * @copyright Copyright (c) 2013, miWebb
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0
 */
class User
{
	private $pdbc;

	private $userid = null;

	public function __construct($pdbc) {
		session_start();

		$this->pdbc = $pdbc;

                $this->pdbc->selectDatabase('miraptor_cms');

		$user = '';
		$pass = '';

		if( isset($_SESSION['user_class_username']) && isset($_SESSION['user_class_password']) )
		{
			$user = $_SESSION['user_class_username'];
			$pass = $_SESSION['user_class_password'];
		}

		if( isset($_POST['user_class_username']) && isset($_POST['user_class_password']) )
		{
			$user = $_POST['user_class_username'];
			$pass = $_POST['user_class_password'];
		}

		$uq = $this->pdbc->fetch('SELECT id FROM user WHERE username = "' . $user . '" AND password = "' . $pass . '"');

		$uq = end($uq);

		if($uq['id'])
		{
			$this->userid = $uq['id'];
			$_SESSION['user_class_username'] = $user;
			$_SESSION['user_class_password'] = $pass;
		}
	}

	public function isLoggedIn()
	{
		return $this->userid != null;
	}


	public function logout()
	{
		$this->userid = null;

		$_SESSION['user_class_username'] = '';
		$_SESSION['user_class_password'] = '';
	}


	public function hasAccessToSite($website)
	{
		$access = end( $this->pdbc->fetch('SELECT uid FROM website WHERE id = ' . $website) );

		if($access['uid'] == $this->userid)
		{
			return true;
		}

		return false;
	}

	public function loginFields($action = "")
	{
		$field  = "<form method='post' action='" . $action . "'>";
		$field .= "	  <label for='user_class_username'>Username: <input type='text' id='user_class_username' name='user_class_username' /></label>";
		$field .= "   <label for='user_class_password'>Password: <input type='password' id='user_class_password' name='user_class_password' /></label>";
		$field .= "   <input type='submit' value='login' />"; 
		$field .= "</form>";

		return $field;
	}

	public function get_id()
	{
		return $this->userid;
	}

	public function get_name()
	{
		return end(end( $this->pdbc->fetch('SELECT name FROM user WHERE id = ' . $this->userid) ));
	}

	public function get_sitename($id)
	{
		if( $this->hasAccessToSite( $id ) )
		{
			return end(end( $this->pdbc->fetch('SELECT name FROM website WHERE id = ' . $id) ) );
		}
	}

	public function get_websites()
	{
		$websites = $this->pdbc->fetch('SELECT id, name, active FROM website WHERE uid = ' . $this->userid);
		$ret = array();
		$c = 0;

		foreach( $websites as $website)
		{
			$ret[ $c ] = array('name' => $website['name'],
					   'status' => $website['active'],
					   'id' => $website['id']);
			$c++;
		}

		return $ret;
	}

	public function toggle_website_status( $id )
	{
		if( $this->hasAccessToSite( $id ) )
		{
			$this->pdbc->execute('UPDATE website SET active = (1 - active) WHERE id = ' . $id);
		}
	}

	public function new_website( $name )
	{
		echo "user.class.php::User::new_website(" . $name . ") - call STUB";
	}

	public function update_sitename( $id, $name )
	{
		$sitename = preg_replace( "/([^0-9a-zA-Z\-\_\ ])/", "", trim( $name ) );


		if( $this->hasAccessToSite( $id ) )
		{
			$this->pdbc->execute('UPDATE website SET name = "' . $sitename . '" WHERE id = ' . $id);
		}
	}


}

?>
