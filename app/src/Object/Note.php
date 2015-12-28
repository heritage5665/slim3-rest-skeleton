<?php

namespace App\Object;

/**
 * Class Note.
 */
class Note implements \JsonSerializable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @param int    $id
     * @param string $text
     */
    public function __construct($id, $text)
    {
        $this->id = intval($id);
        $this->text = $text;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
        ];
    }
}
