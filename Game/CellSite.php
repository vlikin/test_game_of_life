<?php

namespace Game;

class CellSite implements CellSiteInterface {

    private $cell = null;

    public function setCell(CellInterface $cell) {
        $this->deleteCell();
        $this->cell = $cell;
    }

    public function getCell() {
        return $this->cell;
    }

    public function isEmpty() {
        return $this->cell === null;
    }

    public function deleteCell() {
        $this->cell = null;
    }

    public function apply() {
        if (!$this->isEmpty()) {
            $cell = $this->getCell();
            if ($cell->isDying()) {
                $this->deleteCell();
            }
            else if($cell->isGrowing()) {
                $cell->setMature();
            }
        }
    }

}