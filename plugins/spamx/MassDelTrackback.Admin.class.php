<?php

/**
* file:  MassDelTrackback.Admin.class.php
*
* Mass delete trackback spam
*
* Copyright (C) 2004-2006 by the following authors:
*
* @author   Tom Willett     tomw AT pigstye DOT net
* @author   Dirk Haun       dirk AT haun-online DOT de
*
* Licensed under GNU General Public License
*
* $Id: MassDelTrackback.Admin.class.php,v 1.2 2006/01/15 09:40:02 dhaun Exp $
*/

require_once ($_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php');


class MassDelTrackback extends BaseAdmin {

    function display()
    {
        global $_CONF, $_TABLES, $LANG_SX00;

        $display = $LANG_SX00['masstb'];

        $act = $_POST['action'];
        $lmt = $_POST['limit'];

        if (($act == $LANG_SX00['deletespam']) && ($lmt > 0)) {
            $numc = 0;
            if ($dir = @opendir ($_CONF['path'] . 'plugins/spamx/')) {
                while (($file = readdir ($dir)) !== false) {
                    if (is_file ($_CONF['path'] . 'plugins/spamx/' . $file))
                    {
                        if (substr ($file, -18) == '.Examine.class.php') {
                            $tmp = str_replace ('.Examine.class.php', '', $file);
                            $Spamx_Examine[] = $tmp;
                        }
                    }
                }
                closedir ($dir);
            }

            require_once ($_CONF['path_system'] . 'lib-trackback.php');

            $result = DB_query ("SELECT cid,sid,type,url,title,blog,excerpt FROM {$_TABLES['trackback']} ORDER BY date DESC LIMIT $lmt");
            $nrows = DB_numRows ($result);
            for ($i = 0; $i < $nrows; $i++) {
                $A = DB_fetchArray ($result);
                $comment = TRB_formatComment ($A['url'], $A['title'],
                                              $A['blog'], $A['excerpt']);

                foreach ($Spamx_Examine as $Examine) {
                    $filename = $Examine . '.Examine.class.php';
                    if (file_exists ($_CONF['path'] . 'plugins/spamx/' . $filename)) {
                        require_once ($_CONF['path'] . 'plugins/spamx/' . $filename);
                        $EX = new $Examine;
                        $res = $EX->execute ($comment);
                        if ($res == 1) {
                            break;
                        }
                    }
                }
                if ($res == 1) {
                    $this->deltrackback ($A['cid'], $A['sid'], $A['type']);
                    $numc = $numc + 1;
                }
            }
            $display .= $numc . $LANG_SX00['comdel'];
        } else {
            $display .= '<form method="post" action="' . $_CONF['site_admin_url'] . '/plugins/spamx/index.php?command=MassDelTrackback">';
            $display .= $LANG_SX00['numtocheck'] . '&nbsp;&nbsp&nbsp' . ' <select name="limit">';
            $display .= '<option value="10">10</option>'
                     .  '<option value="50">50</option>'
                     .  '<option value="100" selected="selected">100</option>'
                     .  '<option value="200">200</option>'
                     .  '<option value="300">300</option>'
                     .  '<option value="400">400</option>';
            $display .= '</select>';
            $display .= $LANG_SX00['note1'];
            $display .= $LANG_SX00['note2'];
            $display .= $LANG_SX00['note3'];
            $display .= $LANG_SX00['note4'];
            $display .= $LANG_SX00['note5'];
            $display .= $LANG_SX00['note6'];
            $display .= '<input type="submit" name="action" value="' . $LANG_SX00['deletespam'] . '">';
            $display .= '</form>';
        }

        return $display;
    }

    function link()
    {
        global $LANG_SX00;

        return 'Mass Delete Trackback Spam';
    }

    /**
    * Deletes a given trackback comment
    *
    * @param    int         $cid    Comment ID
    * @param    string      $sid    ID of object comment belongs to
    * @param    string      $type   Comment type (e.g. article, poll, etc)
    * @return   void
    *
    */
    function deltrackback ($cid, $sid, $type)
    {
        global $_TABLES, $LANG_SX00;

        if (TRB_allowDelete ($sid, $type)) {
            TRB_deleteTrackbackComment ($cid);

            if ($type == 'article') {
                $tbcount = DB_count ($_TABLES['trackback'],
                                     array ('type', 'sid'),
                                     array ('article', $sid));
                DB_query ("UPDATE {$_TABLES['stories']} SET trackbacks = $tbcount WHERE sid = '$sid'");
            }

            SPAMX_log ($LANG_SX00['spamdeleted']);
        }
    }
}

?>
