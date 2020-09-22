<?php

namespace dokuwiki\plugin\cite;

use dokuwiki\Menu\Item\AbstractItem;

/**
 * Class MenuItem
 *
 * Implements the button to the citations page for DokuWiki's menu system
 *
 * @package dokuwiki\plugin\cite
 */
class MenuItem extends AbstractItem
{

    /** @var string do action for this plugin */
    protected $type = 'cite';


    /** @var string icon file */
    protected $svg = __DIR__ . '/cite.svg';

    /**
     * MenuItem constructor.
     */
    public function __construct()
    {
        parent::__construct();
        global $REV, $DATE_AT;

        if ($DATE_AT) {
            $this->params['at'] = $DATE_AT;
        } elseif ($REV) {
            $this->params['rev'] = $REV;
        }
    }

    /**
     * Get label from plugin language file
     *
     * @return string
     */
    public function getLabel()
    {
        $hlp = plugin_load('action', 'cite');
        return $hlp->getLang('cite_button');
    }
}
