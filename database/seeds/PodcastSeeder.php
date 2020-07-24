<?php

use App\Filter;
use App\Podcast;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator as Faker;

class PodcastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        $topics = Filter::where('filter_name', 2)->where('status', 1)->orderBy('tag_name', 'ASC')->get();
        for ($i = 21; $i <= 30; $i++) {
            $j = $i;
            if ($topics->count() < $i) {
                $j = $i - $topics->count();
            }
            $podcast = new Podcast();
            $podcast->feature = 0;
            $podcast->topical_id = json_encode($topics->forPage($j, 1)->pluck('id')->all());
            $podcast->title = $faker->sentence();
            $podcast->audio_file = 'uploads/audio/audio_' . $i . '.mp3';
            $podcast->podcast_image = 'uploads/podcast/podcast_' . $i . '.jpg';
            $podcast->thumb_image = "uploads/podcast/thumb/podcast_" . $i . ".jpg";
            $podcast->social_image = "uploads/podcast/social/podcast_" . $i . ".jpg";
            $podcast->description =  $faker->paragraph(50);
            $podcast->created_at = '2020-07-01 09:39:12';
            $podcast->save();
        }
    }
}
