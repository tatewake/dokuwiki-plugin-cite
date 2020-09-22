<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Terence J. Grant <tjgrant@tatewake.com>
 */

include_once(DOKU_PLUGIN . 'cite/code.php'); //this ensures the functions in code.php are always available

class action_plugin_cite extends DokuWiki_Action_Plugin
{
    /**
     * register the eventhandlers
     *
     * @param Doku_Event_Handler $controller
     */
    public function register(Doku_Event_Handler $controller)
    {
        $controller->register_hook('ACTION_ACT_PREPROCESS', 'BEFORE', $this, '_handle_act', array());
        $controller->register_hook('TPL_ACT_UNKNOWN', 'BEFORE', $this, '_handle_tpl_act', array());
        $controller->register_hook('MENU_ITEMS_ASSEMBLY', 'AFTER', $this, 'addsvgbutton', array());
    }

    public function _handle_act($event, $param)
    {
        if ($event->data != 'cite') {
            return;
        }
        $event->preventDefault();
    }

    public function _handle_tpl_act($event, $param)
    {
        if ($event->data != 'cite') {
            return;
        }
        $event->preventDefault();

        global $conf, $ID, $REV, $INFO;

        //get always a revision id
        $revisionId = $REV; //$REV includes converted DATE_AT as well
        if (!$revisionId) {
            $revisionId = $INFO['lastmod'];
        }

        $pagename = tpl_pagetitle($ID, true);
        $permanentUrl = wl($ID, ['rev' => $revisionId], true);
        $author = $this->getConf('cite_author');
        if ($author == '') {
            $author = 'Anonymous Contributors';
        }
        $publisher = $this->getConf('cite_publisher');
        if ($publisher == '') {
            $publisher = hsc($conf['title']);
        }

        $revisionDateSummary = date('j F Y H:i T', $revisionId);
        $revisionDateYear = date('Y', $revisionId);
        $revisionDateMLA = date('j M Y, H:i T', $revisionId);
        $revisionDateMHRA = date('j F Y, H:i T', $revisionId);
        $revisionDateCBECSE = date('Y M j, H:i T', $revisionId);
        $revisionDateAMA = date('F j, Y, H:i T', $revisionId);

        $retrieveDateSummary = date('j F Y H:i T');
        $retrieveDateAPA = date('H:i, j F, Y');
        $retrieveDateMLA = date('j M Y, H:i');
        $retrieveDateMHRA = date('j F Y');
        $retrieveDateChicago = date('F j, Y');
        $retrieveDateCBECSE = date('Y M j');
        $retrieveDateBluebook = date('F j, Y');
        $retrieveDataAMA = date('F j, Y');
        $retrieveDataBibTeX = date('j-F-Y');


        echo <<< EOT
<h1><a id="bibliographic_details">Bibliographic details for "$pagename"</a></h2>
<div class="level2">

    <ul>
        <li class="level1"><div class="li"> Page name: $pagename</div></li>
        <li class="level1"><div class="li"> Author: $author</div></li>
        <li class="level1"><div class="li"> Publisher: $publisher.</div></li>
        <li class="level1"><div class="li"> Date of this revision: $revisionDateSummary</div></li>
        <li class="level1"><div class="li"> Date retrieved: $retrieveDateSummary</div></li>
        <li class="level1"><div class="li"> Permanent link: <a href="$permanentUrl" title="$permanentUrl">$permanentUrl</a></div></li>
        <li class="level1"><div class="li"> Page Version ID: $revisionId</div></li>
    </ul>

    <p>
     Please remember to check with your standards guide or professor&rsquo;s guidelines for the exact syntax to suit your needs.
    </p>

</div>
<h2><a id="citation_styles_for">Citation styles for "$pagename"</a></h2>
<div class="level2">

</div>

<h3><a id="apa_style">APA style</a></h3>
<div class="level3">

    <p>
    $author ($revisionDateYear). $pagename. $publisher. Retrieved $retrieveDateAPA from <a href="$permanentUrl" title="$permanentUrl">$permanentUrl</a>.
    </p>

</div>
<h3><a id="mla_style">MLA style</a></h3>

<div class="level3">

    <p>
     &ldquo;$pagename.&rdquo; <u>$publisher</u>. $revisionDateMLA. $retrieveDateMLA &lt;<a href="$permanentUrl" title="$permanentUrl">$permanentUrl</a>&gt;.
    </p>

</div>
<h3><a id="mhra_style">MHRA style</a></h3>
<div class="level3">

    <p>
     $author, &lsquo;$pagename&rsquo;, $publisher, $revisionDateMHRA, &lt;<a href="$permanentUrl" title="$permanentUrl">$permanentUrl</a>&gt;
     [accessed $retrieveDateMHRA]
    </p>

</div>
<h3><a id="chicago_style">Chicago style</a></h3>
<div class="level3">

    <p>
     $author, &ldquo;$pagename,&rdquo; $publisher, <a href="$permanentUrl" title="$permanentUrl">$permanentUrl</a>
     (accessed $retrieveDateChicago).
    </p>

</div>
<h3><a id="cbe_cse_style">CBE/CSE style</a></h3>

<div class="level3">

    <p>
     $author. $pagename [Internet]. $publisher; $revisionDateCBECSE [cited $retrieveDateCBECSE].
     Available from: <a href="$permanentUrl" title="$permanentUrl">$permanentUrl</a>.
    </p>

</div>
<h3><a id="bluebook_style">Bluebook style</a></h3>
<div class="level3">

    <p>

     $pagename, <a href="$permanentUrl" title="$permanentUrl">$permanentUrl</a> (last visited $retrieveDateBluebook).
    </p>

</div>
<h3><a id="ama_style">AMA style</a></h3>
<div class="level3">

    <p>
     $author. $pagename. $publisher. $revisionDateAMA. Available at:
     <a href="$permanentUrl" title="$permanentUrl">$permanentUrl</a>. Accessed $retrieveDataAMA.
    </p>

</div>
<h3><a id="bibtex_entry">BibTeX entry</a></h3>
<div class="level3">
<pre>
 @misc{ wiki:xxx,
   author = "$author",
   title = "$pagename --- $publisher",
   year = "$revisionDateYear",
   url = "$permanentUrl",
   note = "[Online; accessed $retrieveDataBibTeX]"
 }
</pre>

    <p>
    When using the LaTeX package url (<code>\usepackage{url}</code> somewhere in the preamble), which tends to give much more nicely
    formatted web addresses, the following may be preferred:
    </p>
<pre>
 @misc{ wiki:xxx,
   author = "$author",
   title = "$pagename --- $publisher",
   year = "$revisionDateYear",
   url = "\url{{$permanentUrl}}",
   note = "[Online; accessed $retrieveDataBibTeX]"
 }
</pre>

</div>
EOT;
    }

    /**
     * Add 'cite' button to page tools, new SVG based mechanism
     *
     * @param Doku_Event $event
     */
    public function addsvgbutton(Doku_Event $event)
    {
        global $INFO;
        if ($event->data['view'] != 'page' || !$this->getConf('showcitebutton')) {
            return;
        }

        if (!$INFO['exists']) {
            return;
        }

        array_splice($event->data['items'], -1, 0, [new \dokuwiki\plugin\cite\MenuItem()]);
    }
}
