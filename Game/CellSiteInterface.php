<?php

namespace Game;

interface CellSiteInterface {
    public function setCell(CellInterface $cell);
    public function getCell();
    public function apply();
    public function isEmpty();
    public function deleteCell();
}