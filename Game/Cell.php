<?php

namespace Game;

class Cell implements CellInterface {
    const NOT_INITIALIZED = -3;
    const IS_DYING = -2;
    const IS_GROWING = -1;
    const MATURE = 1;

    private $generationNumber = 0;
    public $state = self::NOT_INITIALIZED;

    public function setIsDying() {
        $this->state = self::IS_DYING;
    }

    public function setIsGrowing() {
        $this->state = self::IS_GROWING;
    }

    public function isDying() {
        return $this->state == self::IS_DYING;
    }

    public function isGrowing() {
        return $this->state == self::IS_GROWING;
    }

    public function isMature() {
        return $this->state == self::MATURE;
    }

    public function setMature() {
        $this->state = self::MATURE;
    }

    public function live() {
        return ++$this->generationNumber;
    }

    public function countGenerations() {
        return $this->generationNumber;
    }

    public function __construct() {
        $this->setIsGrowing();
    }

}