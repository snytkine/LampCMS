<?php
/**
 *
 * PHP 5.3 or better is required
 * 
 * @category   Zend
 * @package    Zend_Acl
 * @copyright  Copyright (c) 2005-2009 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 *
 *
 */

namespace Lampcms\Acl;

use \Lampcms\Interfaces\RoleInterface;

/**
 * Acl Role class
 *
 */
class Role implements RoleInterface
{
	/**
	 * Unique id of Role
	 *
	 * @var string
	 */
	protected $_roleId;

	/**
	 * Sets the Role identifier
	 *
	 * @param  string $id
	 * @return void
	 */
	public function __construct($roleId){
		$this->_roleId = (string)$roleId;
	}

	/**
	 * Defined by Zend_Acl_Role_Interface; returns the Role identifier
	 *
	 * @return string
	 */
	public function getRoleId(){
		return $this->_roleId;
	}
	
	/**
	 * This method was not originally in
	 * Zend_Acl library
	 * Added by Dmitri Snytkine specifically for
	 * Lampcms project
	 * (non-PHPdoc)
	 * @see Lampcms\Interfaces.RoleInterface::setRoleId()
	 */
	public function setRoleId($role){
		$this->_roleId = $role;
	}

}
