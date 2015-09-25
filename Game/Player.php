<?php

namespace Game;

class Player implements PlayerInterface {
    private $university = null;
    private $generationNumber = 0;

    private function apply() {
        $list = $this->university->getList();
        foreach ($list as $cellSite) {
            $cellSite->apply();
        }
    }

    public function play() {
        $this->generationNumber++;
        $cellSites = $this->university->getList();
        foreach ($cellSites as $pos => $cellSite) {
            $neighbourCells = $this->university->getNeighbourCells($pos);
            if (!$cellSite->isEmpty()) {
                $cell = $cellSite->getCell();
                $cell->live();
                if (count($neighbourCells) < 2 || count($neighbourCells) > 3) {
                    $cellSite->getCell()->setIsDying();
                }
            }
        }

        foreach ($cellSites as $pos => $cellSite) {

            if ($cellSite->isEmpty()) {
                $neighbourCells = $this->university->getNeighbourCells($pos, function($cell) {
                    return $cell->isMature() || $cell->isDying();
                });
                if (count($neighbourCells) == 3) {
                    $newCell = new Cell();
                    $this->university->setObjToPos($pos, $newCell);
                }
            }
        }

        $this->apply();
    }

    public function __construct($cols, $rows) {
        $this->university = new University2D($cols, $rows);
    }

    static public function createFromString($string) {
        $lines = explode('\n', $string);
        $rows = count($lines);
        $cols = strlen($lines[0]);
        $player = new Player($cols, $rows);
        foreach ($lines as $y => $line) {
            foreach (str_split($line) as $x => $char) {
                if ($char == '*') {
                    $cell = new Cell();
                    $cell->setMature();
                    $player->university->setObjTo($x, $y, $cell);
                }
            }
        }

        return $player;
    }

    public function toString() {
        $string = chr(10) . 'Generation = ' . $this->generationNumber . chr(10);
        $string .= $this->university->toString();
        $string .= chr(10);

        return $string;
    }

}