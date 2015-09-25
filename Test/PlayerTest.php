<?php

namespace Test;

use Game\Player;

require_once(dirname(__FILE__) . '/../system.php');

class University2DTest extends TestBase {

    public function testThis() {
        $input =
            '..........\n' . // 1
            '..........\n' . // 2
            '...*......\n' . // 3
            '...*.*....\n' . // 4
            '...**.....\n' . // 5
            '..........\n' . // 6
            '..........\n' . // 7
            '..........\n' . // 8
            '..........\n' . // 9
            '..........';    // 10

        $player = Player::createFromString($input);
        print $player->toString();

        $player->play();
        print $player->toString();

        $player->play();
        print $player->toString();


        $player->play();
        print $player->toString();


        $player->play();
        print $player->toString();

        $this->assertTrue(False);
    }

}