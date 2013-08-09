<?php
namespace janrain\plex;

/**
 * The contract for interacting with Platform configuration data.
 *
 * In general, each platform has it's own mechanism for storing and retrieving
 */
interface Config extends \IteratorAggregate
{
    /**
     * Get a configuration item by key name.
     *
     * @param string $key The Core name of the config item.
     *   Handles config namespace resoultion.
     *
     * @return mixed The value of the config item or null if the key doesn't exist.
     *   Should return null if key doesn't exist or is unset.
     *   Should convert platform "boolean strings" such as "true","false",1 to PHP booleans according to
     *   platform conventions.
     */
    public function getItem($key);

    /**
     * Set platform configuration data.
     *
     * @param string $key The Core name of the config item.
     *   Handles config namespace resolution.
     *
     * @param mixed $value The value to be stored.
     *   Should handle platform conversion of boolean strings.
     */
    public function setItem($key, $value);

    /**
     * Export all JUMP options in json format.
     *
     * @return string All config serialized to json.
     */
    public function toJson();
}
