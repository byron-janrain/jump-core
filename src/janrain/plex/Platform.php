<?php
namespace janrain\plex;

use janrain\jump\User as Jumper;
use janrain\plex\User as Plexer;

/**
 * The interface to all Platform functionality that JUMP Core needs.
 *
 * This interface should grow as core needs access to deeper parts of the platforms, but ultimately
 * should always be the ONLY interface to the platform that JUMP needs.
 */
interface Platform
{
    /**
     * Get or load the plex User linked to this Janrain User
     *
     * @param janrain\jump\User $j The JUMP user to find locally.
     */
    public function fetchPlexUser(Jumper $j);

    /**
     * Log this plex user in.
     *
     * @param janrain\plex\User $p The Platform user to be logged in
     */
    public function loginPlexUser(Plexer $p);

    /**
     * Convenience method taking a JUMP user and registering them.
     *
     * @param janrain\jump\User $j The JUMP User to register
     *
     * @return janran\plex\User The Platform User connected to the given JUMP user.
     */
    public function registerJumpUser(Jumper $j);

    /**
     * Get the platform's configuration.
     *
     * @return janrain\plex\Config The configuration object for this platform.
     */
    public function getConfig();
}
