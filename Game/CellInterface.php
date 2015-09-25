<?php

namespace Game;

interface CellInterface {
    public function live();
    public function countGenerations();
    public function setIsDying();
    public function setIsGrowing();
    public function isDying();
    public function isGrowing();
    public function isMature();
    public function setMature();
}