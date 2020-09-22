<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Terence J. Grant <tjgrant@tatewake.com>
 */

/**
 * Return a permanent URL to a page
 *
 * @return string
 * @deprecated 2020-09-19 If the template uses https://www.dokuwiki.org/devel:menus, the button to the cite page is added automatically
 */
function cite_getPermURL()
{
    global $INFO, $ID, $REV;

    //get active revision
    $rev = $REV; //$REV includes converted DATE_AT as well
    if (!$rev) {
        $rev = $INFO['lastmod'];
    }

    //return a URL with that
    return wl($ID, ['rev' => $rev], true);
}

/**
 * Return a URL to cite a page, based on the permanent URL
 *
 * @return string
 * @deprecated 2020-09-19 If the template uses https://www.dokuwiki.org/devel:menus, the button to the cite page is added automatically
 */
function cite_getCiteURL()
{
    global $INFO, $ID, $REV;
    //get active revision
    $rev = $REV; //$REV includes converted DATE_AT as well
    if (!$rev) {
        $rev = $INFO['lastmod'];
    }

    //return a permanent link with citation
    return wl($ID, ['rev' => $rev, 'do' => 'cite'], true);
}
