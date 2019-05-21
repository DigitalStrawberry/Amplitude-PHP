<?php
namespace Amplitude\Message;

/**
 * Event to be tracked by Amplitude
 */
class Event extends EventAbstract
{
    const ERROR_DEVICE_ID = 'error-device-id';

    /** @var string */
    protected $userId;

    /** @var string */
    protected $deviceId;

    /** @var string */
    protected $eventType;

    /** @var long */
    protected $time;

    /** @var array */
    protected $eventProperties = array();

    /** @var array */
    protected $userProperties = array();

    /** @var string */
    protected $appVersion;

    /** @var string */
    protected $platform;

    /** @var string */
    protected $osName;

    /** @var string */
    protected $osVersion;

    /** @var string */
    protected $deviceBrand;

    /** @var string */
    protected $deviceManufacturer;

    /** @var string */
    protected $deviceModel;

    /** @var string  */
    protected $deviceType;

    /** @var string */
    protected $carrier;

    /** @var string */
    protected $country;

    /** @var string */
    protected $region;

    /** @var string */
    protected $city;

    /** @var string */
    protected $dma;

    /** @var string */
    protected $language;

    /** @var float */
    protected $revenue;

    /** @var float */
    protected $locationLat;

    /** @var float */
    protected $locationLng;

    /** @var string */
    protected $ip;

    /** @var string */
    protected $idfa;

    /** @var string */
    protected $adid;

    /** @var integer */
    protected $insertId;

    /** @var integer */
    protected $eventId;

    /** @var integer */
    protected $sessionId;

    public function __construct($type)
    {
        $this->set('event_type', $type);
    }

    /**
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function set($name, $value)
    {
        if (property_exists(get_class(), $name)) {
            $this->{$name} = $value;
        }
        return $this;
    }


    /**
     * Set the device_id of the user
     *
     * @param mixed $value
     * @return void
     */
    public function setDeviceId($value)
    {
        $this->deviceId = $value;
    }

    /**
     * Set the user_id of the user
     *
     * @param mixed $value
     * @return void
     */
    public function setUserId($value)
    {
        $this->userId = $value;
    }

    /**
     * Set revenue to the main object and event properties
     * @param float $revenue
     * @return $this
     */
    public function setRevenue($revenue)
    {
        return $this->set('revenue', $revenue)
            ->addToEventProperties('revenue', $revenue);
    }

    /**
     * Format entity
     * @return string
     */
    public function format()
    {
        return json_encode(
            array(
                'insert_id' => $this->getInsertId(),
                'event_id' => $this->getEventId(),
                'session_id' => $this->getSessionId(),
                'user_id' => $this->getUserId(),
                'device_id' => $this->getDeviceId(),
                'event_type' => $this->getEventType(),
                'time' => $this->getTime(),
                'event_properties' => $this->getEventProperties(),
                'user_properties' => $this->getUserProperties(),
                'app_version' => $this->getAppVersion(),
                'platform' => $this->getPlatform(),
                'os_name' => $this->getOsName(),
                'os_version' => $this->getOsVersion(),
                'device_brand' => $this->getDeviceBrand(),
                'device_manufacturer' => $this->getDeviceManufacturer(),
                'device_model' => $this->getDeviceModel(),
                'device_type' => $this->getDeviceType(),
                'carrier' => $this->getCarrier(),
                'country' => $this->getCountry(),
                'region' => $this->getRegion(),
                'city' => $this->getCity(),
                'dma' => $this->getDma(),
                'language' => $this->getLanguage(),
                'revenue' => $this->getRevenue(),
                'location_lat' => $this->getLocationLat(),
                'location_lng' => $this->getLocationLng(),
                'ip' => $this->getIp(),
                'idfa' => $this->getIdfa(),
                'adid' => $this->getAdid()
            ),
            JSON_FORCE_OBJECT
        );
    }

    /**
     * Sets multiple event properties.
     *
     * @param array $properties
     * @return void
     */
    public function setEventProperties($properties)
    {
        foreach($properties as $key => $value)
        {
            $this->setEventProperty($key, $value);
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function setEventProperty($name, $value)
    {
        $this->eventProperties[$name] = $value;
        return $this;
    }

    /**
     * Sets multiple user properties.
     *
     * @param array $properties
     * @return void
     */
    public function setUserProperties($properties)
    {
        foreach($properties as $key => $value)
        {
            $this->setUserProperty($key, $value);
        }

    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function setUserProperty($name, $value)
    {
        $this->userProperties[$name] = $value;
        return $this;
    }

    protected function getDeviceId()
    {
        if (empty($this->deviceId)) {
            return self::ERROR_DEVICE_ID;
        }
        return $this->deviceId;
    }

    protected function getInsertId()
    {
        if (empty($this->insertId)) {
            $time = (int) floor(microtime(true) * 1000);
            $this->insertId = "{$this->eventType}-{$this->userId}-{$this->deviceId}-{$time}";
        }
        return $this->insertId;
    }

    protected function getTime()
    {
        if (empty($this->time)) {
            $this->time = (int) floor(microtime(true) * 1000);
        }
        return $this->time;
    }

    protected function getSessionId()
    {
        if (empty($this->sessionId)) {
            $this->sessionId = -1;
        }
        return $this->sessionId;
    }

    protected function getEventId()
    {
        if (empty($this->eventId)) {
            $this->eventId = (int) ceil(microtime(true));
        }
        return $this->eventId;
    }
}
