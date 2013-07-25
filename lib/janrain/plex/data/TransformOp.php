<?php
namespace janrain\plex\data;

use janrain\jump\User as Jumper;
use janrain\plex\User as Plexer;

abstract class TransformOp
{
    protected $srcName;
    protected $destName;

    public function __construct($srcFieldName, $destFieldName)
    {
        $this->srcName = trim($srcFieldName);
        $this->destName = trim($destFieldName);
    }

    abstract public function __invoke(Jumper $j, Plexer $p);

    public function __toString()
    {
        $cNames = explode('\\', get_class($this));
        $className = array_pop($cNames);
        $src = json_encode($this->srcName);
        $dest = json_encode($this->destName);
        return sprintf('{"op":"%s","j":%s,"p":%s}', $className, $src, $dest);
    }
}
