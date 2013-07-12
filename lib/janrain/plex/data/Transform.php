<?php
namespace janrain\plex\data;

use janrain\plex\User as pUser;
use janrain\jump\User as jUser;

jump >> plex
jump << plex

array_map()


class Map
{

}

class Mapper
{

	public function __invoke(januser, plexuser)
	{
		getset;
	}
}

$mapping = <<<end
[
	{
		"op":">>",
		"fields": ["sourceField","destField"]
	},

	{"capture.sourceField":"plex.destField"}
]
end;

function map(pUser $item1, jUser $item2, Transform $transform)
{
	foreach ($map as $entry) {

	}
}

{"opname":{"field":"field"}},...]

interface MapOpVisitor
{
	public function __invoke(janrainuser, plexuser);
}

class MapOpSetPlex
{
	public function __invoke(janrainuser, plexuser)
	{
		plexuser->setValue('valuename', $janrainuser->getValue())
	}
}

interface MapOpSet
{
	public function accept(MapOpVisitor $v) {
		$v->visit($this);
	}
}

class Mapper
{
	public static function map(Mappable $jumpUser, Mappable $plexUser, Transform $t)
	{
		foreach ($t as $op)
		{
			switch ($op->op) {
			case '<<':
				$jumpUser[$op->fields[0]] = $plexUser[$op->fields[1]];
				break;
			case '>>':
				$plexUser[$op->fields[1]] = $jumpUser[$op->fields[0]];
				break;
			default:
				#noop
			}
		}
	}
}

class Transform implements \IteratorAggregate
{
	public function __construct($transformSource)
	{
		if ($transformSource instanceof \SPLFileObject) {
			#
		}
	}

}
