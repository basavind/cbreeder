<?php

namespace tests\unit;

use OCA\CBreeder\Materials\Presentation;
use OCA\CBreeder\Materials\Text;
use OCA\CBreeder\Materials\Video;
use PHPUnit_Framework_TestCase;
use OCA\CBreeder\DB\Material;

class MaterialTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function material_hydrates_subtypes_based_on_class_property()
    {
        $text = $this->dumpMaterial(Text::class);
        $video = $this->dumpMaterial(Video::class);
        $presentation = $this->dumpMaterial(Presentation::class);

        $this->assertEquals(get_class($text), Text::class);
        $this->assertEquals(get_class($video), Video::class);
        $this->assertEquals(get_class($presentation), Presentation::class);
    }

    /** @test */
    public function material_returns_right_stage_with_get_stage_at()
    {
        $material = $this->dumpMaterial(Text::class);

        $this->assertEquals($material->getStageAt(0), Text::$stages[0]);
        $this->assertEquals($material->getStageAt(1), Text::$stages[1]);
        $this->assertEquals($material->getStageAt(2), Text::$stages[2]);
    }

    /**
     * @test
     *
     * @expectedException \OCA\CBreeder\Materials\UndefinedStageException
     */
    public function it_throws_exception_at_upper_index_trying_to_get_stage_at()
    {
        $material = $this->dumpMaterial();
        $material->getStageAt(100);
    }

    /**
     * @test
     *
     * @expectedException \OCA\CBreeder\Materials\UndefinedStageException
     */
    public function it_throws_exception_at_negative_index_trying_to_get_stage_at()
    {
        $material = $this->dumpMaterial();
        $material->getStageAt(-5);
    }

    /** @test */
    public function material_stages_up()
    {
        $material = $this->dumpMaterial();

        $material->stageUp();

        $this->assertEquals($material->getStageAt(1), $material->getStage());
    }

    /** @test */
    public function material_stages_down()
    {
        $material = $this->dumpMaterial();

        $material->setStage($material->getStageAt(5));
        $material->stageDown();

        $this->assertEquals($material->getStageAt(4), $material->getStage());
    }

    private function dumpMaterial($class = Text::class, $state = Material::STATE_AVAILABLE)
    {
        return Material::fromRow([
            'id' => 0,
            'name' => 'material',
            'path' => '/material',
            'course_part' => null,
            'state' => $state,
            'type' => null,
            'stage' => $class::$stages[0],
            'class' => $class,
        ]);
    }
}
