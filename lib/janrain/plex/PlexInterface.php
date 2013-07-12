<?php
namespace janrain\plex;

interface PlexInterface
{
	/**
	 * @return PlexUser|null
	 *   The PlexUser who is currently logged in or null if there is no logged in user
	 */
	public function getLoggedInUser();

	/**
	 * @return PlexUser|null
	 *   Lookup a PlexUser by Janrain UUID
	 */
	public function getUserByUuid($uuid);

	public function loginUser(\janrain\jump\User $u);

	public function logoutUser(\janrain\jump\User $u);

	public function registerUser(\janrain\jump\User $u);

	public function getConfig();

	public function getLocale();
}

interface PlexUser
{
	public function getIsLoggedIn();
	public function getProperty($propertyName);
	public function setProperty($propertyName, $newValue);
	public function login();
	public function logout();
}
