<?php
namespace janrain\jump\data;

interface Transformable extends \ArrayAccess
{
    /**
    * Get a list of mappable fields (such as to populate a dropdown ui)
    *
    * @return Array
    *   An array of field names.
    */
    public function getMappableFields();
}
