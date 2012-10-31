<?php
$config = array(
	/*
	 * Used to replace ./ in src & href if magicUrl is active.
	 * 
	 * Default: './'
	 */
	// 'baseUrl' => './',

	/*
	 * Starting count for tabs.
	 * 
	 * Default: 0
	 */
	// 'tabs' => 0,

	/*
	 * The string that is used for indenting new lines.
	 * 
	 * Default: "\t"
	 */
	// 'tab' => "\t",

	/*
	 * The string that is used to break the current line.
	 * 
	 * Default: "\n"
	 */
	// 'break' => "\n",

	/*
	 * Skip Comments?
	 * 
	 * Default: false
	 */
	// 'noComments' => false,

	/*
	 * Use MagicUrl?
	 * 
	 * Default: true
	 */
	// 'magicUrl' => true,

	/*
	 * How mutch spaces is the worth of the 'tab' setting.
	 * 
	 * Default: 8
	 */
	// 'tabWorth' => 8,
	
	/*
	 * Maximum count of letters per line.
	 * 
	 * Default: 140
	 */
	// 'maxLineWidth' => 140,

	/*
	 * Maximum count of letters per line.
	 * 
	 * Default: 140
	 */
	// 'minLineWidth' => 50,
	
	/*
	 * Set true to disable everything.
	 * 
	 * Default: false
	 */
	// 'disable' => false,

	/*
	 * Debug mode.
	 * 
	 * false = off
	 * 'Exception' will throw the debug messages as \Exception.
	 * 'THEDEBUG' will try to use THEDEBUG from !THE MASTER (https://github.com/Xiphe/-THE-MASTER)
	 * 
	 * Default: false
	 */
	// 'debug' => false,
	
	/*
	 * Where should the opened tags be stored?
	 * 'global' will use a static class variable of Xiphe\HTML\core\store 
	 *          so every instance of HTML can close tags opened by other instances.
	 * 'local'  will use the store variable of the HTML instance.
	 *          This instance is unable to close tags from other instances and its tags can
	 *          not be closed by other instances.
	 *
	 * Default: 'global'
	 */
	// 'store' => 'global'
);
?>