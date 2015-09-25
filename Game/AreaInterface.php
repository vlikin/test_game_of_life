<?php

namespace Game;

interface AreaInterface {
    public function setObjTo($x, $y, CellInterface $cell);
    public function setObjToPos($pos, CellInterface $cell);
    public function getCellSite($x, $y);
    public function getObjFrom($x, $y);
    public function getNeighbourCellSites($pos);
    public function getNeighbourCells($pos);
    public function toString();
}