<?php

namespace tests\unit;

use OCA\CBreeder\Materials\Presentation;
use OCA\CBreeder\Materials\Text;
use OCA\CBreeder\Materials\Video;
use PHPUnit_Framework_TestCase;
use OCA\CBreeder\DB\Material;

class MaterialTest extends PHPUnit_Framework_TestCase
{
    public function testTypedHydration()
    {
        $text = $this->dumpMaterial(Text::class);
        $video = $this->dumpMaterial(Video::class);
        $presentation = $this->dumpMaterial(Presentation::class);

        $this->assertEquals(get_class($text), Text::class);
        $this->assertEquals(get_class($video), Video::class);
        $this->assertEquals(get_class($presentation), Presentation::class);
    }

    private function dumpMaterial($class = Text::class)
    {
        return Material::fromRow([
            'id' => 0,
            'name' => 'material',
            'path' => '/material',
            'course_part' => null,
            'state' => Material::STATE_AVAILABLE,
            'type' => null,
            'stage' => $class::getStage(0),
            'class' => $class,
        ]);
    }
}
