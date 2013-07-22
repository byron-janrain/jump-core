<?php
namespace janrain\plex;

use \janrain\jump\User as Jumper;

interface User extends \janrain\jump\Mappable
{

    public function loginAs(Jumper $j);
    public function registerAs(Jumper $j);
    public function isLoggedIn();
    public function getMappableFields();
}
