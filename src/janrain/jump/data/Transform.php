<?php
namespace janrain\jump\data;

class Transform {

    protected $xforms;

    public function __construct()
    {
        $this->xforms = array();
    }

    public function addOp(TransformOp $op)
    {
        $this->xforms[] = $op;
    }

    public function getOps()
    {
        return new \ArrayIterator($this->xforms);
    }

    public static function loadFromJson($json)
    {
        $out = new Transform();
        $decoded = json_decode($json);
        foreach ($decoded as &$xform) {
            try {
                $rc = new \ReflectionClass("\\janrain\\jump\\data\\{$xform->op}");
            } catch (\ReflectionException $e) {
                throw new \InvalidArgumentException("Mapping operation {$xform->op} does not exist!", $e->getCode(), $e);
            }
            $xform = $rc->newInstance($xform->j, $xform->p);
            $out->xforms[] = $xform;
        }
        return $out;
    }

    public function map(Transformable $src, Transformable $tgt)
    {
        foreach ($this->xforms as $map) {
            $map($src, $tgt);
        }
    }
}
