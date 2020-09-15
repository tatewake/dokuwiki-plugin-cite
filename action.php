<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Terence J. Grant <tjgrant@tatewake.com>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) {
    die();
}

if (!defined('DOKU_PLUGIN')) {
    define('DOKU_PLUGIN', DOKU_INC.'lib/plugins/');
}
require_once(DOKU_PLUGIN.'action.php');
include_once(DOKU_PLUGIN.'cite/code.php');

class action_plugin_cite extends DokuWiki_Action_Plugin
{
    /**
     * register the eventhandlers
     */
    public function register(Doku_Event_Handler $contr)
    {
        $contr->register_hook('ACTION_ACT_PREPROCESS', 'BEFORE', $this, '_handle_act', array());
        $contr->register_hook('TPL_ACT_UNKNOWN', 'BEFORE', $this, '_handle_tpl_act', array());
    }

    public function _handle_act(&$event, $param)
    {
        if ($event->data != 'cite') {
            return;
        }
        $event->preventDefault();
    }

    public function _handle_tpl_act(&$event, $param)
    {
        if ($event->data != 'cite') {
            return;
        }
        $event->preventDefault();

        global $INFO, $conf, $ID;

        $cite_perm = cite_getPermURL();
        $cite_author = $this->getConf('cite_author');
        $cite_publisher = $this->getConf('cite_publisher');

        if ($cite_author == '') {
            $cite_author = 'Anonymous Contributors';
        }
        if ($cite_publisher == '') {
            $cite_publisher = hsc($conf['title']);
        } ?>
<h1><a name="bibliographic_details" id="bibliographic_details">Bibliographic details for &quot;<?php tpl_pagetitle()?>&quot;</a></h2>
<div class="level2">

<ul>
<li class="level1"><div class="li"> Page name: <?php tpl_pagetitle()?></div>
</li>
<li class="level1"><div class="li"> Author: <?php echo $cite_author; ?></div>
</li>
<li class="level1"><div class="li"> Publisher: <?php echo $cite_publisher?>.</div>
</li>
<li class="level1"><div class="li"> Date of this revision: <?php echo date('j F Y H:i T', $_REQUEST['rev']); ?></div>
</li>
<li class="level1"><div class="li"> Date retrieved: <?php echo date('j F Y H:i T'); ?></div>
</li>
<li class="level1"><div class="li"> Permanent link: <a href="<?php echo $cite_perm; ?>" title="<?php echo $cite_perm; ?>"><?php echo $cite_perm; ?></a></div>
</li>
<li class="level1"><div class="li"> Page Version ID: <?php echo $_REQUEST['rev']; ?> </div>

</li>
</ul>

<p>
 Please remember to check with your standards guide or professor&rsquo;s guidelines for the exact syntax to suit your needs.
</p>

</div>
<h2><a name="citation_styles_for" id="citation_styles_for">Citation styles for &quot;<?php tpl_pagetitle()?>&quot;</a></h2>
<div class="level2">

</div>

<h3><a name="apa_style" id="apa_style">APA style</a></h3>
<div class="level3">

<p>
 <?php echo $cite_author; ?> (<?php echo date('Y', $_REQUEST['rev']); ?>). <?php tpl_pagetitle()?>. <?php echo $cite_publisher?>. Retrieved <?php echo date('H:i, j F, Y'); ?> from <a href="<?php echo $cite_perm; ?>" title="<?php echo $cite_perm; ?>"><?php echo $cite_perm; ?></a>.
</p>

</div>
<h3><a name="mla_style" id="mla_style">MLA style</a></h3>

<div class="level3">

<p>
 &ldquo;<?php tpl_pagetitle()?>.&rdquo; <u><?php echo $cite_publisher?></u>. <?php echo date('j M Y, H:i T', $_REQUEST['rev']); ?>. <?php echo date('j M Y, H:i'); ?> &lt;<a href="<?php echo $cite_perm; ?>" title="<?php echo $cite_perm; ?>"><?php echo $cite_perm; ?></a>&gt;.
</p>

</div>
<h3><a name="mhra_style" id="mhra_style">MHRA style</a></h3>
<div class="level3">

<p>
 <?php echo $cite_author; ?>, &lsquo;<?php tpl_pagetitle()?>&rsquo;, <?php echo $cite_publisher?>, <?php echo date('j F Y, H:i T', $_REQUEST['rev']); ?>, &lt;<a href="<?php echo $cite_perm; ?>" title="<?php echo $cite_perm; ?>"><?php echo $cite_perm; ?></a>&gt; [accessed <?php echo date('j F Y'); ?>]
</p>

</div>
<h3><a name="chicago_style" id="chicago_style">Chicago style</a></h3>
<div class="level3">

<p>
 <?php echo $cite_author; ?>, &ldquo;<?php tpl_pagetitle()?>,&rdquo; <?php echo $cite_publisher?>, <a href="<?php echo $cite_perm; ?>" title="<?php echo $cite_perm; ?>"><?php echo $cite_perm; ?></a> (accessed <?php echo date('F j, Y'); ?>).
</p>

</div>
<h3><a name="cbe_cse_style" id="cbe_cse_style">CBE/CSE style</a></h3>

<div class="level3">

<p>
 <?php echo $cite_author; ?>. <?php tpl_pagetitle()?> [Internet]. <?php echo $cite_publisher?>; <?php echo date('Y M j, H:i T', $_REQUEST['rev']); ?> [cited <?php echo date('Y M j'); ?>]. Available from: <a href="<?php echo $cite_perm; ?>" title="<?php echo $cite_perm; ?>"><?php echo $cite_perm; ?></a>.
</p>

</div>
<h3><a name="bluebook_style" id="bluebook_style">Bluebook style</a></h3>
<div class="level3">

<p>

 <?php tpl_pagetitle()?>, <a href="<?php echo $cite_perm; ?>" title="<?php echo $cite_perm; ?>"><?php echo $cite_perm; ?></a> (last visited <?php echo date('F j, Y'); ?>).
</p>

</div>
<h3><a name="ama_style" id="ama_style">AMA style</a></h3>
<div class="level3">

<p>
 <?php echo $cite_author; ?>. <?php tpl_pagetitle()?>. <?php echo $cite_publisher?>. <?php echo date('F j, Y, H:i T', $_REQUEST['rev']); ?>. Available at: <a href="<?php echo $cite_perm; ?>" title="<?php echo $cite_perm; ?>"><?php echo $cite_perm; ?></a>. Accessed <?php echo date('F j, Y'); ?>.

</p>

</div>
<h3><a name="bibtex_entry" id="bibtex_entry">BibTeX entry</a></h3>
<div class="level3">
<pre>
 @misc{ wiki:xxx,
   author = &quot;<?php echo $cite_author; ?>&quot;,
   title = &quot;<?php tpl_pagetitle()?> --- <?php echo $cite_publisher?>&quot;,
   year = &quot;<?php echo date('Y', $_REQUEST['rev']); ?>&quot;,
   url = &quot;<?php echo $cite_perm; ?>&quot;,
   note = &quot;[Online; accessed <?php echo date('j-F-Y'); ?>]&quot;
 }
</pre>

<p>
When using the LaTeX package url (\usepackage{url} somewhere in the preamble), which tends to give much more nicely formatted web addresses, the following may be preferred:
</p>
<pre>
 @misc{ wiki:xxx,
   author = &quot;<?php echo $cite_author; ?>&quot;,
   title = &quot;<?php tpl_pagetitle()?> --- <?php echo $cite_publisher?>&quot;,
   year = &quot;<?php echo date('Y', $_REQUEST['rev']); ?>&quot;,
   url = &quot;\url{<?php echo $cite_perm; ?>}&quot;,
   note = &quot;[Online; accessed <?php echo date('j-F-Y'); ?>]&quot;
 }
</pre>

</div>
<?php
    }
}
