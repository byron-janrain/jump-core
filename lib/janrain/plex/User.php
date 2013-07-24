<?php
namespace janrain\plex;

use janrain\jump\User as Jumper;
use janrain\plex\data\Transformable;

interface User extends Transformable
{
    public function loginAs(Jumper $j);
    public function registerAs(Jumper $j);
    public function isLoggedIn();
    public function getMappableFields();
}
