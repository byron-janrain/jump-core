<?php
namespace janrain\plex;

interface Config extends \IteratorAggregate
{
    public function getItem($key);

    public function setItem($key, $value);

    public function toJson();
}
