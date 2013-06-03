<?php
namespace janrain\jump;

/**
 * The fundamental unit of data for Janrain.  The user.
 */
class User
{
	/**
	 * @var string
	 */
	protected $uuid;

	/**
	 * @var array
	 */
	protected $data;

	protected function __construct()
	{
		$uuid = `uuidgen`;
		if (is_null($uuid)) {
			throw new \Exception('Cannot create uuid!');
		}
		$this->uuid = strtolower(`uuidgen`);
	}

	public function getUuid() {
		return $this->uuid;
	}

	public function __get($property)
	{
		return @$this->data[$property];
	}

	public static function create(array $properties)
	{
		return new self();
	}

	public static function __set_state(array $data)
	{
		$instance = unserialize(sprintf('O:%u:"%s":0:{}', strlen(__CLASS__), __CLASS__));
		$instance->data = $data;
		$instance->uuid = $data['uuid'];
		return $instance;
	}
}
