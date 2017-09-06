<?php
namespace InstagramMedia;

use InstagramMedia\InstagramMedia;

class InstagramMediaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers InstagramMedia\InstagramMedia::getMedia
     */
    public function getMedia()
    {
        $InstagramMedia = new InstagramMedia();
        $InstagramMedia->setUserId('pretinhobasico');
        $arrMedia = $InstagramMedia->getMedia(1);
        $this->assertInternalType('array', $arrMedia);
    }
}