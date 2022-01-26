<?php

namespace Geeklog\Entity;

/**
 * Entity for $_TABLES['user_attributes']
 */
class UserAttributeEntity extends EntityBase
{
    // Columns from $_TABLES['usercomment']
    /**
     * @var int
     */
    private $uid = 1;

    /**
     * @var string
     */
    private $commentmode = 'nested';

    /**
     * @var string
     */
    private $commentorder = 'ASC';

    /**
     * @var int
     */
    private $commentlimit = 100;

    // Columns from $_TABLES['userindex']
    /**
     * @var string
     */
    private $etids = '';    // Originally null

    /**
     * @var int
     */
    private $noboxes = 0;

    /**
     * @var int
     */
    private $maxstories = 0;   // Originally null

    // Columns from $_TABLES['userinfo']

    /**
     * @var string
     */
    private $about = '';    // Originally null

    /**
     * @var string
     */
    private $location = '';

    /**
     * @var string
     */
    private $pgpkey = '';   // Originally null

    /**
     * @var int
     */
    private $tokens = 0;

    /**
     * @var int
     */
    private $lastgranted = 0;

    /**
     * @var string
     */
    private $lastlogin = '0';

    // Columns from $_TABLES['userprefs']
    /**
     * @var int
     */
    private $dfid = 0;

    /**
     * @var int
     */
    private $advanced_editor = 1;

    /**
     * @var string
     */
    private $tzid = '';

    /**
     * @var int
     */
    private $emailfromadmin = 1;

    /**
     * @var int
     */
    private $emailfromuser = 1;

    /**
     * @var int
     */
    private $showonline = 1;

    /**
     * @return int
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param  int  $uid
     */
    public function setUid($uid)
    {
        $this->uid = (int) $uid;
    }

    /**
     * @return string
     */
    public function getCommentmode()
    {
        return $this->commentmode;
    }

    /**
     * @param  string  $commentmode
     */
    public function setCommentmode($commentmode)
    {
        $this->commentmode = $commentmode;
    }

    /**
     * @return string
     */
    public function getCommentorder()
    {
        return $this->commentorder;
    }

    /**
     * @param  string  $commentorder
     */
    public function setCommentorder($commentorder)
    {
        $this->commentorder = $commentorder;
    }

    /**
     * @return int
     */
    public function getCommentlimit()
    {
        return $this->commentlimit;
    }

    /**
     * @param  int  $commentlimit
     */
    public function setCommentlimit($commentlimit)
    {
        $this->commentlimit = (int) $commentlimit;
    }

    /**
     * @return string
     */
    public function getEtids()
    {
        return $this->etids;
    }

    /**
     * @param  string|null  $etids
     */
    public function setEtids($etids)
    {
        $this->etids = ($etids === null) ? '' : $etids;
    }

    /**
     * @return int
     */
    public function getNoboxes()
    {
        return $this->noboxes;
    }

    /**
     * @param  int  $noboxes
     */
    public function setNoboxes($noboxes)
    {
        $this->noboxes = $noboxes;
    }

    /**
     * @return int
     */
    public function getMaxstories()
    {
        return $this->maxstories;
    }

    /**
     * @param  int|null  $maxstories
     */
    public function setMaxstories($maxstories)
    {
        $this->maxstories = ($maxstories === null) ? 0 : (int) $maxstories;
    }

    /**
     * @return string
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * @param  string|null  $about
     */
    public function setAbout($about)
    {
        $this->about = ($about === null) ? '' : $about;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param  string  $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getPgpkey()
    {
        return $this->pgpkey;
    }

    /**
     * @param  string  $pgpkey
     */
    public function setPgpkey($pgpkey)
    {
        $this->pgpkey = ($pgpkey === null) ? '' : $pgpkey;
    }

    /**
     * @return int
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * @param  int  $tokens
     */
    public function setTokens($tokens)
    {
        $this->tokens = $tokens;
    }

    /**
     * @return int
     */
    public function getLastgranted()
    {
        return $this->lastgranted;
    }

    /**
     * @param  int  $lastgranted
     */
    public function setLastgranted($lastgranted)
    {
        $this->lastgranted = (int) $lastgranted;
    }

    /**
     * @return string
     */
    public function getLastlogin()
    {
        return $this->lastlogin;
    }

    /**
     * @param  string  $lastlogin
     */
    public function setLastlogin($lastlogin)
    {
        $this->lastlogin = $lastlogin;
    }

    /**
     * @return int
     */
    public function getDfid()
    {
        return $this->dfid;
    }

    /**
     * @param  int  $dfid
     */
    public function setDfid($dfid)
    {
        $this->dfid = $dfid;
    }

    /**
     * @return int
     */
    public function getAdvancedEditor()
    {
        return $this->advanced_editor;
    }

    /**
     * @param  int  $advanced_editor
     */
    public function setAdvancedEditor($advanced_editor)
    {
        $this->advanced_editor = $advanced_editor;
    }

    /**
     * @return string
     */
    public function getTzid()
    {
        return $this->tzid;
    }

    /**
     * @param  string  $tzid
     */
    public function setTzid($tzid)
    {
        $this->tzid = $tzid;
    }

    /**
     * @return int
     */
    public function getEmailfromadmin()
    {
        return $this->emailfromadmin;
    }

    /**
     * @param  int  $emailfromadmin
     */
    public function setEmailfromadmin($emailfromadmin)
    {
        $this->emailfromadmin = $emailfromadmin;
    }

    /**
     * @return int
     */
    public function getEmailfromuser()
    {
        return $this->emailfromuser;
    }

    /**
     * @param  int  $emailfromuser
     */
    public function setEmailfromuser($emailfromuser)
    {
        $this->emailfromuser = $emailfromuser;
    }

    /**
     * @return int
     */
    public function getShowonline()
    {
        return $this->showonline;
    }

    /**
     * @param  int  $showonline
     */
    public function setShowonline($showonline)
    {
        $this->showonline = $showonline;
    }

    /**
     * UserAttribute constructor
     */
    public function __construct()
    {
        $this->setUid(1);
        $this->setCommentmode('nested');
        $this->setCommentorder('ASC');
        $this->setCommentlimit(100);

        $this->setEtids('');
        $this->setNoboxes(0);
        $this->setMaxstories(0);

        $this->setAbout('');
        $this->setLocation('');
        $this->setPgpkey('');
        $this->setTokens(0);
        $this->setLastgranted(0);
        $this->setLastlogin('0');

        $this->setDfid(0);
        $this->setAdvancedEditor(1);
        $this->setTzid('');
        $this->setEmailfromadmin(1);
        $this->setEmailfromuser(1);
        $this->setShowonline(1);
    }

    /**
     * Make the entity into an array
     *
     * @param $forDatabase
     * @return array
     */
    public function toArray($forDatabase = true)
    {
        if ($forDatabase) {
            return [
                'uid'             => $this->getUid(),
                'commentmode'     => self::escapeForDatabase(self::addSlashes($this->getCommentmode())),
                'commentorder'    => self::escapeForDatabase(self::addSlashes($this->getCommentorder())),
                'commentlimit'    => $this->getCommentlimit(),
                'etids'           => self::escapeForDatabase(self::addSlashes($this->getEtids())),
                'noboxes'         => $this->getNoboxes(),
                'maxstories'      => $this->getMaxstories(),
                'about'           => self::escapeForDatabase(self::addSlashes($this->getAbout())),
                'location'        => self::escapeForDatabase(self::addSlashes($this->getLocation())),
                'pgpkey'          => self::escapeForDatabase(self::addSlashes($this->getPgpkey())),
                'tokens'          => $this->getTokens(),
                'lastgranted'     => $this->getLastgranted(),
                'lastlogin'       => self::escapeForDatabase(self::addSlashes($this->getLastlogin())),
                'dfid'            => $this->getDfid(),
                'advanced_editor' => $this->getAdvancedEditor(),
                'tzid'            => self::escapeForDatabase(self::addSlashes($this->getTzid())),
                'emailfromadmin'  => $this->getEmailfromadmin(),
                'emailfromuser'   => $this->getEmailfromuser(),
                'showonline'      => $this->getShowonline(),
            ];
        } else {
            return [
                'uid'             => $this->getUid(),
                'commentmode'     => $this->getCommentmode(),
                'commentorder'    => $this->getCommentorder(),
                'commentlimit'    => $this->getCommentlimit(),
                'etids'           => $this->getEtids(),
                'noboxes'         => $this->getNoboxes(),
                'maxstories'      => $this->getMaxstories(),
                'about'           => $this->getAbout(),
                'location'        => $this->getLocation(),
                'pgpkey'          => $this->getPgpkey(),
                'tokens'          => $this->getTokens(),
                'lastgranted'     => $this->getLastgranted(),
                'lastlogin'       => $this->getLastlogin(),
                'dfid'            => $this->getDfid(),
                'advanced_editor' => $this->getAdvancedEditor(),
                'tzid'            => $this->getTzid(),
                'emailfromadmin'  => $this->getEmailfromadmin(),
                'emailfromuser'   => $this->getEmailfromuser(),
                'showonline'      => $this->getShowonline(),
            ];
        }
    }

    /**
     * Create an UserAttributeEntity object from an array
     *
     * @param  array  $A
     * @param  bool   $fromDatabase
     * @return UserAttributeEntity
     */
    public static function fromArray(array $A, $fromDatabase = true)
    {
        $entity = new self();

        if ($fromDatabase) {
            foreach ($A as &$value) {
                $value = self::stripSlashes($value);
            }
            unset($value);
        }

        $entity->setUid($A['uid']);
        $entity->setCommentmode($A['commentmode']);
        $entity->setCommentorder($A['commentorder']);
        $entity->setCommentlimit($A['commentlimit']);

        $entity->setEtids($A['etids']);
        $entity->setNoboxes($A['noboxes']);
        $entity->setMaxstories($A['maxstories']);

        $entity->setAbout($A['about']);
        $entity->setLocation($A['location']);
        $entity->setPgpkey($A['pgpkey']);
        $entity->setTokens($A['tokens']);
        $entity->setLastgranted($A['lastgranted']);
        $entity->setLastlogin($A['lastlogin']);

        $entity->setDfid($A['dfid']);
        $entity->setAdvancedEditor($A['advanced_editor']);
        $entity->setTzid($A['tzid']);
        $entity->setEmailfromadmin($A['emailfromadmin']);
        $entity->setEmailfromuser($A['emailfromuser']);
        $entity->setShowonline($A['showonline']);

        return $entity;
    }
}
