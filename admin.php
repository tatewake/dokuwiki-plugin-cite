<?php

/**
 * Citations for DokuWiki
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Terence J. Grant<tjgrant@tatewake.com>
 */

class admin_plugin_cite extends DokuWiki_Admin_Plugin
{
    /** @inheritdoc */
    public function handle()
    {
    }

    /**
     * output appropriate html
     */
    public function html()
    {
        echo '<div class="plugin_cite">';

        echo $this->locale_xhtml('intro');

        echo '</div>';
    }
}
