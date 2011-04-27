<?php
/**
 *
 * PHP 5.3 or better is required
 *
 * @package    Global functions
 *
 *  Redistribution and use in source and binary forms, with or without
 *  modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. The name of the author may not be used to endorse or promote products
 *    derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE AUTHOR "AS IS" AND ANY EXPRESS OR IMPLIED
 * WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE FREEBSD PROJECT OR CONTRIBUTORS BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF
 * THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 *
 * @author     Dmitri Snytkine <cms@lampcms.com>
 * @copyright  2005-2011 (or current year) ExamNotes.net inc.
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt The GNU General Public License (GPL) version 3
 * @link       http://cms.lampcms.com   Lampcms.com project
 * @version    Release: @package_version@
 *
 *
 */

namespace Lampcms\Event;


/**
 * A Notification object
 *
 * The Notification object can be easily
 * subclassed and serves as a container
 * for the information about the notification.
 * It holds an object which is
 * usually a reference to the object that posted the notification,
 * a notification name used to identify
 * the notification and some user
 * information which can be anything you need.
 *
 * @category  Event
 * @package   Event_Dispatcher2
 * @author    Dmitri Snytkine <d.snytkine@gmail.com>
 * @author    Bertrand Mansion <bmansion@mamasam.com>
 * @author    Stephan Schmidt <schst@php.net>
 * @copyright 1997-2009 The PHP Group
 * @license   BSD License http://www.opensource.org/licenses/bsd-license.php
 * @version   SVN: <svn_id>
 * @link      http://pear.php.net/package/Event_Dispatcher2
 * @filesource
 *
 */
class Notification extends Dispatcher
{
	/**
	 * Default state of the notification
	 */
	const DEFAULT_STATE = 0;

	
	/**
	 * Notification has been cancelled
	 */
	const CANCELLED_STATE = 1;

	
	/**
	 * name of the notofication
	 * @var string
	 */
	protected $notificationName;

	
	/**
	 * object of interest
	 * (the sender of the notification, in most cases)
	 * @var object
	 */
	protected $notificationObject;

	
	/**
	 * additional information about the notification
	 * @var mixed
	 */
	protected $notificationInfo = array();

	
	/**
	 * state of the notification
	 *
	 * This may be:
	 * - self::DEFAULT_STATE
	 * - self::CANCELLED_STATE
	 *
	 * @var integer
	 */
	protected $notificationState = self::DEFAULT_STATE;

	
	/**
	 * amount of observers that received this notification
	 * @var mixed
	 */
	protected $notificationCount = 0;


	/**
	 * Constructor
	 *
	 * @param object $object The object of interest for the notification,
	 *                       usually is the posting object
	 * @param string $name   Notification name
	 * @param array  $info   Free information array
	 *
	 * @return void
	 */
	public function __construct($object, $name, array $info = array()){
		$this->notificationObject = $object;
		$this->notificationName   = $name;
		$this->notificationInfo   = $info;
	}

	
	/**
	 * For information purposed and for purposes on loggin, so
	 * you may add the class to log like $log($oEvent)
	 * where $oEvent is this object
	 *
	 * @return string with info about this object
	 */
	public function __toString(){
		return 'Notification object. "Event notification name":'.$this->notificationName;
			
	}

	
	/**
	 * Returns the notification name
	 *
	 * @return  string Notification name
	 */
	function getNotificationName(){
		return $this->notificationName;
	}

	
	/**
	 * Returns the contained object
	 *
	 * @return  object Contained object
	 */
	public function getNotificationObject(){
		return $this->notificationObject;
	}

	
	/**
	 * Returns the user info array
	 *
	 * @return  array user info
	 */
	public function getNotificationInfo(){
		return $this->notificationInfo;
	}

	
	/**
	 * Increase the internal count
	 *
	 * @access   public
	 * @return void
	 */
	public function increaseNotificationCount(){
		++$this->notificationCount;
	}

	
	/**
	 * Get the number of posted notifications
	 * This info is usefull for testing and debuging
	 *
	 * @return   int
	 */
	public function getNotificationCount(){
		return $this->notificationCount;
	}

	
	/**
	 * Cancel the notification
	 *
	 * @return   void
	 */
	public function cancelNotification(){
		$this->notificationState = self::CANCELLED_STATE;
	}

	
	/**
	 * Checks whether the notification has been cancelled
	 *
	 * @return   boolean
	 */
	public function isNotificationCancelled(){
		return ($this->notificationState === self::CANCELLED_STATE);
	}
}
