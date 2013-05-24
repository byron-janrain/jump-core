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

	public static function create(array $properties)
	{
		return new self();
	}

	public static function __set_state(array $data)
	{
		$instance = unserialize(sprintf('O:%u:"%s":0:{}', strlen(__CLASS__), __CLASS__));
		foreach (get_object_vars($instance) as $k => $v) {
			$instance->{$k} = $data[$k];
		}
		return $instance;
	}
}
