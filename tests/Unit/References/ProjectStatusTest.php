<?php

namespace Tests\Unit\Reference;

use Tests\TestCase;
use App\Entities\Projects\Status;

class ProjectStatusTest extends TestCase
{
    /** @test */
    public function retrieve_project_status_list()
    {
        $projectStatus = new Status();

        $this->assertEquals([
            1 => trans('project.planned'),
            2 => trans('project.progress'),
            3 => trans('project.done'),
            4 => trans('project.closed'),
            5 => trans('project.canceled'),
            6 => trans('project.on_hold'),
        ], $projectStatus->toArray());
    }

    /** @test */
    public function retrieve_project_status_name_by_id()
    {
        $projectStatus = new Status();

        $this->assertEquals(trans('project.planned'), $projectStatus->getNameById(1));
        $this->assertEquals(trans('project.progress'), $projectStatus->getNameById(2));
        $this->assertEquals(trans('project.done'), $projectStatus->getNameById(3));
        $this->assertEquals(trans('project.closed'), $projectStatus->getNameById(4));
        $this->assertEquals(trans('project.canceled'), $projectStatus->getNameById(5));
        $this->assertEquals(trans('project.on_hold'), $projectStatus->getNameById(6));
    }

    /** @test */
    public function retrieve_project_status_icon_by_id()
    {
        $projectStatus = new Status();

        $this->assertEquals('paperclip', $projectStatus->getIconById(1));
        $this->assertEquals('tasks', $projectStatus->getIconById(2));
        $this->assertEquals('thumbs-o-up', $projectStatus->getIconById(3));
        $this->assertEquals('money', $projectStatus->getIconById(4));
        $this->assertEquals('frown-o', $projectStatus->getIconById(5));
        $this->assertEquals('hand-paper-o', $projectStatus->getIconById(6));
    }

    /** @test */
    public function retrieve_project_status_color_class_by_id()
    {
        $projectStatus = new Status();

        $this->assertEquals('default', $projectStatus->getColorById(1));
        $this->assertEquals('yellow', $projectStatus->getColorById(2));
        $this->assertEquals('primary', $projectStatus->getColorById(3));
        $this->assertEquals('green', $projectStatus->getColorById(4));
        $this->assertEquals('danger', $projectStatus->getColorById(5));
        $this->assertEquals('warning', $projectStatus->getColorById(6));
    }
}
