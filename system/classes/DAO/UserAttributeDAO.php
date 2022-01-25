<?php

namespace Geeklog\DAO;

use Geeklog\Entity\UserAttributeEntity;

class UserAttributeDAO
{
    /**
     * @var string
     */
    private $table;

    /**
     * UserAttributeDAO constructor
     *
     * @param  string  $tableName
     */
    public function __construct($tableName)
    {
        $this->table = $tableName;
    }

    /**
     * Return a UserAttribute object representing the user
     *
     * @param  int  $uid
     * @return UserAttributeEntity
     */
    public function getByUserId($uid)
    {
        $uid = (int) $uid;
        if ($uid < 1) {
            $uid = 1;
        }

        $result = DB_query("SELECT * FROM $this->table WHERE (uid = $uid) ");
        if (!DB_error()) {
            $row = DB_fetchArray($result, false);

            if (!empty($row)) {
                return UserAttributeEntity::fromArray($row);
            }
        }

        return new UserAttributeEntity();
    }

    /**
     * Delete an existing user
     *
     * @param  int  $uid
     * @return bool
     */
    public function deleteByUserId($uid)
    {
        $uid = (int) $uid;
        if ($uid <= 1) {
            return false;
        }

        return DB_query("DELETE FROM $this->table WHERE (uid = $uid)");
    }

    /**
     * Create a new record in $_TABLES['user_attributes']
     *
     * @param  UserAttributeEntity  $entity
     * @return bool
     */
    public function create(UserAttributeEntity $entity)
    {
        $sql = <<<SQL
INSERT INTO $this->table (uid, commentmode, commentorder, commentlimit, etids, noboxes, maxstories, 
  about, location, pgpkey, tokens, totalcomments, lastgranted, lastlogin, dfid, 
  advanced_editor, tzid, emailfromadmin, emailfromuser, showonline) 
  VALUES (:uid, ':commentmode', ':commentorder', :commentlimit, ':etids', :noboxes, :maxstories, 
  ':about', ':location', ':pgpkey', :tokens, :totalcomments, :lastgranted, ':lastlogin', :dfid,
  :advanced_editor, ':tzid', :emailfromadmin, :emailfromuser, :showonline)
SQL;
        foreach ($entity->toArray() as $key => $value) {
            $sql = str_replace(':' . $key, $value, $sql);
        }

        return DB_query($sql);
    }

    /**
     * Update the record in $_TABLES['user_attributes']
     *
     * @param  UserAttributeEntity  $entity
     * @return bool
     */
    public function update(UserAttributeEntity $entity)
    {
        $sql=<<<SQL
UPDATE $this->table SET commentmode = ':commentmode', commentorder = ':commentorder', 
  commentlimit = :commentlimit, etids = ':etids', noboxes = :noboxes, maxstories = :maxstories,
  about = ':about', location = ':location', pgpkey = ':pgpkey', tokens = :tokens, totalcomments = :totalcomments,
  lastgranted = :lastgranted, lastlogin = ':lastlogin', dfid = :dfid, advanced_editor = :advanced_editor, 
  tzid = ':tzid', emailfromadmin = :emailfromadmin, emailfromuser = :emailfromuser, showonline = :showonline
  WHERE (uid = :uid)
SQL;

        foreach ($entity->toArray() as $key => $value) {
            $sql = str_replace(':' . $key, $value, $sql);
        }

        return DB_query($sql);
    }
}
