<?php
namespace janrain\jump;

/**
 * The fundamental unit of data for Janrain.  The user.
 */
class User implements Mappable
{
    /**
     * @inherit
     */
    public function offsetSet($offset, $value)
    {
        if (!$this->offsetExists($offset)) {
            throw new \InvalidArgumentException('Offset does not exist!');
        }
        if (0 === strpos($offset, '/')) {
            $tokens = array_reverse(preg_split('/[\/\#]/', $offset, -1, PREG_SPLIT_NO_EMPTY));
            $firstToken = array_pop($tokens);
            if (!isset($this->$firstToken)) {
                #sanity check, immediatly fail if the root attribute doesn't exist.
                return;
            }
            $this->attributePathSet($value, $this->$firstToken, $tokens);
        } else {
            $this->$offset = $value;
        }
    }

    private function attributePathSet($newValue, &$next, &$tokens)
    {
        $tok = array_pop($tokens);
        if (is_numeric($tok)) {
            $tok = intval($tok) - 1;
        }
        if (count($tokens) == 0) {
            $next[$tok] = $newValue;
        } else {
            $this->attributePathSet($newValue, $next[$tok], $tokens);
        }
    }

    public function offsetGet($offset)
    {
        #check for capture attribute path
        if (0 === strpos($offset, '/')) {
            #attribute path found, crawl it!
            return $this->attributePathGet($offset);
        }
        #no attribute path, just return the value
        return isset($this->$offset) ? $this->$offset : null;
    }
    public function offsetExists($offset)
    {
        if (0 === strpos($offset, '/')) {
            return !is_null($this->attributePathGet($offset));
        }
        return isset($this->$offset);
    }
    public function offsetUnset($offset)
    {
        #cannot unset janrain schema structure
    }

    private function attributePathGet($path)
    {
        $tok = strtok($path, "/#");
        $pointer = $this;
        while (false !== $tok) {
            #capture plural references start at 1!  tsk tsk
            if (is_numeric($tok)) {
                $tok = intval($tok) - 1;
            }
            if (isset($pointer[$tok])) {
                $pointer = $pointer[$tok];
            } else {
                #property doesn't exist for this token path, return null
                return null;
            }
            $tok = strtok("/#");
        }
        #$pointer should be pointing at the the correct value at this point
        return $pointer;
    }

    /**
     * Create a new Jump User.
     *
     * You shouldn't create users from nothing since Capture users have a changing schema.  Instead, we can instantiate them from
     * raw data using ::__set_state() or create them with a factory that will pull the schema first and ensure required fields are
     * populated ::create()
     */
    protected function __construct()
    {
        $this->uuid = strtolower(Api::generateUuid());
    }

    /**
     * Get the unique identifier for this user.  In the rare, and stupid, event that a customer opts to use a different unique
     * identifier for users, this function may be overwritten to return that identifier as a string.
     *
     * @return string
     *   The unique identifier of this JumpUser.  Generally this will be UUID
     */
    public function getId()
    {
        return $this->uuid;
    }

    /**
     * @inheritsDoc
     */
    public function getMappableFields()
    {

    }

    /**
     * Enable var_export for instances of this class.  This will be the primary factory method for
     * rebuilding User objects from Capture data.
     *
     * @param Array data
     *   This data structure is simply stored internally, to pass data directly from a capture response result
     *   simply call json_decode() with the optional "force associative array" option.
     */
    public static function __set_state(array $data)
    {
        $instance = unserialize(sprintf('O:%u:"%s":0:{}', strlen(__CLASS__), __CLASS__));
        foreach ($data as $property => $value) {
            $instance->$property = $value;
        }
        if (!$instance->offsetExists('uuid')) {
            throw new \Exception("No UUID found!");
        }
        return $instance;
    }
}
