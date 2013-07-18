<?php
namespace janrain\plex\data;

use janrain\plex\User as Plexer;
use janrain\jump\User as Jumper;


class Transform {

	protected $xforms;

	public function __construct(Array $defaults = null) {
		$this->xforms = $defaults ?: array();
	}

	public function loadMappingFromJson($json)
	{
		$decoded = json_decode($json);
		foreach ($decoded as &$xform) {
			$rc = new ReflectionClass("\\janrain\\plex\\data\\{$xform->name}");
			$xform = $rc->newInstanceArgs($xform->args);
			$this->xforms[] = $xform;
		}
	}

	public function map(Jumper $j, Plexer $p) {
		foreach ($this->xforms as $map) {
			$map($j, $p);
		}
	}
}
