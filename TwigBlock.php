<?php

namespace Plugin\Test;

use Eccube\Common\EccubeTwigBlock;

class TwigBlock implements EccubeTwigBlock
{
    /**
     * @return array
     */
    public static function getTwigBlock()
    {
        return [];
    }
}
