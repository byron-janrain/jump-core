<?php
namespace janrain\jump\data;

interface Transformable
{
    /**
    * Get a list of mappable fields (such as to populate a dropdown ui)
    *
    * @return Array
    *   An array of field names.
    */
    #public function getMappableFields();

    public function setAttribute($key, $value);

    public function getAttribute($key);

    public function hasAttribute($key);

    public function getAttributePaths();
}
