<?php

namespace Game;

class University2D implements AreaInterface {

    private $list = [];
    private $rows = 0;
    private $cols = 0;
    private $neighbours = NULL;

    public function getList() {
        return $this->list;
    }

    public function __construct($cols, $rows) {
        $this->cols = $cols;
        $this->rows = $rows;
        $length = $this->cols * $this->rows;
        for ($i = 0; $i < $length; $i++) {
            $this->list[] = new CellSite();
        }
    }

    public function setObjToPos($pos, CellInterface $cell) {
        $cellSite = $this->list[$pos];
        $cellSite->setCell($cell);
    }

    public function setObjTo($x, $y, CellInterface $cell) {
        $pos = $this->getPos($x, $y);
        $this->list[$pos]->setCell($cell);
    }

    public function getCellSite($x, $y) {
        $pos = $this->getPos($x, $y);
        return $this->list[$pos];
    }

    private function getPos($x, $y) {
        return $pos = $y * $this->cols + $x;
    }

    public function getObjFrom($x, $y) {
        $pos = $this->getPos($x, $y);
        return $this->list[$pos];
    }

    private function calculateSideRules($pos) {
        return [
            'l' => !($pos % $this->cols == 0),
            'r' => !(($pos + 1) % $this->cols == 0),
            't' => !(floor($pos / $this->cols) == 0),
            'b' => !(ceil(($pos + 1) / $this->cols) == $this->rows)
        ];
    }

    private function getNeighbourMap() {
        if (!is_null($this->neighbours)) {
            return $this->neighbours;
        }

        $this->neighbours = [
            [
                'shift' => -($this->cols + 1),
                'rules' => ['t', 'l'],
            ],
            [
                'shift' => -$this->cols,
                'rules' => ['t'],
            ],
            [
                'shift' => -($this->cols - 1),
                'rules' => ['t', 'r'],
            ],
            [
                'shift' => -1,
                'rules' => ['l'],
            ],
            [
                'shift' => 1 ,
                'rules' => ['r'],
            ],
            [
                'shift' => $this->cols - 1,
                'rules' => ['l', 'b'],
            ],
            [
                'shift' => $this->cols,
                'rules' => ['b'],
            ],
            [
                'shift' => $this->cols + 1,
                'rules' => ['r', 'b'],
            ],
        ];

        return $this->neighbours;
    }

    public function getNeighbourCellSites($pos) {
        $neighbourCellSites = [];
        $rules = $this->calculateSideRules($pos);
        $neighbourMap = $this->getNeighbourMap();
        foreach ($neighbourMap as $neighbour) {
            $toContinue = TRUE;
            foreach ($neighbour['rules'] as $ruleKey) {
                $toContinue = $toContinue && $rules[$ruleKey];
                if (!$toContinue) {
                    break;
                }
            }
            if ($toContinue) {
                $nearIndex = $pos + $neighbour['shift'];
                $neighbourCellSites[] = $this->list[$nearIndex];
            }
        }

        return $neighbourCellSites;
    }

    public function toString() {
        return implode(
            chr(10),
            array_map(
                function($array) {
                    return implode(
                        '',
                        array_map(
                            function(CellSite $cell) {
                                return $cell->isEmpty() ? '.' : '*';
                            },
                            $array
                        )
                    );
                },
                array_chunk($this->list, $this->cols)
            )
        );
    }

    public function getNeighbourCells($pos, $filter = NULL) {
        $neighbourCellSites = $this->getNeighbourCellSites($pos);
        $neighbourCells = [];
        foreach ($neighbourCellSites as $cellSite) {
            if ($cellSite->isEmpty()) {
                continue;
            }
            $cell = $cellSite->getCell();
            if (($filter == NULL) || ($filter != NULL && call_user_func($filter, $cell))) {
                $neighbourCells[] = $cell;
            }
        }

        return $neighbourCells;
    }

}