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
 * Event_Dispatche class
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
 *
 */
class Dispatcher implements \SplSubject
{

	/**
	 * Name of global observer
	 * will be used as array key in $this->ro array
	 * All global events are stored under this key
	 */
	const EVENT_DISPATCHER_GLOBAL = 'EVENT_DISPATCHER_GLOBAL';

	/**
	 * Registered observer callbacks
	 * @var array
	 */
	protected $ro = array();

	/**
	 * Pending notifications
	 * @var array
	 */
	protected $pending = array();

	/**
	 * Nested observers
	 * @var array
	 */
	protected $nestedDispatchers = array();

	/**
	 * Name of the dispatcher
	 * @var string
	 */
	protected $name = null;


	/**
	 * Class used for notifications
	 * @var string
	 */
	protected $notificationClass = null;


	/**
	 * PHP5 constructor
	 *
	 *
	 * @param string $name              Name of the this
	 *                                  notification dispatcher object
	 * @param string $notificationClass Name of notification class
	 */
	public function __construct($name = '__default', $notificationClass = 'Notification'){
		$this->name = $name;
		$this->notificationClass = $notificationClass;
		$this->ro[self::EVENT_DISPATCHER_GLOBAL] = array();
	}


	/**
	 * Getter for name of notification class
	 *
	 * @return string name of default notification class
	 */
	public function getNotificationName(){
		return $this->notificationClass;
	}


	/**
	 * For information purposed and for purposes on loggin, so
	 * you may add the class to log like $log($oEvent) where $oEvent is this object
	 *
	 * @return string with info about this object
	 */
	public function __toString(){
		return 'Instance of Dispatcher "_name: "'.$this->getName().' notification object name: '.$this->getNotificationName();
	}


	/**
	 * Registers an observer callback
	 *
	 * This method registers a callback
	 *
	 * which is called when the notification corresponding to the
	 * criteria given at registration time is posted.
	 * The criteria are the notification name and eventually the
	 * class of the object posted with the notification.
	 *
	 * If there are any pending notifications corresponding to the criteria
	 * given here, the callback will be called straight away.
	 *
	 * If the notification name is empty, the observer will receive all the
	 * posted notifications. Same goes for the class name.
	 *
	 * @param mixed  $callback A PHP callback can be name
	 *                         of callback function
	 *                         or array or object
	 * @param string $nName    Expected notification name (for example 'onDbUpdate'),
	 *                         serves as a filter
	 * @param string $class    Expected contained object class,
	 *                         serves as an extra filter
	 *                         This means an object will receive notificaton
	 * only if its subscribed to a specific event and only to
	 * this specific notification object
	 * In order to receive all events but only for a
	 * specific notification object you must
	 * subscribe to global event and pass specific class name,
	 * like this: oEvent->addObserver($o, null, 'specificClass')
	 *
	 * @return object $this
	 */
	public function addObserver($callback, $nName = null, $class = null){
		$nName = (null !== $nName) ? $nName : self::EVENT_DISPATCHER_GLOBAL;
		$aCallback = $this->checkCallback($callback);
		extract($aCallback);

		$this->ro[$nName][$reg] = array(
                                    'callback' => $callback,
                                    'class'    => $class
		);

		return $this->postPendingEvents($callback, $nName, $class);
	}


	/**
	 * Post eventual pending notifications for this event name ($nName)
	 *
	 * @param mixed  $callback callback
	 * @param string $nName    event name
	 * @param string $class    class name
	 *
	 * @return object $this
	 */
	protected function postPendingEvents($callback, $nName = self::EVENT_DISPATCHER_GLOBAL, $class = null){
		if (isset($this->pending[$nName])) {
			d(' Posting pending event '.$nName);

			foreach ($this->pending[$nName] as $notification) {
				if (!$notification->isNotificationCancelled()) {
					$objClass = get_class($notification->getNotificationObject());
					if (empty($class) || strcasecmp($class, $objClass) === 0) {
						call_user_func_array($callback, array($notification));
						$notification->increaseNotificationCount();
					}
				}
			}
		}

		return $this;
	}


	/**
	 * Getter for $this->pending array
	 *
	 *
	 * @return array
	 */
	public function getPendingEvents(){
		return $this->pending;
	}


	/**
	 * If your observer implements SplObserver interface its a lot
	 * faster to use this method than addObserver() because it bypasses
	 * all types of checks like is_array(), is_object(), is_callable()
	 *
	 * You can still use addObserver($yourobject, $nName, $class)
	 * if you want to subscribe to only specific event(s) or to
	 * specific class passed in Notification object.
	 *
	 * Using this method will subscribe your observer object to all events
	 * When this object calls your observer's update() method, you can query
	 * the object passed in update() to get the notification name, like this:
	 * $eventName = $oNotification->getNotificationName();
	 * $obj = $oNotification->getNotificationObject();
	 * $aInfo = $oNotification->getNotificationInfo();
	 *
	 * @param object $observer object that implements SplObserver interface
	 * which means it must have method update(SplSubject $o)
	 * the $o object will be an instance of Event_Notification2 class
	 *
	 * @return object $this
	 */
	public function attach(\SplObserver $observer){
		$reg = get_class($observer).'::update';
		$callback = array($observer, 'update');
			
		$this->ro[self::EVENT_DISPATCHER_GLOBAL][$reg] = array('callback' => $callback);

		return $this->postPendingEvents($callback);
	}


	/**
	 * If your observer was registered using attach() method,
	 * then it can be
	 * detached (unregistered) using this method
	 *
	 * @param object $observer Object that implements
	 *                         SplObserver interface
	 *
	 * @return void
	 */
	public function detach(\SplObserver $observer){
		$reg = get_class($observer).'::update';
		if (array_key_exists(self::EVENT_DISPATCHER_GLOBAL, $this->ro) && isset($this->ro[self::EVENT_DISPATCHER_GLOBAL][$reg])) {
			unset($this->ro[self::EVENT_DISPATCHER_GLOBAL][$reg]);
		}
	}


	public function notify()
	{

	}

	
	/**
	 * Posts the {@link Event_Notification2} object
	 * Even though this method is public, you should not use it directly,
	 * instead use post() method to post new event
	 * This method will be invoked from post() with correct params.
	 *
	 * @param object $notification The Notification object
	 * @param bool   $pending      Whether to post the notification immediately
	 * @param bool   $bubble       Whether you want the notification to bubble up
	 * @param string $objClass     Name of object passed in notification object
	 * @param string $nName        Name of notification even
	 * (for example 'onTableUpdate' - up to you to name your events)
	 *
	 * @see Event_Dispatcher::post()
	 *
	 * @return  object  The notification object
	 */
	protected function _notify(Notification $notification, $pending = true, $bubble = true, $objClass = null, $nName = null){
		$objClass = (null !== $objClass) ? $objClass :  get_class($notification->getNotificationObject());
		$nName = (null !== $nName) ? $nName : $notification->getNotificationName();
		d(' $nName: '.$nName);

		if ( true === $pending ) {
			$this->pending[$nName][] = $notification;
		}

		/**
		 * Find the registered observers for this event
		 *
		 */
		if (isset($this->ro[$nName])) {

			if ($notification->isNotificationCancelled()) {

				return $notification;
			}

			foreach ($this->ro[$nName] as $rObserver) {
				if ( empty($rObserver['class']) || (strcasecmp($rObserver['class'], $objClass) === 0) ) {
					call_user_func_array($rObserver['callback'], array($notification));
					$notification->increaseNotificationCount();
				}
			}
		}

		/**
		 * Notify globally registered observers
		 * IF this evenName is NOT EVENT_DISPATCHER_GLOBAL
		 * and there are registered observers for EVENT_DISPATCHER_GLOBAL
		 */
		if ( (self::EVENT_DISPATCHER_GLOBAL !== $nName) && isset($this->ro[self::EVENT_DISPATCHER_GLOBAL])) {

			/**
			 * Here it's important to pass false
			 * as $bubble param so that this event will not result in
			 * posting to nested dispatchers.
			 *
			 * This is because at the end of this method we already
			 * have call to notifyNestedDispatchers()
			 *
			 * otherwise nested dispatchers will be notified twice
			 */
			$this->_notify($notification, $pending, false, $objClass, self::EVENT_DISPATCHER_GLOBAL);
		}

		if ( false === $bubble ) {

			return $notification;
		}

		/**
		 * @todo
		 *
		 * Potential problem: we don't pass the notification name here,
		 * this means that event of type self::EVENT_DISPATCHER_GLOBAL
		 * will always cause posting to nested dispatcher but the name
		 * self::EVENT_DISPATCHER_GLOBAL is not passed to nested dispatcher,
		 * so nested dispatcher will extract the name from the $notification
		 * object, which will result in mismatch between name of event posted here
		 * (self::EVENT_DISPATCHER_GLOBAL) and name of event nested dispatcher will
		 * actually see.
		 *
		 * This will result in the same event being posted twice to nested dispatcher:
		 * once as the currectly passed actual notification name and second time
		 * as a result of notifying of self::EVENT_DISPATCHER_GLOBAL
		 *
		 * I think this has been fixed now by making notifyNestedDispatchers()
		 * accept the same args as this method and passing the same args as passed
		 * to this method
		 */
		$oNested = $this->notifyNestedDispatchers($notification, $pending, $bubble, $objClass, $nName);

		/**
		 * If any one of the nested notifications has
		 * been cancelled, then return that nested notification
		 *
		 * This is a way of letting a nested notification to
		 * cancel the top-level notification event
		 */
		if($oNested instanceof Notification){

			return $oNested;
		}

		return $notification;
	}

	
	/**
	 * calls notify() on nested dispatchers if nested dispatchers exist
	 *
	 * @return object $this
	 */
	protected function notifyNestedDispatchers($notification, $pending, $bubble, $objClass, $nName){

		if (!empty($this->nestedDispatchers)) {
			foreach ($this->nestedDispatchers as $oNested) {

				d(' Notifying nested dispatcher of event: '.$nName);

				$notification = $oNested->_notify($notification, $pending, $bubble, $objClass, $nName);

				/**
				 * If nested observer cancelled the notification,
				 * then we return that notification right away
				 *
				 * This way a nested observer is able to cancell notification
				 * the same way as a regular observer.
				 *
				 * The thing to remember is that other observers
				 * (if there are any more left to be notified)
				 * will NOT be notified
				 */
				if($notification->isNotificationCancelled()){

					return $notification;
				}
			}
		}

		return $this;
	}

	
	/**
	 * Performes check on $callback string
	 *
	 * @param mixed $callback can be array, string or object
	 * If string, then must be a name of existing function,
	 *
	 * If object, then it must have public method update().
	 * a notification object will be passed
	 * to that object's update() method
	 *
	 * If array, it must have exactly 2 elements:
	 * 0 and 1 where 0 is the object or class
	 * and 1 is the name of method in that object
	 * which will be invoked.
	 *
	 * @return array with keys 'reg' and 'callback'
	 *
	 * @throws Event_Dispatcher_User_Exception
	 * if something is not right with $callback
	 */
	protected function checkCallback($callback){
		if (is_array($callback)) {
			if (!array_key_exists('0', $callback) || !array_key_exists('1', $callback) || (count($callback) > 2) ) {
				throw new \InvalidArgumentException('Callback array MUST have exactly 2 elements with keys 0 (with value of class name or object) and 1 (with value of method name)');
			}

			if (is_object($callback[0])) {
				if (!is_callable($callback)) {
					throw new \InvalidArgumentException('callback is object but not a valid callable object/method array');
				}
				$reg = get_class($callback[0]).'::'.$callback[1];
			} else {
				if (!in_array($callback[1], get_class_methods($callback[0])) ) {
					throw new \InvalidArgumentException('Method '.$callback[1].' does not exist in class '.$callback[0]);
				}
				$reg = $callback[0].'::'.$callback[1];
			}
		} elseif (is_string($callback)) {
			if ( !is_callable($callback)) {
				throw new \InvalidArgumentException('Callback function '.$callback. ' does not exist or is not a valid callable function');
			}

			$reg = $callback;
		} elseif (is_object($callback)) {
			if ( !method_exists($callback, 'update') || !is_callable(array($callback, 'update')) ) {
				throw new \InvalidArgumentException('Callback object must have the update() method');
			}

			$reg = get_class($callback).'::update';
			$callback = array($callback, 'update');
		} else {
			throw new \InvalidArgumentException('wrong type of variable $callback - it must be string or array or object');
		}

		return compact('reg', 'callback');
	}


	/**
	 * Creates and posts a notification object
	 *
	 * The purpose of the optional associated object is generally to pass
	 * the object posting the notification to the observers, so that the
	 * observers can query the posting object for more information about
	 * the event.
	 *
	 * Notifications are by default added to a pending notification list.
	 * This way, if an observer is not registered by the time they are
	 * posted, it will still be notified when it is added as an observer.
	 * This behaviour can be turned off in order to make sure that only
	 * the registered observers will be notified.
	 *
	 * The info array serves as a container for any kind of useful
	 * information. It is added to the notification object and posted along.
	 *
	 * @param object $object  Notification associated object
	 * @param string $nName   Notification name
	 * @param array  $info    Optional user information
	 * @param bool   $pending Whether the notification is pending
	 * @param bool   $bubble  Whether you want the notification to bubble up
	 *
	 * @return object  The notification object acts as an extra filter.
	 */
	public function post($object, $nName, $info = array(), $pending = true, $bubble = true){
		
		$notification = new Notification($object, $nName, $info);
		
		$objClass = get_class($object);

		return $this->_notify($notification, $pending, $bubble, $objClass, $nName);
	}


	/**
	 * Removes a registered observer that correspond to the given criteria
	 *
	 * @param mixed  $callback A PHP callback
	 * @param string $nName    Notification name
	 * @param string $class    Contained object class
	 *
	 * @return bool    True if an observer was removed, false otherwise
	 */
	public function removeObserver($callback, $nName = null, $class = null){
		$nName = (null !== $nName) ? $nName : self::EVENT_DISPATCHER_GLOBAL;
		$aCallback = $this->checkCallback($callback);
		extract($aCallback);

		$removed = false;
		if (isset($this->ro[$nName][$reg])) {
			if (!empty($class)) {
				if (strcasecmp($this->ro[$nName][$reg]['class'], $class) === 0) {
					unset($this->ro[$nName][$reg]);
					$removed = true;
				}
			} else {
				unset($this->ro[$nName][$reg]);
				$removed = true;
			}
		}

		if (isset($this->ro[$nName]) && count($this->ro[$nName]) === 0) {
			unset($this->ro[$nName]);
		}

		return $removed;
	}

	
	/**
	 * Check, whether the specified observer has been registered with the
	 * dispatcher
	 *
	 * @param mixed  $callback A PHP callback
	 * @param string $nName    Notification name
	 * @param string $class    Contained object class
	 *
	 * @return  bool        True if the observer has been registered, false otherwise
	 */
	public function observerRegistered($callback, $nName = self::EVENT_DISPATCHER_GLOBAL, $class = null){
		$aCallback = $this->checkCallback($callback);
		extract($aCallback);

		if (!isset($this->ro[$nName][$reg])) {

			return false;
		}
		if (empty($class)) {

			return true;
		}

		return ( 0 === strcasecmp($this->ro[$nName][$reg]['class'], $class));
	}


	/**
	 * Get all observers, that have been registered for a notification
	 *
	 * @param string $nName Notification name
	 * @param string $class Contained object class
	 *
	 * @return  array       List of all observers
	 */
	public function getObservers($nName = self::EVENT_DISPATCHER_GLOBAL, $class = null){
		$observers = array();
		if (!isset($this->ro[$nName])) {

			return $observers;
		}

		foreach ($this->ro[$nName] as $reg => $observer) {
			if ( null === $class ||  null === $observer['class'] ||  0 === strcasecmp($observer['class'], $class) ) {
				$observers[] = $reg;
			}
		}

		return $observers;
	}


	/**
	 * Getter for $this->$ro array
	 *
	 * @return array
	 */
	public function getRegisteredObservers(){
		return $this->ro;
	}


	/**
	 * Get the name of the dispatcher.
	 *
	 * The name is the unique identifier of a dispatcher.
	 *
	 * @return string     name of the dispatcher
	 */
	public function getName(){
		return $this->name;
	}

	
	/**
	 * Add a new nested dispatcher
	 *
	 * Notifications will be broadcasted to this dispatcher as well,
	 * which allows you to create event bubbling.
	 * this nested dispatcher should actually
	 * be higher up in the chain of events
	 * for example if you update specific db table,
	 * the onSomeTableUpdate
	 * is specific event and its nested dispatcher
	 * can be onDbUpdate
	 *
	 * @param object $dispatcher The nested dispatcher
	 *                           object of type Event_Dispatcher2
	 *
	 * @return object $this
	 */
	public function addNestedDispatcher(Dispatcher $dispatcher){
		$name = $dispatcher->getName();
		$this->nestedDispatchers[$name] = $dispatcher;

		return $this;
	}

	
	/**
	 * For information and debugging only!
	 * @return string array of names of nested dispatchers
	 * or string 'none' if there are no nested dispatchers
	 */
	public function getNestedDispatchers(){
		return (empty($this->nestedDispatchers)) ? 'none' : print_r(array_keys($this->nestedDispatchers), 1);
	}


	/**
	 * Remove a nested dispatcher
	 *
	 * @param mixed $dispatcher Event_Dispatcher2 object | class name Dispatcher to remove
	 *
	 * @return   object $this
	 */
	public function removeNestedDispatcher($dispatcher){
		if (is_object($dispatcher)) {
			$dispatcher = $dispatcher->getName();
		}
		if (isset($this->nestedDispatchers[$dispatcher])) {

			unset($this->nestedDispatchers[$dispatcher]);
		}

		return $this;
	}


	/**
	 * Changes the class used for notifications
	 *
	 * You may call this method on an object to change it for a single
	 * dispatcher
	 *
	 * @param string $class Name of the notification class
	 *
	 * @return object $this
	 */
	public final function setNotificationClass($class){
		if (!isset($this->notificationClass)) {
			throw new \RuntimeException('The method setNotificationClass can ONLY be called on Dispatcher object. It cannot be called on any child objects!');
		}

		$this->notificationClass = $class;
			
		return $this;
	}
}
