<?php
namespace janrain\plex\data;

use janrain\plex\User as Plexer;
use janrain\jump\User as Jumper;


class Transform {

    protected $xforms;

    protected function __construct()
    {
        $this->xforms = array();
    }

    public static function loadFromJson($json)
    {
        $out = new Transform();
        $decoded = json_decode($json);
        foreach ($decoded as &$xform) {
            $rc = new \ReflectionClass("\\janrain\\plex\\data\\{$xform->op}");
            $xform = $rc->newInstanceArgs($xform->j, $xform->p);
            $out->xforms[] = $xform;
        }
        return $out;
    }

    public function map(Jumper $j, Plexer $p)
    {
        foreach ($this->xforms as $map) {
            $map($j, $p);
        }
    }
}
