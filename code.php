<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Terence J. Grant <tjgrant@tatewake.com>
 */

//Return a permanent URL to a page
function cite_getPermURL()
{
	global $INFO, $ID;

	//get active revision
	if (!isset($_REQUEST['rev'])) $_REQUEST['rev'] = $INFO['lastmod'];

	//return a URL with that
	return DOKU_URL.DOKU_SCRIPT.'?id='.$ID.'&amp;rev='.$_REQUEST['rev'];
}

//Return a URL to cite a page, based on the permanent URL
function cite_getCiteURL()
{
	//return a permanent link with citation
	return cite_getPermURL().'&amp;do=cite';
}
