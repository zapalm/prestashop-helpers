<?php
namespace zapalm\prestashopHelpers\tests\fixtures;

/**
 * Fixture A.
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class FixtureA
{
    /** @var int ID. */
    private $id;

    /** @var string Data. */
    private $data;

    /** @var string Name. */
    public $name;

    /** @var string Sex. */
    public $sex;

    /**
     * Constructor.
     *
     * @param int    $id   The ID.
     * @param string $data The data.
     * @param string $name The name.
     * @param string $sex  The sex.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function __construct($id, $data, $name, $sex)
    {
        $this->id   = $id;
        $this->data = $data;
        $this->name = $name;
        $this->sex  = $sex;
    }

    /**
     * Returns an ID.
     *
     * @return int
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a data.
     *
     * @return string
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function getData()
    {
        return $this->data;
    }
}