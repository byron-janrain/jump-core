<?php
namespace janrain\jump;

/**
 * The fundamental unit of data for Janrain.  The user.
 */
class User
{
	/**
	 * @var string the Capture UUID or generated Capture-compatible UUID
	 */
	protected $uuid;

	/**
	 * @var array internal data structure if direct access is necessary by subclasses.
	 */
	protected $data;

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
	 * Return the unique identifier for this Jump User.
	 *
	 * @return string
	 */
	public function getUuid()
	{
		return $this->uuid;
	}

	/**
	 * At it's core, this is a value object so implement the default accessor. The internal structure is php arrays so you can use array notation
	 * To get at nested data.
	 * e.g.
	 *     $var = $instance->propertyName;
	 *     $var = $instance->propertyName['nestedKey'][0];
	 *
	 * Use complex key notation for json-valid-php-invalid key names
	 *     $var = $instance->{'property.name'};
	 *     $var = $instance->{"property\nname"};
	 *
	 * @param string property
	 *   The name of the property you're interested in, or an array path to nested data.
	 *
	 * @return mixed|null
	 *   The value for the given property. If the property doesn't exist or isn't set this returns null.
	 */
	public function __get($property)
	{
		return @$this->data[$property];
	}

	/**
	 * Create a new Jump User from the given data.  @todo make this do something
	 */
	public static function create(array $properties)
	{
		return new self();
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
		$instance->data = $data;
		$instance->uuid = $data['uuid'];
		return $instance;
	}
}
