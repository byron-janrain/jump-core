<?php
namespace janrain\jump;

/**
 * The interface expected by the jump platform for objects that wish to have their data mapped
 */
interface Mappable extends \ArrayAccess
{
	public function getMappableFields();
}
