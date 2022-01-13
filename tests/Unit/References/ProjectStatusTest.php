<?php

namespace Tests\Unit\References;

use App\Entities\Projects\Status;
use Tests\TestCase;

class ProjectStatusTest extends TestCase
{
    /** @test */
    public function retrieve_project_status_list()
    {
        $projectStatus = new Status();

        $this->assertEquals([
            1 => __('project.planned'),
            2 => __('project.progress'),
            3 => __('project.done'),
            4 => __('project.closed'),
            5 => __('project.canceled'),
            6 => __('project.on_hold'),
        ], $projectStatus->toArray());
    }

    /** @test */
    public function retrieve_project_status_name_by_id()
    {
        $projectStatus = new Status();

        $this->assertEquals(__('project.planned'), $projectStatus->getNameById(1));
        $this->assertEquals(__('project.progress'), $projectStatus->getNameById(2));
        $this->assertEquals(__('project.done'), $projectStatus->getNameById(3));
        $this->assertEquals(__('project.closed'), $projectStatus->getNameById(4));
        $this->assertEquals(__('project.canceled'), $projectStatus->getNameById(5));
        $this->assertEquals(__('project.on_hold'), $projectStatus->getNameById(6));
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
