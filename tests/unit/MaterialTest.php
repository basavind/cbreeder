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
        $attrs = [
            'id' => 0,
            'name' => 'material',
            'path' => '/material',
            'course_part' => null,
            'state' => Material::STATE_AVAILABLE,
            'type' => null,
        ];

        $text = Material::fromRow(array_merge($attrs, [
            'stage' => Text::getStage(0),
            'class' => Text::class
        ]));
        $video = Material::fromRow(array_merge($attrs, [
            'stage' => Video::getStage(0),
            'class' => Video::class
        ]));
        $presentation = Material::fromRow(array_merge($attrs, [
            'stage' => Presentation::getStage(0),
            'class' => Presentation::class
        ]));

        $this->assertEquals(get_class($text), Text::class);
        $this->assertEquals(get_class($video), Video::class);
        $this->assertEquals(get_class($presentation), Presentation::class);
    }
}
