<?php

namespace Tests\Unit\Reference;

use App\Entities\Projects\Status;
use Tests\TestCase;

class ProjectStatusTest extends TestCase
{
    /** @test */
    public function retrieve_project_status_list()
    {
        $projectStatus = new Status;

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
    public function retrieve_project_status_by_id()
    {
        $projectStatus = new Status;

        $this->assertEquals(trans('project.planned'), $projectStatus->getNameById(1));
        $this->assertEquals(trans('project.progress'), $projectStatus->getNameById(2));
        $this->assertEquals(trans('project.done'), $projectStatus->getNameById(3));
        $this->assertEquals(trans('project.closed'), $projectStatus->getNameById(4));
        $this->assertEquals(trans('project.canceled'), $projectStatus->getNameById(5));
        $this->assertEquals(trans('project.on_hold'), $projectStatus->getNameById(6));
    }
}
