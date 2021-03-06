<?php
/**
 * Media Wiki Caller extension - based on the stripped-down extensions/BoilerPlate
 *
 * For more info see mediawiki.org/wiki/Extension:MWCall
 * You should add a brief comment explaining what the file contains and
 * what it is for. MediaWiki core uses the doxygen documentation syntax,
 * you're recommended to use those tags to complement your comment.
 * See the online documentation at:
 * http://www.stack.nl/~dimitri/doxygen/manual.html
 *
 * Here are commonly used tags, most of them are optional, though:
 *
 * First we tag this document block as describing the entire file (as opposed
 * to a variable, class or function):
 * @file
 *
 * We regroup all extensions documentation in the group named "Extensions":
 * @ingroup Extensions
 *
 * The author would let everyone know who wrote the code, if there is more
 * than one author, add multiple author annotations:
 * @author KeerthanaK
 * //MAJOR CREDITS TO JSCommunicator : @Daniel Pocock and @Juliana Louback
 *
 * To mention the file version in the documentation:
 * @version 1.0
 *
 * The license governing the extension code:
 * @license GNU General Public Licence 2.0 or later
 */

/**
 * MediaWiki has several global variables which can be reused or even altered
 * by your extension. The very first one is the $wgExtensionCredits which will
 * expose to MediaWiki metadata about your extension. For additional
 * documentation, see its documentation block in includes/DefaultSettings.php
 */
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,

	// Name of your Extension:
	'name' => 'Media Wiki Call',

	// Sometime other patches contributors and minor authors are not worth
	// mentionning, you can use the special case '...' to output a localised
	// message 'and others...'.
	'author' => array(
		'Keerthana K'
	
	),

	'version'  => '0.1.0',

	// The extension homepage. www.mediawiki.org will be happy to host
	// your extension homepage.
	'url' => 'https://www.mediawiki.org/wiki/Extension:MWCall',


	# Key name of the message containing the description.
	'descriptionmsg' => 'mwcall-desc',
);

/* Setup */

// Initialize an easy to use shortcut:
$dir = dirname( __FILE__ );
$dirbasename = basename( $dir );

// Register files
// MediaWiki need to know which PHP files contains your class. It has a
// registering mecanism to append to the internal autoloader. Simply use
// $wgAutoLoadClasses as below:
$wgAutoloadClasses['MWCallHooks'] = $dir . '/Mwcall.hooks.php';
$wgAutoloadClasses['SpecialMWConfiger'] = $dir . '/specials/MWConfiger.php';
$wgAutoloadClasses['SpecialMWCaller'] = $dir . '/specials/MWCaller.php';
//$wgAutoloadClasses['']
$wgAutoloadClasses['ApiQueryMwcall'] = $dir . '/api/ApiQueryMwcall.php';

$wgMessagesDirs['Mwcall'] = __DIR__ . '/i18n';
//$wgExtensionMessagesFiles['ExampleAlias'] = $dir . '/Example.i18n.alias.php';
//$wgExtensionMessagesFiles['ExampleMagic'] = $dir . '/Example.i18n.magic.php';

//$wgAPIListModules['example'] = 'ApiQueryExample';

// Register hooks
// See also http://www.mediawiki.org/wiki/Manual:Hooks
$wgHooks['BeforePageDisplay'][] = 'MWCallHooks::onBeforePageDisplay';
$wgHooks['ResourceLoaderGetConfigVars'][] = 'MWCallHooks::onResourceLoaderGetConfigVars';
$wgHooks['ParserFirstCallInit'][] = 'MWCallHooks::onParserFirstCallInit';
$wgHooks['MagicWordwgVariableIDs'][] = 'MWCallHooks::onRegisterMagicWords';
$wgHooks['ParserGetVariableValueSwitch'][] = 'MWCallHooks::onParserGetVariableValueSwitch';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'MWCallHooks::onLoadExtensionSchemaUpdates';

// Register special pages
// See also http://www.mediawiki.org/wiki/Manual:Special_pages
$wgSpecialPages['MWConfig'] = 'SpecialMWConfiger';
$wgSpecialPages['MWCall'] = 'SpecialMWCaller';

// Register modules
// See also http://www.mediawiki.org/wiki/Manual:$wgResourceModules
// ResourceLoader modules are the de facto standard way to easily
// load JavaScript and CSS files to the client.

$wgResourceModules['ext.Mwcall.Caller'] = array(
	'scripts' => array(
		'modules/Arbiter.js', 'modules/config.js', 'modules/event-demo.js', 'modules/init.js', 'modules/jquery.cookie.js', 'modules/jquery.i18n.properties', 'modules/jquery.js', 'modules/jquery-ui.js', 'modules/JSComm.js', 'modules/JSCommManager.js', 'modules/JSCommUI.js', 'modules/jssip.js', 'modules/jssip-helper.js', 'modules/parseuri.js', 'modules/webrtc-check.js' ),
	'styles' => array(
		'modules/font-awesome.min.css', 'modules/jquery-ui.css', 'modules/skin.css', 'modules/style.css', 'modules/style-debrtc.css', 'modules/style-event-demo.css','modules/style-horizontal.css'
	),
	'messages' => array(
		'example-welcome-title-loggedout',
		'example-welcome-title-user',
		'example-welcome-color-label',
		'example-welcome-color-value',
	),
	'dependencies' => array(
		'mediawiki.util',
		'mediawiki.user',
		'mediawiki.Title',
	),
	'localBasePath' => $dir,
	'remoteExtPath' => 'mwcall/' . $dirbasename,
);


$wgResourceModules['ext.Mwcall.welcome'] = array(
	'scripts' => array(
		'modules/ext.Mwcall.welcome.js',
	),
	'styles' => array(
		'modules/ext.Mwcall.welcome.css',
	),
	'messages' => array(
		'example-welcome-title-loggedout',
		'example-welcome-title-user',
		'example-welcome-color-label',
		'example-welcome-color-value',
	),
	'dependencies' => array(
		'mediawiki.util',
		'mediawiki.user',
		'mediawiki.Title',
	),

	'localBasePath' => $dir,
	'remoteExtPath' => 'mwcall/' . $dirbasename,
);

$wgResourceModules['ext.Mwcall.welcome.init'] = array(
	'scripts' => 'modules/ext.Mwcall.welcome.init.js',
	'dependencies' => array(
		'ext.Mwcall.welcome',
	),

	'localBasePath' => $dir,
	'remoteExtPath' => 'mwcall/' . $dirbasename,
);

//Configuration 


/** Your extension configuration settings. Since they are going to be global
 * always use a "wg" prefix + your extension name + your setting key.
 * The entire variable name should use "lowerCamelCase".
 

// Enable Welcome
// Example of a configuration setting to enable the 'Welcome' feature:
$wgExampleEnableWelcome = false;

// Color map for the Welcome feature
$wgExampleWelcomeColorDefault = '#eee';
// Days not defined here fall back to the default
$wgExampleWelcomeColorDays = array(
	'Monday' => 'orange',
	'Tuesday' => 'blue',
	'Wednesday' => 'green',
	'Thursday' => 'red',
	'Friday' => 'yellow',
);

// Value of {{MYWORD}} constant
$wgExampleMyWord = 'Awesome';
*/