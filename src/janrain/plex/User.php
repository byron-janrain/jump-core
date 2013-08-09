<?php
namespace janrain\plex;

use janrain\jump\data\Transformable;

/**
 * The Platform User.  This interface is what the platform user (or adapter) implements to
 * let Jump do it's work.  Generally hooks that are user specific will go here.  For example,
 * currently it extends Transformable, to enable mapping, as well as requiring a handful of
 * login-registration state getters and session access.
 */
interface User extends Transformable
{
    /**
     * Is this Plex User already logged in?  Used mainly for account mapping.
     * Since mapping should only be attempted for logged-in users.
     *
     * @return bool
     *   Returns true if the plex user is logged in, false if otherwise.
     */
    public function getIsLoggedIn();

    /**
     * Is this a new plex user? You may have a new user that hasn't been saved
     * to the db yet.  Here's how we can check.
     *
     * @return bool
     *   Returns true if this user is not created locally yet, false otherwise.
     */
    public function getIsNew();

    /**
    * Store session data for this user.  Things like tokens or expirations for
    * session sync.
    *
    * @param string
    *   The key for this session data item
    *
    * @param mixed
    *   The value to be set.  This must be serializable to persist in the session
    */
    public function setSessionItem($key, $value);

    /**
     * Retreive session data by key.
     *
     * @param string *required* The key name of the session data item.
     *
     * @param mixed
     *   _optional_ A default value to return if the key data is empty.
     *
     * @return mixed|null
     *   The value stored in the session for that key. If the key doesn't exist,
     *   this should return null or the specified default value. Be sure to check
     *   for null in the return as falsey values are legit (empty strings, boolean false, empty array).
     */
    public function getSessionItem($key, $default = null);
}
