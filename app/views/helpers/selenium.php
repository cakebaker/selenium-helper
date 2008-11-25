<?php
/** 
 * Selenium Helper
 *
 * Requires Selenium Core 0.8.3  (http://selenium-core.seleniumhq.org/)
 *
 * Copyright: Daniel Hofstetter  (http://cakebaker.42dh.com)
 * Partial Copyright: Felix Geisendörfer (http://thinkingphp.org)
 * License: MIT
 *
 * For installation instructions, see http://cakebaker.42dh.com/tags/selenium/
 * Selenium documentation: http://selenium-core.seleniumhq.org/reference.html
*/
class SeleniumHelper extends Helper {
	public function __call($method, $params) {
		if ($this->endsWith($method, 'Present')) {
			$tokens = explode('_', Inflector::underscore($method));
			
			$allowedPrefixes = array('assert', 'verify', 'waitFor');
			$allowedKeywords = array('alert', 'confirmation', 'prompt', 'text');
			$allowedPostfixes = array('not', 'present');
				
			foreach ($allowedPrefixes as $prefix) {
				if ($this->beginsWith($method, $prefix)) {
					$id = 1;
					if ($prefix == 'waitFor') {
						$id = 2;
					}
					
					if (in_array($tokens[$id], $allowedKeywords)) {
						$id++;
						
						if (in_array($tokens[$id], $allowedPostfixes)) {
							switch (count($params)) {
								case 0:
									echo $this->getRow($method);
									break;
								case 1:
									echo $this->getRow($method, $params[0]);
									break;
								case 2:
									echo $this->getRow($method, $params[0], $params[1]);
									break;
							}
							
							return;
						}
					}
				}
			}
		} else {
			$allowedPrefixes = array('assertNot', 'verifyNot', 'waitForNot', 'assert', 'verify', 'waitFor');
			$allowedKeywords = array('Alert', 'AllButtons', 'AllFields', 'AllLinks', 'AllWindowIds', 'AllWindowNames',
									 'AllWindowTitles', 'Attribute', 'AttributeFromAllWindows', 'BodyText', 'Checked', 
									 'Confirmation', 'Cookie', 'CursorPosition', 'Editable', 'ElementHeight', 'ElementIndex', 
									 'ElementPositionLeft', 'ElementPositionTop', 'ElementWidth', 'ErrorOnNext', 'Eval', 
									 'Expression', 'FailureOnNext', 'HtmlSource', 'Location', 'LogMessages', 
									 'MouseSpeed', 'Ordered', 'Prompt', 'Selected', 'SelectedId', 'SelectedIds', 
									 'SelectedIndex', 'SelectedIndexes', 'SelectedLabel', 'SelectedLabels', 
									 'SelectedValue', 'SelectedValues', 'SelectOptions', 'SomethingSelected', 'Table', 
									 'Text', 'Title', 'Value', 'Visible', 'WhetherThisFrameMatchFrameExpression', 
									 'WhetherThisWindowMatchWindowExpression', 'XpathCount');
				
			foreach ($allowedPrefixes as $prefix) {
				if ($this->beginsWith($method, $prefix)) {
					foreach ($allowedKeywords as $keyword) {
						if ($this->endsWith($method, $keyword)) {
							switch (count($params)) {
								case 0:
									echo $this->getRow($method);
									break;
								case 1:
									echo $this->getRow($method, $params[0]);
									break;
								case 2:
									echo $this->getRow($method, $params[0], $params[1]);
									break;
							}
							
							return;
						}
					}
				}
			}
		}
			
		trigger_error('Call to undefined function ' . $method, E_USER_ERROR);
		return false;
	}
		
	/**
	 * Outputs the title of the test suite. There is no output if the constant ALL_SUITE is defined. 
	 */
	public function suiteTitle($title) {
		if (defined('ALL_SUITE')) {
			echo '';
		} else {
			echo '<tr><td><b>'.$title.'</b></td></tr>';
		}
	}
		
	/**
	 * Adds a testcase to a suite.
	 */
	public function addTestCase($title, $view) {
		echo '<tr><td><a href="'.$view.'" target="testFrame">'.$title.'</a></td></tr>';
	}
		
	/**
	 * Outputs the title of the test case.
	 */
	public function caseTitle($title) {
		echo '<tr><td rowspan="1" colspan="3">'.$title.'</td></tr>';
	}
		
	// Selenium actions
	
	/**
	 * Defines a new function for Selenium to locate elements on the page. For 
	 * example, if you define the strategy "foo", and someone runs 
	 * click("foo=blah"), we'll run your function, passing you the string "blah", 
	 * and click on the element that your function returns, or throw an "Element 
	 * not found" error if your function returns null. We'll pass three 
	 * arguments to your function: 
	 * - locator: the string the user passed in
	 * - inWindow: the currently selected window
	 * - inDocument: the currently selected document
	 * The function must return null if the element can't be found.
	 * @param strategyName the name of the strategy to define; this should use 
	 * only letters [a-zA-Z] with no spaces or other punctuation.
	 * @param functionDefinition a string defining the body of a function in 
	 * JavaScript. For example: return inDocument.getElementById(locator);
	 * @since 0.8.3
	 */
	public function addLocationStrategy($strategyName, $functionDefinition) {
		echo $this->getRow('addLocationStrategy', $strategyName, $functionDefinition);
	}
	
	/**
	 * Add a selection to the set of selected options in a multi-select element 
	 * using an option locator. 
	 * @param locator an element locator identifying a multi-select box
	 * @param optionLocator an option locator (a label by default)
	 * @since 0.7
	 */
	public function addSelection($locator, $optionLocator) {
		echo $this->getRow('addSelection', $locator, $optionLocator);
	}

	/**
	 * Specifies whether Selenium should use the native in-browser implementation 
	 * of XPath (if any native version is available); if you pass "false" to this 
	 * function, we will always use our pure-JavaScript xpath library. Using the 
	 * pure-JS xpath library can improve the consistency of xpath element 
	 * locators between different browser vendors, but the pure-JS version is 
	 * much slower than the native implementations.
	 * @param allow boolean, true means we'll prefer to use native XPath; false 
	 * means we'll only use JS XPath
	 * @since 0.8.3
	 */
	public function allowNativeXpath($allow) {
		echo $this->getRow('allowNativeXpath', $allow);
	}
	
	/**
	 * Press the alt key and hold it down until doAltUp() is called or a new page 
	 * is loaded.
	 * @since 0.8.1
	 */
	public function altKeyDown() {
		echo $this->getRow('altKeyDown');
	}
	
	/**
	 * Release the alt key.
	 * @since 0.8.1
	 */
	public function altKeyUp() {
		echo $this->getRow('altKeyUp');
	}
	
	/**
	 * Instructs Selenium to return the specified answer string in response to 
	 * the next JavaScript prompt [window.prompt()].
	 * @param answer the answer to give in response to the prompt pop-up
	 * @since 0.6
	 */
	public function answerOnNextPrompt($answer) {
		echo $this->getRow('answerOnNextPrompt', $answer);
	}

	/**
	 * Temporarily sets the "id" attribute of the specified element, so you can 
	 * locate it in the future using its ID rather than a slow/complicated XPath. 
	 * This ID will disappear once the page is reloaded.
	 * @param locator an element locator pointing to an element
	 * @param identifier a string to be used as the ID of the specified element
	 * @since 0.8.3
	 */
	public function assignId($locator, $identifier) {
		echo $this->getRow('assignId', $locator, $identifier);
	}
	
	/**
	 * Halt the currently running test, and wait for the user to press the 
	 * Continue button. This command is useful for debugging, but be careful when 
	 * using it, because it will force automated tests to hang until a user 
	 * intervenes manually.
	 * 
	 * Please notice that "doBreak" is a workaround to avoid "break" as function 
	 * name, because "break" is a PHP keyword.  
	 * @since 0.8.1
	 */
	public function doBreak() {
		echo $this->getRow('break');
	}
	
	/**
	 * Check a toggle-button (checkbox/radio) 
	 * @param locator an element locator
	 * @since 0.7
	 */
	public function check($locator) {
		echo $this->getRow('check', $locator);
	}
	
	/**
	 * By default, Selenium's overridden window.confirm() function will return 
	 * true, as if the user had manually clicked OK. After running this command, 
	 * the next call to confirm() will return false, as if the user had clicked 
	 * Cancel.
	 * @since 0.6
	 */
	public function chooseCancelOnNextConfirmation() {
		echo $this->getRow('chooseCancelOnNextConfirmation');
	}

	/**
	 * Undo the effect of calling chooseCancelOnNextConfirmation. Note that 
	 * Selenium's overridden window.confirm() function will normally 
	 * automatically return true, as if the user had manually clicked OK, so you 
	 * shouldn't need to use this command unless for some reason you need to 
	 * change your mind prior to the next confirmation. After any confirmation, 
	 * Selenium will resume using the default behavior for future confirmations, 
	 * automatically returning true (OK) unless/until you explicitly call 
	 * chooseCancelOnNextConfirmation for each confirmation.
	 * @since 0.8.3
	 */
	public function chooseOkOnNextConfirmation() {
		echo $this->getRow('chooseOkOnNextConfirmation');
	}
	
	/**
	 * Clicks on a link, button, checkbox or radio button. If the click action 
	 * causes a new page to load (like a link usually does), call 
	 * waitForPageToLoad.
	 * @param locator an element locator
	 * @since 0.6
	 */
	public function click($locator) {
		echo $this->getRow('click', $locator);
	}
	
	/**
	 * Clicks on a link, button, checkbox or radio button. If the click action 
	 * causes a new page to load (like a link usually does), call 
	 * waitForPageToLoad.
	 * @param locator an element locator
	 * @param coordString specifies the x,y position (i.e. - 10,20) of the mouse 
	 * event relative to the element returned by the locator.
	 * @since 0.8
	 */
	public function clickAt($locator, $coordString) {
		echo $this->getRow('clickAt', $locator, $coordString);
	}
	
	/**
	 * Simulates the user clicking the "close" button in the titlebar of a popup 
	 * window or tab.
	 * @since 0.6
	 */
	public function close() {
		echo $this->getRow('close');
	}
		
	/**
	 * Press the control key and hold it down until doControlUp() is called or a 
	 * new page is loaded.
	 * @since 0.8.1
	 */
	public function controlKeyDown() {
		echo $this->getRow('controlKeyDown');
	}
	
	/**
	 * Release the control key.
	 * @since 0.8.1
	 */
	public function controlKeyUp() {
		echo $this->getRow('controlKeyUp');
	}
		
	/**
	 * Create a new cookie whose path and domain are same with those of current 
	 * page under test, unless you specified a path for this cookie explicitly.
	 * @param nameValuePair name and value of the cookie in a format "name=value"
	 * @param optionsString options for the cookie. Currently supported options 
	 * include 'path' and 'max_age'. the optionsString's format is 
	 * "path=/path/, max_age=60". The order of options are irrelevant, the unit 
	 * of the value of 'max_age' is second.
	 * @since 0.8
	 */
	public function createCookie($nameValuePair, $optionsString) {
		echo $this->getRow('createCookie', $nameValuePair, $optionsString);
	}
	
	/**
	 * Delete a named cookie with specified path.
	 * @param name the name of the cookie to be deleted
	 * @param path the path property of the cookie to be deleted
	 * @since 0.8
	 */
	public function deleteCookie($name, $path) {
		echo $this->getRow('deleteCookie', $name, $path);
	}
	
	/**
	 * Double clicks on a link, button, checkbox or radio button. If the double 
	 * click action causes a new page to load (like a link usually does), call 
	 * waitForPageToLoad.
	 * @param locator an element locator
	 * @since 0.8.1
	 */
	public function doubleClick($locator) {
		echo $this->getRow('doubleClick', $locator);
	}
		
	/**
	 * Doubleclicks on a link, button, checkbox or radio button. If the action 
	 * causes a new page to load (like a link usually does), call 
	 * waitForPageToLoad.
	 * @param locator an element locator
	 * @param coordString specifies the x,y position (i.e. - 10,20) of the mouse 
	 * event relative to the element returned by the locator.
	 * @since 0.8.1
	 */
	public function doubleClickAt($locator, $coordString) {
		echo $this->getRow('doubleClickAt', $locator, $coordString);
	}
	
	/**
	 * Drags an element a certain distance and then drops it.
	 * @param locator an element locator
	 * @param movementsString offset in pixels from the current location to which 
	 * the element should be moved, e.g., "+70,-300"
	 * @since 0.8.1
	 */
	public function dragAndDrop($locator, $movementsString) {
		echo $this->getRow('dragAndDrop', $locator, $movementsString);
	}
	
	/**
	 * Drags an element and drops it on another element.
	 * @param locatorOfObjectToBeDragged an element to be dragged
	 * @param locatorOfDragDestinationObject - an element whose location 
	 * (i.e., whose top left corner) will be the point where 
	 * locatorOfObjectToBeDragged is dropped
	 * @since 0.8.1
	 */
	public function dragAndDropToObject($locatorOfObjectToBeDragged, $locatorOfDragDestinationObject) {
		echo $this->getRow('dragAndDropToObject', $locatorOfObjectToBeDragged, $locatorOfDragDestinationObject);
	}
		
	/**
	 * @deprecated use dragAndDrop instead
	 * @param locator an element locator
	 * @param movementsString offset in pixels from the current location to which the element should be moved, e.g., "+70,-300"
	 * @since 0.8
	 */
	public function dragdrop($locator, $movementsString) {
		echo $this->getRow('dragdrop', $locator, $movementsString);
	}
	
	/**
	 * Prints the specified message into the third table cell in your Selenese 
	 * tables. Useful for debugging.
	 * @param message the message to print
	 * 
	 * Please notice that "doEcho" is a workaround to avoid using "echo" as 
	 * function name as "echo" is a PHP keyword.
	 * @since 0.8.1
	 */
	public function doEcho($message) {
		echo $this->getRow('echo', $message);
	}
	
	/**
	 * Explicitly simulate an event, to trigger the corresponding "onevent" 
	 * handler.
	 * @param locator an element locator
	 * @param eventName the event name, e.g. "focus" or "blur"
	 * @since 0.6
	 */
	public function fireEvent($locator, $eventName) {
		echo $this->getRow('fireEvent', $locator, $eventName);
	}
	
	/**
	 * Get execution speed (i.e., get the millisecond length of the delay 
	 * following each selenium operation). By default, there is no such delay, 
	 * i.e., the delay is 0 milliseconds. See also setSpeed.
	 * @since 0.8.1
	 */
	public function getSpeed() {
		echo $this->getRow('getSpeed');
	}
		
	/**
	 * Simulates the user clicking the "back" button on their browser.
	 * @since 0.6
	 */
	public function goBack() {
		echo $this->getRow('goBack');
	}
	
	/**
	 * Briefly changes the backgroundColor of the specified element yellow. 
	 * Useful for debugging.
	 * @param locator an element locator
	 * @since 0.8.2
	 */
	public function highlight($locator) {
		echo $this->getRow('highlight', $locator);
	}
	
	/**
	 * Simulates a user pressing a key (without releasing it yet).
	 * @param locator an element locator 
	 * @param keySequence Either be a string("\" followed by the numeric keycode 
	 * of the key to be pressed, normally the ASCII value of that key), or a 
	 * single character. For example: "w", "\119".
	 * @since 0.7
	 */
	public function keyDown($locator, $keySequence) {
		echo $this->getRow('keyDown', $locator, $keySequence);
	}
		
	/**
	 * Simulates a user pressing and releasing a key.
	 * @param locator an element locator
	 * @param keySequence Either be a string("\" followed by the numeric keycode 
	 * of the key to be pressed, normally the ASCII value of that key), or a 
	 * single character. For example: "w", "\119".
	 * @since 0.7
	 */
	public function keyPress($locator, $keySequence) {
		echo $this->getRow('keyPress', $locator, $keySequence);
	}
	
	/**
	 * Simulates a user releasing a key. 
	 * @param locator an element locator 
	 * @param keySequence  Either be a string("\" followed by the numeric keycode 
	 * of the key to be pressed, normally the ASCII value of that key), or a 
	 * single character. For example: "w", "\119".
	 * @since 0.7
	 */
	public function keyUp($locator, $keySequence) {
		echo $this->getRow('keyUp', $locator, $keySequence);
	}
		
	/**
	 * Press the meta key and hold it down until doMetaUp() is called or a new 
	 * page is loaded.
	 * @since 0.8.1
	 */
	public function metaKeyDown() {
		echo $this->getRow('metaKeyDown');
	}
	
	/**
	 * Release the meta key.
	 * @since 0.8.1
	 */
	public function metaKeyUp() {
		echo $this->getRow('metaKeyUp');
	}
	
	/**
	 * Simulates a user pressing the mouse button (without releasing it yet) on 
	 * the specified element. 
	 * @param locator an element locator
	 * @since 0.7
	 */
	public function mouseDown($locator) {
		echo $this->getRow('mouseDown', $locator);
	}
	
	/**
	 * Simulates a user pressing the mouse button (without releasing it yet) on 
	 * the specified element. 
	 * @param locator an element locator
	 * @param coordString specifies the x,y position (i.e. - 10,20) of the mouse 
	 * event relative to the element returned by the locator.
	 * @since 0.8
	 */
	public function mouseDownAt($locator, $coordString) {
		echo $this->getRow('mouseDownAt', $locator, $coordString);
	}
	
	/**
	 * Simulates a user pressing the mouse button (without releasing it yet) on 
	 * the specified element.
	 * @param locator an element locator
	 * @since 0.8
	 */
	public function mouseMove($locator) {
		echo $this->getRow('mouseMove', $locator);
	}
	
	/**
	 * Simulates a user pressing the mouse button (without releasing it yet) on 
	 * the specified element.
	 * @param locator an element locator
	 * @param coordString specifies the x,y position (i.e. - 10,20) of the mouse 
	 * event relative to the element returned by the locator.
	 * @since 0.8
	 */
	public function mouseMoveAt($locator, $coordString) {
		echo $this->getRow('mouseMoveAt', $locator, $coordString);
	}
	
	/**
	 * Simulates a user moving the mouse pointer away from the specified element.
	 * @param locator an element locator
	 * @since 0.8
	 */
	public function mouseOut($locator) {
		echo $this->getRow('mouseOut', $locator);
	}
	
	/**
	 * Simulates a user hovering a mouse over the specified element. 
	 * @param locator an element locator
	 * @since 0.7
	 */
	public function mouseOver($locator) {
		echo $this->getRow('mouseOver', $locator);
	}
	
	/**
	 * Simulates the event that occurs when the user releases the mouse button 
	 * (i.e., stops holding the button down) on the specified element.
	 * @param locator an element locator
	 * @since 0.8
	 */
	public function mouseUp($locator) {
		echo $this->getRow('mouseUp', $locator);
	}
	
	/**
	 * Simulates the event that occurs when the user releases the mouse button 
	 * (i.e., stops holding the button down) at the specified location.
	 * @param locator an element locator
	 * @param coordString specifies the x,y position (i.e. - 10,20) of the mouse 
	 * event relative to the element returned by the locator.
	 * @since 0.8
	 */
	public function mouseUpAt($locator, $coordString) {
		echo $this->getRow('mouseUpAt', $locator, $coordString);
	}
	
	/**
	 * Opens an URL in the test frame. This accepts both relative and absolute 
	 * URLs. The "open" command waits for the page to load before proceeding, ie. 
	 * the "AndWait" suffix is implicit. Note: The URL must be on the same 
	 * domain as the runner HTML due to security restrictions in the browser 
	 * (Same Origin Policy). If you need to open an URL on another domain, use 
	 * the Selenium Server to start a new browser session on that domain.
	 * @param $url the URL to open; may be relative or absolute
	 * @since 0.6
	 */
	public function open($url) {
		echo $this->getRow('open', $url);
	}
	
	/**
	 * Opens a popup window (if a window with that ID isn't already open). After 
	 * opening the window, you'll need to select it using the selectWindow 
	 * command.
	 *  
	 * This command can also be a useful workaround for bug SEL-339. In some 
	 * cases, Selenium will be unable to intercept a call to window.open (if the 
	 * call occurs during or before the "onLoad" event, for example). In those 
	 * cases, you can force Selenium to notice the open window's name by using 
	 * the Selenium openWindow command, using an empty (blank) url, like this: 
	 * openWindow("", "myFunnyWindow").
	 * @param url the URL to open, which can be blank
	 * @param windowID the JavaScript window ID of the window to select
	 * @since 0.8.1
	 */
	public function openWindow($url, $windowID) {
		echo $this->getRow('openWindow', $url, $windowID);
	}
	
	/**
	 * Wait for the specified amount of time (in milliseconds)
	 * @param waitTime the amount of time to sleep (in milliseconds)
	 * @since 0.8.1
	 */
	public function pause($waitTime) {
		echo $this->getRow('pause', $waitTime);
	}
	
	/**
	 * Simulates the user clicking the "Refresh" button on their browser.
	 * @since 0.7
	 */
	public function refresh() {
		echo $this->getRow('refresh');
	}
	
	/**
	 * Unselects all of the selected options in a multi-select element.
	 * @param locator am element locator identifying a multi-select box
	 * @since 0.8.2
	 */
	public function removeAllSelections($locator) {
		echo $this->getRow('removeAllSelections', $locator);
	}
	
	/**
	 * Remove a selection from the set of selected options in a multi-select 
	 * element using an option locator. 
	 * @param locator an element locator identifying a multi-select box
	 * @param optionLocator an option locator (a label by default)
	 * @since 0.7
	 */
	public function removeSelection($locator, $optionLocator) {
		echo $this->getRow('removeSelection', $locator, $optionLocator);
	}
	
	/**
	 * Creates a new "script" tag in the body of the current test window, and 
	 * adds the specified text into the body of the command. Scripts run in this 
	 * way can often be debugged more easily than scripts executed using 
	 * Selenium's "getEval" command. Beware that JS exceptions thrown in these 
	 * script tags aren't managed by Selenium, so you should probably wrap your 
	 * script in try/catch blocks if there is any chance that the script will 
	 * throw an exception.
	 * @param script the JavaScript snippet to run
	 * @since 0.8.3
	 */
	public function runScript($script) {
		echo $this->getRow('runScript', $script);
	}
	
	/**
	 * Select an option from a drop-down using an option locator.
	 * @param selectLocator an element locator identifying a drop-down menu
	 * @param optionLocator an option locator (a label by default)
	 * @since 0.6
	 */
	public function select($selectLocator, $optionLocator) {
		echo $this->getRow('select', $selectLocator, $optionLocator);
	}
	
	/**
	 * Selects a frame within the current window. (You may invoke this command 
	 * multiple times to select nested frames.) To select the parent frame, use 
	 * "relative=parent" as a locator; to select the top frame, use 
	 * "relative=top". You can also select a frame by its 0-based index number; 
	 * select the first frame with "index=0", or the third frame with "index=2".
	 * 
	 * You may also use a DOM expression to identify the frame you want directly, 
	 * like this: dom=frames["main"].frames["subframe"]
	 * @param locator an element locator identifying a frame or iframe
	 * @since 0.8
	 */
	public function selectFrame($locator) {
		echo $this->getRow('selectFrame', $locator);
	}
	
	/**
	 * Selects a popup window. Once a popup window has been selected, all 
	 * commands go to that window. To select the main window again, use null as 
	 * the target.
	 * @param windowID the JavaScript window ID of the window to select
	 * @since 0.6
	 */
	public function selectWindow($windowID) {
		echo $this->getRow('selectWindow', $windowID);
	}
	
	/**
	 * Sets the threshold for browser-side logging messages; log messages 
	 * beneath this threshold will be discarded. Valid logLevel strings are: 
	 * "debug", "info", "warn", "error" or "off". To see the browser logs, you 
	 * need to either show the log window in GUI mode, or enable browser-side 
	 * logging in Selenium RC.
	 * @param logLevel one of the following: "debug", "info", "warn", "error" or 
	 * "off"
	 * @since 0.8.3
	 */
	public function setBrowserLogLevel($logLevel) {
		echo $this->getRow('setBrowserLogLevel', $logLevel);
	}
	
	/**
	 * Moves the text cursor to the specified position in the given input 
	 * element or textarea. This method will fail if the specified element isn't 
	 * an input element or textarea.
	 * @param locator an element locator pointing to an input element or textarea
	 * @param position  the numerical position of the cursor in the field; 
	 * position should be 0 to move the position to the beginning of the field. 
	 * You can also set the cursor to -1 to move it to the end of the field.
	 * @since 0.8
	 */
	public function setCursorPosition($locator, $position) {
		echo $this->getRow('setCursorPosition', $locator, $position);
	}
	
	/**
	 * Configure the number of pixels between "mousemove" events during 
	 * dragAndDrop commands (default=10). 
	 * 
	 * Setting this value to 0 means that we'll send a "mousemove" event to every 
	 * single pixel in between the start location and the end location; that can 
	 * be very slow, and may cause some browsers to force the JavaScript to 
	 * timeout.
	 * 
	 * If the mouse speed is greater than the distance between the two dragged 
	 * objects, we'll just send one "mousemove" at the start location and then 
	 * one final one at the end location.
	 * @param pixels the number of pixels between "mousemove" events
	 * @since 0.8.2
	 */
	public function setMouseSpeed($pixels) {
		echo $this->getRow('setMouseSpeed', $pixels);
	}
	
	/**
	 * Set execution speed (i.e., set the millisecond length of a delay which 
	 * will follow each selenium operation). By default, there is no such delay, 
	 * i.e., the delay is 0 milliseconds.
	 * @param value the number of milliseconds to pause after operation
	 * @since 0.8.1
	 */
	public function setSpeed($value) {
		echo $this->getRow('setSpeed', $value);
	}
	
	/**
	 * Specifies the amount of time that Selenium will wait for actions to 
	 * complete. 
	 * 
	 * Actions that require waiting include "open" and the "waitFor*" actions.
	 * 
 	 * The default timeout is 30 seconds. 
	 * @param timeout a timeout in milliseconds, after which the action will 
	 * return with an error
	 * @since 0.7
	 */
	public function setTimeout($timeout) {
		echo $this->getRow('setTimeout', $timeout);
	}
	
	/**
	 * Press the shift key and hold it down until doShiftUp() is called or a new 
	 * page is loaded.
	 * @since 0.8.1
	 */
	public function shiftKeyDown() {
		echo $this->getRow('shiftKeyDown');
	}
	
	/**
	 * Release the shift key.
	 * @since 0.8.1
	 */
	public function shiftKeyUp() {
		echo $this->getRow('shiftKeyUp');
	}
	
	/**
	 * This command is a synonym for storeExpression.
	 * @param expression the value to store
	 * @param variableName the name of a variable in which the result is to be 
	 * stored.
	 * @since 0.8.1
	 */
	public function store($expression, $variableName) {
		echo $this->getRow('store', $expression, $variableName);
	}
	
	/**
	 * Submit the specified form. This is particularly useful for forms without 
	 * submit buttons, e.g. single-input "Search" forms. 
	 * @param formLocator an element locator for the form you want to submit
	 * @since 0.7
	 */
	public function submit($formLocator) {
		echo $this->getRow('submit', $formLocator);
	}
	
	/**
	 * Sets the value of an input field, as though you typed it in.
	 * 
	 * Can also be used to set the value of combo boxes, check boxes, etc. In 
	 * these cases, value should be the value of the option selected, not the 
	 * visible text.
	 * @param locator an element locator 
	 * @param value the value to type
	 * @since 0.6
	 */
	public function type($locator, $value) {
		echo $this->getRow('type', $locator, $value);
	}
	
	/**
	 * Simulates keystroke events on the specified element, as though you typed 
	 * the value key-by-key. 
	 * 
	 * This is a convenience method for calling keyDown, keyUp, keyPress for 
	 * every character in the specified string; this is useful for dynamic UI 
	 * widgets (like auto-completing combo boxes) that require explicit key 
	 * events.
	 * 
	 * Unlike the simple "type" command, which forces the specified value into 
	 * the page directly, this command may or may not have any visible effect, 
	 * even in cases where typing keys would normally have a visible effect. 
	 * For example, if you use "typeKeys" on a form element, you may or may not 
	 * see the results of what you typed in the field.
	 * 
	 * In some cases, you may need to use the simple "type" command to set the 
	 * value of the field and then the "typeKeys" command to send the keystroke 
	 * events corresponding to what you just typed.
	 * @param locator an element locator
	 * @param value the value to type
	 * @since 0.8.2
	 */
	public function typeKeys($locator, $value) {
		echo $this->getRow('typeKeys', $locator, $value);
	}
	
	/**
	 * Uncheck a toggle-button (checkbox/radio) 
	 * @param locator an element locator
	 * @since 0.7
	 */
	public function uncheck($locator ) {
		echo $this->getRow('uncheck', $locator);
	}
	
	/**
	 * Runs the specified JavaScript snippet repeatedly until it evaluates to 
	 * "true". The snippet may have multiple lines, but only the result of the 
	 * last line will be considered. 
	 * 
	 * Note that, by default, the snippet will be run in the runner's test 
	 * window, not in the window of your application. To get the window of your 
	 * application, you can use the JavaScript snippet 
	 * selenium.browserbot.getCurrentWindow(), and then run your JavaScript in 
	 * there
	 * @param script the JavaScript snippet to run
	 * @param timeout a timeout in milliseconds, after which this command will 
	 * return with an error
	 * @since 0.7
	 */
	public function waitForCondition($script, $timeout) {
		echo $this->getRow('waitForCondition', $script, $timeout);
	}
	
	/**
	 * Waits for a new frame to load. 
	 * 
	 * Selenium constantly keeps track of new pages and frames loading, and sets 
	 * a "newPageLoaded" flag when it first notices a page load.
	 * 
	 * See waitForPageToLoad for more information.
	 * @param frameAddress FrameAddress from the server side
	 * @param timeout a timeout in milliseconds, after which this command will 
	 * return with an error
	 * @since 0.8.3
	 */
	public function waitForFrameToLoad($frameAddress, $timeout) {
		echo $this->getRow('waitForFrameToLoad', $frameAddress, $timeout);
	}
	
	/**
	 * Waits for a new page to load.
	 * 
	 * You can use this command instead of the "AndWait" suffixes, 
	 * "clickAndWait", "selectAndWait", "typeAndWait" etc. (which are only 
	 * available in the JS API).
	 * 
	 * Selenium constantly keeps track of new pages loading, and sets a 
	 * "newPageLoaded" flag when it first notices a page load. Running any other 
	 * Selenium command after turns the flag to false. Hence, if you want to 
	 * wait for a page to load, you must wait immediately after a Selenium 
	 * command that caused a page-load.
	 * @param timeout a timeout in milliseconds, after which this command will 
	 * return with an error
	 * @since 0.7
	 */
	public function waitForPageToLoad($timeout) {
		echo $this->getRow('waitForPageToLoad', $timeout);
	}
	
	/**
	 * Waits for a popup window to appear and load up. 
	 * @param windowID the JavaScript window ID of the window that will appear
	 * @param timeout a timeout in milliseconds, after which the action will 
	 * return with an error
	 * @since 0.7
	 */
	public function waitForPopUp($windowID, $timeout) {
		echo $this->getRow('waitForPopUp', $windowID, $timeout);
	}
	
	/**
	 * Gives focus to a window.
	 * @param windowName name of the window to be given focus
	 * @since 0.8
	 */
	public function windowFocus($windowName) {
		echo $this->getRow('windowFocus', $windowName);
	}
	
	/**
	 * Resize window to take up the entire screen.
	 * @param windowName name of the window to be enlarged
	 */
	public function windowMaximize($windowName) {
		echo $this->getRow('windowMaximize', $windowName);
	}
	
	/**
	 * Clicks on a link, button, checkbox or radio button. If the click action 
	 * causes a new page to load (like a link usually does), use "clickAndWait".
	 * @param locator an element locator
	 * @since 0.6
	 */
	public function clickAndWait($locator) {
		echo $this->getRow('clickAndWait', $locator);
	}

	/**
	 * Sets the value of an input field, as though you typed it in.
	 * Can also be used to set the value of combo boxes, check boxes, etc. In 
	 * these cases, value should be the value of the option selected, not the 
	 * visible text.
	 * @param locator an element locator 
	 * @param value the value to type
	 * @since 0.6
	 */
	public function typeAndWait($locator, $value) {
		echo $this->getRow('typeAndWait', $locator, $value);
	}

	/**
	 * Select an option from a drop-down using an option locator.
	 * @param locator an element locator identifying a drop-down menu
	 * @param optionLocator an option locator (a label by default)
	 * @since 0.6
	 */
	public function selectAndWait($locator, $optionLocator) {
		echo $this->getRow('selectAndWait', $locator, $optionLocator);
	}

	// Selenium Accessors
	
	/**
	 * Tell Selenium to expect an error on the next command execution.
	 * @param message the error message we should expect. This command will fail 
	 * if the wrong error message appears.
	 * @since 0.8.1
	 * Related Assertions:
	 * assertNotErrorOnNext($message)
	 * verifyErrorOnNext($message)
	 * verifyNotErrorOnNext($message)
	 * waitForErrorOnNext($message)
	 * waitForNotErrorOnNext($message)
	 */
	public function assertErrorOnNext($message) {
		echo $this->getRow('assertErrorOnNext', $message);
	}
	
	/**
	 * Tell Selenium to expect a failure on the next command execution.
	 * @param message the failure message we should expect. This command will 
	 * fail if the wrong failure message appears.
	 * @since 0.8.1
	 * Related Assertions:
	 * assertNotFailureOnNext($message)
	 * verifyFailureOnNext($message)
	 * verifyNotFailureOnNext($message)
	 * waitForFailureOnNext($message)
	 * waitForNotFailureOnNext($message)
	 */
	public function assertFailureOnNext($message) {
		echo $this->getRow('assertFailureOnNext', $message);
	}

	/**
	 * Verifies that the selected option of a drop-down satisfies the 
	 * optionSpecifier. Note that this command is deprecated; you should use 
	 * assertSelectedLabel, assertSelectedValue, assertSelectedIndex, or 
	 * assertSelectedId instead.
	 *  
	 * See the select command for more information about option locators.
	 * @deprecated 
	 * @param selectLocator an element locator identifying a drop-down menu
	 * @param optionLocator  an option locator, typically just an option label 
	 * (e.g. "John Smith")
	 * Related assertions:
	 * assertNotSelected($selectLocator, $optionLocator) 
	 * verifySelected($selectLocator, $optionLocator) 
	 * verifyNotSelected($selectLocator, $optionLocator) 
	 * waitForSelected($selectLocator, $optionLocator) 
	 * waitForNotSelected($selectLocator, $optionLocator)
	 */
	public function assertSelected($selectLocator, $optionLocator) {
		echo $this->getRow('assertSelected', $selectLocator, $optionLocator);
	}
	
	/**
	 * Retrieves the message of a JavaScript alert generated during the previous 
	 * action, or fail if there were no alerts. 
	 * 
	 * Getting an alert has the same effect as manually clicking OK. If an alert 
	 * is generated but you do not get/verify it, the next Selenium action will 
	 * fail.
	 * 
	 * NOTE: under Selenium, JavaScript alerts will NOT pop up a visible alert 
	 * dialog.
	 * 
	 * NOTE: Selenium does NOT support JavaScript alerts that are generated in a 
	 * page's onload() event handler. In this case a visible dialog WILL be 
	 * generated and Selenium will hang until someone manually clicks OK.
	 * @return the message of the most recent JavaScript alert
	 * @since 0.7
	 * Related Assertions:
	 * assertAlert($pattern)
	 * assertNotAlert($pattern)
	 * verifyAlert($pattern)
	 * verifyNotAlert($pattern)
	 * waitForAlert($pattern)
	 * waitForNotAlert($pattern)
	*/
	public function storeAlert($variableName) {
		echo $this->getRow('storeAlert', $variableName);
	}

	/**
	 * Returns the IDs of all buttons on the page. 
	 * If a given button has no ID, it will appear as "" in this array.
	 * @return the IDs of all buttons on the page
	 * @since 0.7
	 * Related Assertions:
	 * assertAllButtons($pattern)
	 * assertNotAllButtons($pattern)
	 * verifyAllButtons($pattern)
	 * verifyNotAllButtons($pattern)
	 * waitForAllButtons($pattern)
	 * waitForNotAllButtons($pattern)
	*/
	public function storeAllButtons($variableName) {
		echo $this->getRow('storeAllButtons', $variableName);
	}
	
	/**
	 * Returns the IDs of all input fields on the page. 
	 * If a given field has no ID, it will appear as "" in this array.
	 * @return the IDs of all fields on the page
	 * @since 0.7
	 * Related Assertions:
	 * assertAllFields($pattern)
	 * assertNotAllFields($pattern)
	 * verifyAllFields($pattern)
	 * verifyNotAllFields($pattern)
	 * waitForAllFields($pattern)
	 * waitForNotAllFields($pattern)
	*/
	public function storeAllFields($variableName) {
		echo $this->getRow('storeAllFields', $variableName);
	}

	/**
	 * Returns the IDs of all links on the page. 
	 * If a given link has no ID, it will appear as "" in this array.
	 * @return the IDs of all links on the page
	 * @since 0.7
	 * Related Assertions:
	 * assertAllLinks($pattern)
	 * assertNotAllLinks($pattern)
	 * verifyAllLinks($pattern)
	 * verifyNotAllLinks($pattern)
	 * waitForAllLinks($pattern)
	 * waitForNotAllLinks($pattern)
	*/
	public function storeAllLinks($variableName) {
		echo $this->getRow('storeAllLinks', $variableName);
	}
	
	/**
	 * Returns the IDs of all windows that the browser knows about.
	 * @return the IDs of all windows that the browser knows about
	 * @since 0.8
	 * Related Assertions:
	 * assertAllWindowIds($pattern)
	 * assertNotAllWindowIds($pattern)
	 * verifyAllWindowIds($pattern)
	 * verifyNotAllWindowIds($pattern)
	 * waitForAllWindowIds($pattern)
	 * waitForNotAllWindowIds($pattern)
	 */
	public function storeAllWindowIds($variableName) {
		echo $this->getRow('storeAllWindowIds', $variableName);
	}
	
	/**
	 * Returns the names of all windows that the browser knows about.
	 * @return the names of all windows that the browser knows about
	 * @since 0.8
	 * Related Assertions:
	 * assertAllWindowNames($pattern)
	 * assertNotAllWindowNames($pattern)
	 * verifyAllWindowNames($pattern)
	 * verifyNotAllWindowNames($pattern)
	 * waitForAllWindowNames($pattern)
	 * waitForNotAllWindowNames($pattern)
	 */
	public function storeAllWindowNames($variableName) {
		echo $this->getRow('storeAllWindowNames', $variableName);
	}
		
	/**
	 * Returns the titles of all windows that the browser knows about.
	 * @return the titles of all windows that the browser knows about
	 * @since 0.8
	 * Related Assertions:
	 * assertAllWindowTitles($pattern)
	 * assertNotAllWindowTitles($pattern)
	 * verifyAllWindowTitles($pattern)
	 * verifyNotAllWindowTitles($pattern)
	 * waitForAllWindowTitles($pattern)
	 * waitForNotAllWindowTitles($pattern)
	 */
	public function storeAllWindowTitles($variableName) {
		echo $this->getRow('storeAllWindowTitles', $variableName);
	}
	
	/**
	 * Gets the value of an element attribute. 
	 * @param attributeLocator an element locator
	 * @param variableName the name of a variable in which the result is to be stored.
	 * @return the value of the specified attribute
	 * @since 0.6
	 * Related Assertions:
	 * assertAttribute($attributeLocator, $pattern)
	 * assertNotAttribute($attributeLocator, $pattern)
	 * verifyAttribute($attributeLocator, $pattern)
	 * verifyNotAttribute($attributeLocator, $pattern)
	 * waitForAttribute($attributeLocator, $pattern)
	 * waitForNotAttribute($attributeLocator, $pattern)
	 */
	public function storeAttribute($attributeLocator, $variableName) {
		echo $this->getRow('storeAttribute', $attributeLocator, $variableName);
	}
	
	/**
	 * Returns every instance of some attribute from all known windows.
	 * @param attributeName name of an attribute on the windows
	 * @param variableName the name of a variable in which the result is to be stored.
	 * @return the set of values of this attribute from all known windows
	 * @since 0.8
	 * Related Assertions:
	 * assertAttributeFromAllWindows($attributeName, $pattern)
	 * assertNotAttributeFromAllWindows($attributeName, $pattern)
	 * verifyAttributeFromAllWindows($attributeName, $pattern)
	 * verifyNotAttributeFromAllWindows($attributeName, $pattern)
	 * waitForAttributeFromAllWindows($attributeName, $pattern)
	 * waitForNotAttributeFromAllWindows($attributeName, $pattern)
	 */
	public function storeAttributeFromAllWindows($attributeName, $variableName) {
		echo $this->getRow('storeAttributeFromAllWindows', $attributeName, $variableName);
	}
	
	/**
	 * Gets the entire text of the page. 
	 * @return the entire text of the page
	 * @since 0.7
	 * Related Assertions:
	 * assertBodyText($pattern)
	 * assertNotBodyText($pattern)
	 * verifyBodyText($pattern)
	 * verifyNotBodyText($pattern)
	 * waitForBodyText($pattern)
	 * waitForNotBodyText($pattern)
	*/
	public function storeBodyText($variableName) {
		echo $this->getRow('storeBodyText', $variableName);
	}
	
	/**
	 * Retrieves the message of a JavaScript confirmation dialog generated during 
	 * the previous action. 
	 * 
	 * By default, the confirm function will return true, having the same effect 
	 * as manually clicking OK. This can be changed by prior execution of the 
	 * chooseCancelOnNextConfirmation command. If an confirmation is generated 
	 * but you do not get/verify it, the next Selenium action will fail.
	 *  
	 * NOTE: under Selenium, JavaScript confirmations will NOT pop up a visible 
	 * dialog.
	 *  
	 * NOTE: Selenium does NOT support JavaScript confirmations that are 
	 * generated in a page's onload() event handler. In this case a visible 
	 * dialog WILL be generated and Selenium will hang until you manually click 
	 * OK. 
	 * @return the message of the most recent JavaScript confirmation dialog
	 * @since 0.7
	 * Related Assertions:
	 * assertConfirmation($pattern)
	 * assertNotConfirmation($pattern)
	 * verifyConfirmation($pattern)
	 * verifyNotConfirmation($pattern)
	 * waitForConfirmation($pattern)
	 * waitForNotConfirmation($pattern)
	*/
	public function storeConfirmation($variableName) {
		echo $this->getRow('storeConfirmation', $variableName);
	}

	/**
	 * Return all cookies of the current page under test.
	 * @return all cookies of the current page under test
	 * @since 0.8
	 * Related Assertions:
	 * assertCookie($pattern)
	 * assertNotCookie($pattern)
	 * verifyCookie($pattern)
	 * verifyNotCookie($pattern)
	 * waitForCookie($pattern)
	 * waitForNotCookie($pattern)
	 */
	public function storeCookie($variableName) {
		echo $this->getRow('storeCookie', $variableName);
	}
	
	/**
	 * Retrieves the text cursor position in the given input element or textarea; 
	 * beware, this may not work perfectly on all browsers.
	 *  
	 * Specifically, if the cursor/selection has been cleared by JavaScript, 
	 * this command will tend to return the position of the last location of the 
	 * cursor, even though the cursor is now gone from the page. This is filed 
	 * as SEL-243.
	 * 
 	 * This method will fail if the specified element isn't an input element or 
 	 * textarea, or there is no cursor in the element.
 	 * @param locator an element locator pointing to an input element or textarea
 	 * @param variableName the name of a variable in which the result is to be 
 	 * stored
 	 * @return the numerical position of the cursor in the field
 	 * @since 0.8
 	 * Related Assertions:
	 * assertCursorPosition($locator, $pattern)
	 * assertNotCursorPosition($locator, $pattern)
	 * verifyCursorPosition($locator, $pattern)
	 * verifyNotCursorPosition($locator, $pattern)
	 * waitForCursorPosition($locator, $pattern)
	 * waitForNotCursorPosition($locator, $pattern)
	 */
	public function storeCursorPosition($locator, $variableName) {
		echo $this->getRow('storeCursorPosition', $locator, $variableName);
	}
		
	/**
	 * Retrieves the height of an element.
	 * @param locator an element locator pointing to an element
 	 * @param variableName the name of a variable in which the result is to be 
 	 * stored
 	 * @return height of an element in pixels
	 * @since 0.8
	 * Related Assertions:
	 * assertElementHeight($locator, $pattern)
	 * assertNotElementHeight($locator, $pattern)
	 * verifyElementHeight($locator, $pattern)
	 * verifyNotElementHeight($locator, $pattern)
	 * waitForElementHeight($locator, $pattern)
	 * waitForNotElementHeight($locator, $pattern)
	 */
	public function storeElementHeight($locator, $variableName) {
		echo $this->getRow('storeElementHeight', $locator, $variableName);
	}
	
	/**
	 * Get the relative index of an element to its parent (starting from 0). The 
	 * comment node and empty text node will be ignored.
	 * @param locator an element locator pointing to an element
 	 * @param variableName the name of a variable in which the result is to be 
 	 * stored
 	 * @return relative index of the element to its parent (starting from 0)
	 * @since 0.8
	 * Related Assertions:
	 * assertElementIndex($locator, $pattern)
	 * assertNotElementIndex($locator, $pattern)
	 * verifyElementIndex($locator, $pattern)
	 * verifyNotElementIndex($locator, $pattern)
	 * waitForElementIndex($locator, $pattern)
	 * waitForNotElementIndex($locator, $pattern)
	 */
	public function storeElementIndex($locator, $variableName) {
		echo $this->getRow('storeElementIndex', $locator, $variableName);
	}
	
	/**
	 * Retrieves the horizontal position of an element.
	 * @param locator an element locator pointing to an element OR an element 
	 * itself
 	 * @param variableName the name of a variable in which the result is to be 
 	 * stored
 	 * @return pixels from the edge of the frame
	 * @since 0.8
	 * Related Assertions:
	 * assertElementPositionLeft($locator, $pattern)
	 * assertNotElementPositionLeft($locator, $pattern)
	 * verifyElementPositionLeft($locator, $pattern)
	 * verifyNotElementPositionLeft($locator, $pattern)
	 * waitForElementPositionLeft($locator, $pattern)
	 * waitForNotElementPositionLeft($locator, $pattern)
	 */
	public function storeElementPositionLeft($locator, $variableName) {
		echo $this->getRow('storeElementPositionLeft', $locator, $variableName);
	}
	
	/**
	 * Retrieves the vertical position of an element.
	 * @param locator an element locator pointing to an element OR an element 
	 * itself
 	 * @param variableName the name of a variable in which the result is to be 
 	 * stored
 	 * @return pixels from the edge of the frame
	 * @since 0.8
	 * Related Assertions:
	 * assertElementPositionTop($locator, $pattern)
	 * assertNotElementPositionTop($locator, $pattern)
	 * verifyElementPositionTop($locator, $pattern)
	 * verifyNotElementPositionTop($locator, $pattern)
	 * waitForElementPositionTop($locator, $pattern)
	 * waitForNotElementPositionTop($locator, $pattern)
	 */
	public function storeElementPositionTop($locator, $variableName) {
		echo $this->getRow('storeElementPositionTop', $locator, $variableName);
	}
	
	/**
	 * Retrieves the width of an element.
	 * @param locator an element locator pointing to an element
 	 * @param variableName the name of a variable in which the result is to be 
 	 * stored
 	 * @return width of an element in pixels
	 * @since 0.8
	 * Related Assertions:
	 * assertElementWidth($locator, $pattern)
	 * assertNotElementWidth($locator, $pattern)
	 * verifyElementWidth($locator, $pattern)
	 * verifyNotElementWidth($locator, $pattern)
	 * waitForElementWidth($locator, $pattern)
	 * waitForNotElementWidth($locator, $pattern)
	 */
	public function storeElementWidth($locator, $variableName) {
		echo $this->getRow('storeElementWidth', $locator, $variableName);
	}
	
	/**
	 * Gets the result of evaluating the specified JavaScript snippet. The 
	 * snippet may have multiple lines, but only the result of the last line 
	 * will be returned.
	 *  
	 * Note that, by default, the snippet will run in the context of the 
	 * "selenium" object itself, so this will refer to the Selenium object, and 
	 * window will refer to the top-level runner test window, not the window of 
	 * your application.
	 * 
	 * If you need to use a locator to refer to a single element in your 
	 * application page, you can use this.browserbot.findElement("id=foo") where 
	 * "id=foo" is your locator.
	 * @param script the JavaScript snippet to run
	 * @param variableName the name of a variable in which the result is to be 
	 * stored.
	 * @return the results of evaluating the snippet
	 * @since 0.7
	 * Related Assertions:
	 * assertEval($script, $pattern)
	 * assertNotEval($script, $pattern)
	 * verifyEval($script, $pattern)
	 * verifyNotEval($script, $pattern)
	 * waitForEval($script, $pattern)
	 * waitForNotEval($script, $pattern)
	*/
	public function storeEval($script, $variableName) {
		echo $this->getRow('storeEval', $script, $variableName);
	}
	
	/**
	 * Returns the specified expression. 
	 * This is useful because of JavaScript preprocessing. It is used to 
	 * generate commands like assertExpression and waitForExpression.
	 * @param expression the value to return
	 * @param variableName the name of a variable in which the result is to be 
	 * stored.
	 * @return the value passed in
	 * @since 0.7
	 * Related Assertions:
	 * assertExpression($expression, $pattern)
	 * assertNotExpression($expression, $pattern)
	 * verifyExpression($expression, $pattern)
	 * verifyNotExpression($expression, $pattern)
	 * waitForExpression($expression, $pattern)
	 * waitForNotExpression($expression, $pattern)
	*/
	public function storeExpression($expression, $variableName) {
		echo $this->getRow('storeExpression', $expression, $variableName);
	}
	
	/**
	 * Returns the entire HTML source between the opening and closing "html" tags. 
	 * @return the entire HTML source
	 * @since 0.7
	 * Related Assertions:
	 * assertHtmlSource($pattern)
	 * assertNotHtmlSource($pattern)
	 * verifyHtmlSource($pattern)
	 * verifyNotHtmlSource($pattern)
	 * waitForHtmlSource($pattern)
	 * waitForNotHtmlSource($pattern)
	*/
	public function storeHtmlSource($variableName) {
		echo $this->getRow('storeHtmlSource', $variableName);
	}

	/**
	 * Gets the absolute URL of the current page.
	 * @return the absolute URL of the current page
	 * @since 0.7
	 * Related Assertions:
	 * assertLocation($pattern)
	 * assertNotLocation($pattern)
	 * verifyLocation($pattern)
	 * verifyNotLocation($pattern)
	 * waitForLocation($pattern)
	 * waitForNotLocation($pattern)
	*/
	public function storeLocation($variableName) {
		echo $this->getRow('storeLocation', $variableName);
	}
			
	/**
	 * Returns the number of pixels between "mousemove" events during 
	 * dragAndDrop commands (default=10).
	 * @return the number of pixels between "mousemove" events during 
	 * dragAndDrop commands (default=10)
	 * @since 0.8.2
	 * Related Assertions:
	 * assertMouseSpeed($pattern)
	 * assertNotMouseSpeed($pattern)
	 * verifyMouseSpeed($pattern)
	 * verifyNotMouseSpeed($pattern)
	 * waitForMouseSpeed($pattern)
	 * waitForNotMouseSpeed($pattern)
	 */
	public function storeMouseSpeed($variableName) {
		echo $this->getRow('storeMouseSpeed', $variableName);
	}
	
	/**
	 * Retrieves the message of a JavaScript question prompt dialog generated 
	 * during the previous action. 
	 * 
	 * Successful handling of the prompt requires prior execution of the 
	 * answerOnNextPrompt command. If a prompt is generated but you do not 
	 * get/verify it, the next Selenium action will fail.
	 * 
	 * NOTE: under Selenium, JavaScript prompts will NOT pop up a visible dialog.
	 * 
	 * NOTE: Selenium does NOT support JavaScript prompts that are generated in 
	 * a page's onload() event handler. In this case a visible dialog WILL be 
	 * generated and Selenium will hang until someone manually clicks OK.
	 * @return the message of the most recent JavaScript question prompt
	 * @since 0.7
	 * Related Assertions:
	 * assertPrompt($pattern)
	 * assertNotPrompt($pattern)
	 * verifyPrompt($pattern)
	 * verifyNotPrompt($pattern)
	 * waitForPrompt($pattern)
	 * waitForNotPrompt($pattern)
	*/
	public function storePrompt($variableName) {
		echo $this->getRow('storePrompt', $variableName);
	}

	/**
	 * Gets option element ID for selected option in the specified select element.
	 * @param selectLocator an element locator identifying a drop-down menu
	 * @param variableName the name of a variable in which the result is to be 
	 * stored
	 * @return the selected option ID in the specified select drop-down
	 * @since 0.8
	 * Related Assertions:
	 * assertSelectedId($selectLocator, $pattern)
	 * assertNotSelectedId($selectLocator, $pattern)
	 * verifySelectedId($selectLocator, $pattern)
	 * verifyNotSelectedId($selectLocator, $pattern)
	 * waitForSelectedId($selectLocator, $pattern)
	 * waitForNotSelectedId($selectLocator, $pattern)
	 */
	public function storeSelectedId($selectLocator, $variableName) {
		echo $this->getRow('storeSelectedId', $selectLocator, $variableName);
	}	
	
	/**
	 * Gets all option element IDs for selected options in the specified select 
	 * or multi-select element.
	 * @param selectLocator an element locator identifying a drop-down menu
	 * @param variableName the name of a variable in which the result is to be 
	 * stored
	 * @return an array of all selected option IDs in the specified select 
	 * drop-down
	 * @since 0.8
	 * Related Assertions:
	 * assertSelectedIds($selectLocator, $pattern)
	 * assertNotSelectedIds($selectLocator, $pattern)
	 * verifySelectedIds($selectLocator, $pattern)
	 * verifyNotSelectedIds($selectLocator, $pattern)
	 * waitForSelectedIds($selectLocator, $pattern)
	 * waitForNotSelectedIds($selectLocator, $pattern)
	 */
	public function storeSelectedIds($selectLocator, $variableName) {
		echo $this->getRow('storeSelectedIds', $selectLocator, $variableName);
	}
	
	/**
	 * Gets option index (option number, starting at 0) for selected option in 
	 * the specified select element.
	 * @param selectLocator an element locator identifying a drop-down menu
	 * @param variableName the name of a variable in which the result is to be 
	 * stored
	 * @return the selected option index in the specified select drop-down
	 * @since 0.8
	 * Related Assertions:
	 * assertSelectedIndex($selectLocator, $pattern)
	 * assertNotSelectedIndex($selectLocator, $pattern)
	 * verifySelectedIndex($selectLocator, $pattern)
	 * verifyNotSelectedIndex($selectLocator, $pattern)
	 * waitForSelectedIndex($selectLocator, $pattern)
	 * waitForNotSelectedIndex($selectLocator, $pattern)
	 */
	public function storeSelectedIndex($selectLocator, $variableName) {
		echo $this->getRow('storeSelectedIndex', $selectLocator, $variableName);
	}
	
	/**
	 * Gets all option indexes (option number, starting at 0) for selected 
	 * options in the specified select or multi-select element.
	 * @param selectLocator an element locator identifying a drop-down menu
	 * @param variableName the name of a variable in which the result is to be 
	 * stored
	 * @return an array of all selected option indexes in the specified select 
	 * drop-down
	 * @since 0.8
	 * Related Assertions:
	 * assertSelectedIndexes($selectLocator, $pattern)
	 * assertNotSelectedIndexes($selectLocator, $pattern)
	 * verifySelectedIndexes($selectLocator, $pattern)
	 * verifyNotSelectedIndexes($selectLocator, $pattern)
	 * waitForSelectedIndexes($selectLocator, $pattern)
	 * waitForNotSelectedIndexes($selectLocator, $pattern)
	 */
	public function storeSelectedIndexes($selectLocator, $variableName) {
		echo $this->getRow('storeSelectedIndexes', $selectLocator, $variableName);
	}
	
	/**
	 * Gets option label (visible text) for selected option in the specified 
	 * select element.
	 * @param selectLocator an element locator identifying a drop-down menu
	 * @param variableName the name of a variable in which the result is to be 
	 * stored
	 * @return the selected option label in the specified select drop-down
	 * @since 0.8
	 * Related Assertions:
	 * assertSelectedLabel($selectLocator, $pattern)
	 * assertNotSelectedLabel($selectLocator, $pattern)
	 * verifySelectedLabel($selectLocator, $pattern)
	 * verifyNotSelectedLabel($selectLocator, $pattern)
	 * waitForSelectedLabel($selectLocator, $pattern)
	 * waitForNotSelectedLabel($selectLocator, $pattern)
	 */
	public function storeSelectedLabel($selectLocator, $variableName) {
		echo $this->getRow('storeSelectedLabel', $selectLocator, $variableName);
	}
	
	/**
	 * Gets all option labels (visible text) for selected options in the 
	 * specified select or multi-select element.
	 * @param selectLocator an element locator identifying a drop-down menu
	 * @param variableName the name of a variable in which the result is to be 
	 * stored
	 * @return an array of all selected option labels in the specified select 
	 * drop-down
	 * @since 0.8
	 * Related Assertions:
	 * assertSelectedLabels($selectLocator, $pattern)
	 * assertNotSelectedLabels($selectLocator, $pattern)
	 * verifySelectedLabels($selectLocator, $pattern)
	 * verifyNotSelectedLabels($selectLocator, $pattern)
	 * waitForSelectedLabels($selectLocator, $pattern)
	 * waitForNotSelectedLabels($selectLocator, $pattern)
	 */
	public function storeSelectedLabels($selectLocator, $variableName) {
		echo $this->getRow('storeSelectedLabels', $selectLocator, $variableName);
	}
	
	/**
	 * Gets option value (value attribute) for selected option in the specified 
	 * select element.
	 * @param selectLocator an element locator identifying a drop-down menu
	 * @param variableName the name of a variable in which the result is to be 
	 * stored
	 * @return the selected option value in the specified select drop-down
	 * @since 0.8
	 * Related Assertions:
	 * assertSelectedValue($selectLocator, $pattern)
	 * assertNotSelectedValue($selectLocator, $pattern)
	 * verifySelectedValue($selectLocator, $pattern)
	 * verifyNotSelectedValue($selectLocator, $pattern)
	 * waitForSelectedValue($selectLocator, $pattern)
	 * waitForNotSelectedValue($selectLocator, $pattern)
	 */
	public function storeSelectedValue($selectLocator, $variableName) {
		echo $this->getRow('storeSelectedValue', $selectLocator, $variableName);
	}
	
	/**
	 * Gets all option values (value attributes) for selected options in the 
	 * specified select or multi-select element.
	 * @param selectLocator an element locator identifying a drop-down menu
	 * @param variableName the name of a variable in which the result is to be 
	 * stored
	 * @return an array of all selected option values in the specified select 
	 * drop-down
	 * @since 0.8
	 * Related Assertions:
	 * assertSelectedValues($selectLocator, $pattern)
	 * assertNotSelectedValues($selectLocator, $pattern)
	 * verifySelectedValues($selectLocator, $pattern)
	 * verifyNotSelectedValues($selectLocator, $pattern)
	 * waitForSelectedValues($selectLocator, $pattern)
	 * waitForNotSelectedValues($selectLocator, $pattern)
	 */
	public function storeSelectedValues($selectLocator, $variableName) {
		echo $this->getRow('storeSelectedValues', $selectLocator, $variableName);
	}
	
	/**
	 * Gets all option labels in the specified select drop-down.
	 * @param selectLocator an element locator  identifying a drop-down menu
	 * @param variableName the name of a variable in which the result is to be 
	 * stored.
	 * @return an array of all option labels in the specified select drop-down
	 * @since 0.7
	 * Related Assertions:
	 * assertSelectOptions($selectLocator, $pattern)
	 * assertNotSelectOptions($selectLocator, $pattern)
	 * verifySelectOptions($selectLocator, $pattern)
	 * verifyNotSelectOptions($selectLocator, $pattern)
	 * waitForSelectOptions($selectLocator, $pattern)
	 * waitForNotSelectOptions($selectLocator, $pattern)
	*/
	public function storeSelectOptions($selectLocator, $variableName) {
		echo $this->getRow('storeSelectOptions', $selectLocator, $variableName);
	}

	/**
	 * Gets the text from a cell of a table. The cellAddress syntax 
	 * tableLocator.row.column, where row and column start at 0. 
	 * @param tableCellAddress a cell address, e.g. "foo.1.4"
	 * @param variableName the name of a variable in which the result is to be 
	 * stored.
	 * @return the text from the specified cell
	 * @since 0.7
	 * Related Assertions:
	 * assertTable($tableCellAddress, $pattern)
	 * assertNotTable($tableCellAddress, $pattern)
	 * verifyTable($tableCellAddress, $pattern)
	 * verifyNotTable($tableCellAddress, $pattern)
	 * waitForTable($tableCellAddress, $pattern)
	 * waitForNotTable($tableCellAddress, $pattern)
	*/
	public function storeTable($tableCellAddress, $variableName) {
		echo $this->getRow('storeTable', $tableCellAddress, $variableName);
	}
	
	/**
	 * Gets the text of an element. This works for any element that contains 
	 * text. This command uses either the textContent(Mozilla-like browsers) or 
	 * the innerText (IE-like browsers) of the element, which is the rendered 
	 * text shown to the user. 
	 * @param locator an element locator 
	 * @param variableName the name of a variable in which the result is to be 
	 * stored.
	 * @return the text of the element
	 * @since 0.6
	 * Related Assertions:
	 * assertText($locator, $pattern)
	 * assertNotText($locator, $pattern)
	 * verifyText($locator, $pattern)
	 * verifyNotText($locator, $pattern)
	 * waitForText($locator, $pattern)
	 * waitForNotText($locator, $pattern)
	 */
	public function storeText($locator, $variableName) {
		echo $this->getRow('storeText', $locator, $variableName);
	}

	/**
	 * Gets the title of the current page. 
	 * @return the title of the current page
	 * @since 0.7
	 * Related Assertions:
	 * assertTitle($pattern)
	 * assertNotTitle($pattern)
	 * verifyTitle($pattern)
	 * verifyNotTitle($pattern)
	 * waitForTitle($pattern)
	 * waitForNotTitle($pattern)
	*/
	public function storeTitle($variableName) {
		echo $this->getRow('storeTitle', $variableName);
	}

	/**
	 * Gets the (whitespace-trimmed) value of an input field (or anything else 
	 * with a value parameter). For checkbox/radio elements, the value will be 
	 * "on" or "off" depending on whether the element is checked or not. 	
	 * @param locator an element locator 
	 * @param variableName the name of a variable in which the result is to be 
	 * stored.
	 * @return the element value, or "on/off" for checkbox/radio elements
	 * @since 0.6
	 * Related Assertions:
	 * assertValue($locator, $pattern)
	 * assertNotValue($locator, $pattern)
	 * verifyValue($locator, $pattern)
	 * verifyNotValue($locator, $pattern)
	 * waitForValue($locator, $pattern)
	 * waitForNotValue($locator, $pattern)
	 */
	public function storeValue($locator, $variableName) {
		echo $this->getRow('storeValue', $locator, $variableName);
	}

	/**
	 * Determine whether current/locator identify the frame containing this 
	 * running code. 
	 * 
	 * This is useful in proxy injection mode, where this code runs in every 
	 * browser frame and window, and sometimes the selenium server needs to 
	 * identify the "current" frame. In this case, when the test calls 
	 * selectFrame, this routine is called for each frame to figure out which 
	 * one has been selected. The selected frame will return true, while all 
	 * others will return false.
	 * @param currentFrameString starting frame
	 * @param target new frame (which might be relative to the current one)
	 * @param variableName the name of a variable in which the result is to be 
	 * stored.
	 * @return true if the new frame is this code's window
	 * @since 0.8.1
	 * assertWhetherThisFrameMatchFrameExpression($currentFrameString, $target)
	 * assertNotWhetherThisFrameMatchFrameExpression($currentFrameString, $target)
	 * verifyWhetherThisFrameMatchFrameExpression($currentFrameString, $target)
	 * verifyNotWhetherThisFrameMatchFrameExpression($currentFrameString, $target)
	 * waitForWhetherThisFrameMatchFrameExpression($currentFrameString, $target)
	 * waitForWhetherThisFrameMatchFrameExpression($currentFrameString, $target)
	 */
	public function storeWhetherThisFrameMatchFrameExpression($currentFrameString, $target, $variableName) {
		echo $this->getRow('storeWhetherThisFrameMatchFrameExpression', $currentFrameString, $target, $variableName);
	}

	/**
	 * Determine whether currentWindowString plus target identify the window 
	 * containing this running code. 
	 * 
	 * This is useful in proxy injection mode, where this code runs in every 
	 * browser frame and window, and sometimes the selenium server needs to 
	 * identify the "current" window. In this case, when the test calls 
	 * selectWindow, this routine is called for each window to figure out which 
	 * one has been selected. The selected window will return true, while all 
	 * others will return false.
	 * @param currentWindowString starting window
	 * @param target new window (which might be relative to the current one, 
	 * e.g. "_parent")
	 * @param variableName the name of a variable in which the result is to be 
	 * stored
	 * @return true if the new window is this code's window
	 * @since 0.8.1
	 * assertWhetherThisWindowMatchWindowExpression($currentWindowString, $target)
	 * assertNotWhetherThisWindowMatchWindowExpression($currentWindowString, $target)
	 * verifyWhetherThisWindowMatchWindowExpression($currentWindowString, $target)
	 * verifyNotWhetherThisWindowMatchWindowExpression($currentWindowString, $target)
	 * waitForWhetherThisWindowMatchWindowExpression($currentWindowString, $target)
	 * waitForWhetherThisWindowMatchWindowExpression($currentWindowString, $target)
	 */
	public function storeWhetherThisWindowMatchWindowExpression($currentWindowString, $target, $variableName) {
		echo $this->getRow('storeWhetherThisWindowMatchWindowExpression', $currentWindowString, $target, $variableName);
	}		
	
	/**
	 * Returns the number of nodes that match the specified xpath, eg. "//table" 
	 * would give the number of tables.
	 * @param xpath the xpath expression to evaluate. do NOT wrap this 
	 * expression in a 'count()' function; we will do that for you.
	 * @param variableName  the name of a variable in which the result is to be 
	 * stored.
	 * @return the number of nodes that match the specified xpath
	 * @since 0.8.3
	 * Related assertions:
	 * assertXpathCount($xpath, $pattern) 
	 * assertNotXpathCount($xpath, $pattern) 
	 * verifyXpathCount($xpath, $pattern) 
	 * verifyNotXpathCount($xpath, $pattern) 
	 * waitForXpathCount($xpath, $pattern) 
	 * waitForNotXpathCount($xpath, $pattern)
	 */
	public function storeXpathCount($xpath, $variableName) {
		echo $this->getRow('storeXpathCount', $xpath, $variableName);
	}
	
	/**
	 * Has an alert occurred? 
 	 * This function never throws an exception 
	 * @return true if there is an alert
	 * @since 0.7
	 * Related Assertions:
	 * assertAlertPresent()
	 * assertAlertNotPresent()
	 * verifyAlertPresent()
	 * verifyAlertNotPresent()
	 * waitForAlertPresent()
	 * waitForAlertNotPresent()
	 */
	public function storeAlertPresent($variableName) {
		echo $this->getRow('storeAlertPresent', $variableName);
	}   

	/**
	 * Gets whether a toggle-button (checkbox/radio) is checked. Fails if the 
	 * specified element doesn't exist or isn't a toggle-button. 
	 * @param locator an element locator pointing to a checkbox or radio button
	 * @param variableName the name of a variable in which the result is to be 
	 * stored.
	 * @return true if the checkbox is checked, false otherwise
	 * @since 0.7
	 * Related Assertions:
	 * assertChecked($locator)
	 * assertNotChecked($locator)
	 * verifyChecked($locator)
	 * verifyNotChecked($locator)
	 * waitForChecked($locator)
	 * waitForNotChecked($locator)
	*/
	public function storeChecked($locator, $variableName) {
		echo $this->getRow('storeChecked', $locator, $variableName);
	}

	/**
	 * Has confirm() been called?
 	 * This function never throws an exception 
	 * @return true if there is a pending confirmation
	 * @since 0.7
	 * Related Assertions:
	 * assertConfirmationPresent()
	 * assertConfirmationNotPresent()
	 * verifyConfirmationPresent()
	 * verifyConfirmationNotPresent()
	 * waitForConfirmationPresent()
	 * waitForConfirmationNotPresent()
	*/
	public function storeConfirmationPresent($variableName) {
		echo $this->getRow('storeConfirmationPresent', $variableName);
	}
		
	/**
	 * Determines whether the specified input element is editable, ie hasn't 
	 * been disabled. This method will fail if the specified element isn't an 
	 * input element. 
	 * @param locator an element locator 
	 * @param variableName the name of a variable in which the result is to be 
	 * stored. 
	 * @return true if the input element is editable, false otherwise
	 * @since 0.7
	 * Related Assertions:
	 * assertEditable($locator)
	 * assertNotEditable($locator)
	 * verifyEditable($locator)
	 * verifyNotEditable($locator)
	 * waitForEditable($locator)
	 * waitForNotEditable($locator)
	*/
	public function storeEditable($locator, $variableName) {
		echo $this->getRow('storeEditable', $locator, $variableName);
	}

	/**
	 * Verifies that the specified element is somewhere on the page. 
	 * @param locator an element locator 
	 * @param variableName the name of a variable in which the result is to be 
	 * stored.
	 * @return true if the element is present, false otherwise
	 * @since 0.7
	 * Related Assertions:
	 * assertElementPresent($locator)
	 * assertElementNotPresent($locator)
	 * verifyElementPresent($locator)
	 * verifyElementNotPresent($locator)
	 * waitForElementPresent($locator)
	 * waitForElementNotPresent($locator)
	*/
	public function storeElementPresent($locator, $variableName) {
		echo $this->getRow('storeElementPresent', $locator, $variableName);
	}

	/**
	 * Check if these two elements have same parent and are ordered. Two same 
	 * elements will not be considered ordered.
	 * @param locator1 an element locator pointing to the first element
	 * @param locator2 an element locator pointing to the second element
	 * @param the name of a variable in which the result is to be stored.
	 * @return true if two elements are ordered and have same parent, false 
	 * otherwise
	 * @since 0.8.1
	 * Related Assertions:
	 * assertOrdered($locator1, $locator2)
	 * assertNotOrdered($locator1, $locator2)
	 * verifyOrdered($locator1, $locator2)
	 * verifyNotOrdered($locator1, $locator2)
	 * waitForOrdered($locator1, $locator2)
	 * waitForNotOrdered($locator1, $locator2)
	 */
	public function storeOrdered($locator1, $locator2, $variableName) {
		echo $this->getRow('storeOrdered', $locator1, $locator2, $variableName);
	}
	
	/**
	 * Has a prompt occurred? 
 	 * This function never throws an exception 
	 * @return true if there is a pending prompt
	 * @since 0.7
	 * Related Assertions:
	 * assertPromptPresent()
	 * assertPromptNotPresent()
	 * verifyPromptPresent()
	 * verifyPromptNotPresent()
	 * waitForPromptPresent()
	 * waitForPromptNotPresent()
	 */
	public function storePromptPresent($variableName) {
		echo $this->getRow('storePromptPresent', $variableName);
	}

	/**
	 * Determines whether some option in a drop-down menu is selected.
	 * @param selectLocator an element locator identifying a drop-down menu
	 * @param variableName the name of a variable in which the result is to be 
	 * stored
	 * @return true if some option has been selected, false otherwise
	 * @since 0.8
	 * Related Assertions:
	 * assertSomethingSelected($selectLocator)
	 * assertNotSomethingSelected($selectLocator)
	 * verifySomethingSelected($selectLocator)
	 * verifyNotSomethingSelected($selectLocator)
	 * waitForSomethingSelected($selectLocator)
	 * waitForNotSomethingSelected($selectLocator)
	 */
	public function storeSomethingSelected($selectLocator, $variableName) {
		echo $this->getRow('storeSomethingSelected', $selectLocator, $variableName);
	}

	/**
	 * Verifies that the specified text pattern appears somewhere on the 
	 * rendered page shown to the user. 
	 * @param pattern a pattern to match with the text of the page
	 * @param variableName the name of a variable in which the result is to be 
	 * stored.
	 * @return true if the pattern matches the text, false otherwise
	 * @since 0.7
	 * Related Assertions:
	 * assertTextPresent($pattern)
	 * assertTextNotPresent($pattern)
	 * verifyTextPresent($pattern)
	 * verifyTextNotPresent($pattern)
	 * waitForTextPresent($pattern)
	 * waitForTextNotPresent($pattern)
	*/
	public function storeTextPresent($pattern, $variableName) {
		echo $this->getRow('storeTextPresent', $pattern, $variableName);
	}

	/**
	 * Determines if the specified element is visible. An element can be 
	 * rendered invisible by setting the CSS "visibility" property to "hidden", 
	 * or the "display" property to "none", either for the element itself or one 
	 * if its ancestors. This method will fail if the element is not present. 
	 * @param locator an element locator 
	 * @param variableName the name of a variable in which the result is to be stored.
	 * @return true if the specified element is visible, false otherwise
	 * @since 0.7
	 * Related Assertions:
	 * assertVisible($locator)
	 * assertNotVisible($locator)
	 * verifyVisible($locator)
	 * verifyNotVisible($locator)
	 * waitForVisible($locator)
	 * waitForNotVisible($locator)
	*/
	public function storeVisible($locator, $variableName) {
		echo $this->getRow('storeVisible', $locator, $variableName);
	}
	
	private function beginsWith( $str, $sub ) {
    	return (substr($str, 0, strlen($sub)) === $sub);
 	}
	
	private function endsWith( $str, $sub ) {
    	return (substr($str, strlen($str) - strlen($sub)) === $sub);
 	}
 	
 	private function getRow($value1, $value2 = '&nbsp;', $value3 = '&nbsp;') {
	    $value2 = $this->ieXpathFix($value2); 
	    $value3 = $this->ieXpathFix($value3); 
		return '<tr><td>'.$value1.'</td><td>'.$value2.'</td><td>'.$value3.'</td></tr>';
	}

	private function ieXpathFix($value) {
		// Check if the value is ment to be an xpath	    
		if ((strpos($value, 'xpath=')===0) || (strpos($value, '//')===0)) {
			$regex = "/id\('(.+)'\)/iUs";
			$replace = "//*[@id='\\1']";                
                
			$value = preg_replace($regex, $replace, $value);
		}
		
		return $value;
	}
}