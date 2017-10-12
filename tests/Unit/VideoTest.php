<?php

namespace Tests\Unit;

use App\Video;
use App\Rental;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoTest extends TestCase
{
    use DatabaseTransactions;

    public function testItCanGetOnlyAvailableVideos()
    {
        $video1 = factory(Video::class)->create();
        $video2 = factory(Video::class)->create();

        factory(Rental::class)->states(['withUser'])->create([
            'rentable_id' => $video1->id,
            'rentable_type' => get_class($video1),
            'checkout_date' => Carbon::createFromDate(2017, 01, 01),
            'due_date' => Carbon::createFromDate(2017, 01, 15),
            'return_date' => Carbon::createFromDate(2017, 01, 11)
        ]);

        factory(Rental::class)->states(['withUser'])->create([
            'rentable_id' => $video2->id,
            'rentable_type' => get_class($video2),
            'checkout_date' => Carbon::createFromDate(2017, 01, 01),
            'due_date' => Carbon::createFromDate(2017, 01, 15),
            'return_date' => null
        ]);

        $availableVideos = Video::available()->get();

        $this->assertTrue($availableVideos->contains($video1));
        $this->assertFalse($availableVideos->contains($video2));
    }

    public function testItCanGetOnlyUnavailableVideos()
    {
        $video1 = factory(Video::class)->create();
        $video2 = factory(Video::class)->create();

        factory(Rental::class)->states(['withUser'])->create([
            'rentable_id' => $video1->id,
            'rentable_type' => get_class($video1),
            'checkout_date' => Carbon::createFromDate(2017, 01, 01),
            'due_date' => Carbon::createFromDate(2017, 01, 15),
            'return_date' => null
        ]);

        factory(Rental::class)->states(['withUser'])->create([
            'rentable_id' => $video2->id,
            'rentable_type' => get_class($video2),
            'checkout_date' => Carbon::createFromDate(2017, 01, 01),
            'due_date' => Carbon::createFromDate(2017, 01, 15),
            'return_date' => Carbon::createFromDate(2017, 01, 11)
        ]);

        $unavailableVideos = Video::unavailable()->get();

        $this->assertTrue($unavailableVideos->contains($video1));
        $this->assertFalse($unavailableVideos->contains($video2));
    }

    public function testItCanGetOnlyOverdueVideos()
    {
        $video1 = factory(Video::class)->create();
        $video2 = factory(Video::class)->create();

        factory(Rental::class)->states(['withUser'])->create([
            'rentable_id' => $video1->id,
            'rentable_type' => get_class($video1),
            'checkout_date' => Carbon::createFromDate(2017, 01, 01),
            'due_date' => Carbon::createFromDate(2017, 01, 15),
            'return_date' => Carbon::createFromDate(2017, 01, 11)
        ]);

        factory(Rental::class)->states(['withUser'])->create([
            'rentable_id' => $video2->id,
            'rentable_type' => get_class($video2),
            'checkout_date' => Carbon::createFromDate(2017, 01, 01),
            'due_date' => Carbon::createFromDate(2017, 01, 15),
            'return_date' => null
        ]);

        $overdueVideos = Video::overdue()->get();

        $this->assertTrue($overdueVideos->contains($video2));
        $this->assertFalse($overdueVideos->contains($video1));
    }
}
