<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator as Faker;
use App\ThinkingPiece;
class ThinkingPieceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        for ($i = 1; $i <= 10; $i++) {
            $j = $i;
            $podcast = new ThinkingPiece();
            $podcast->feature = 0;
            $podcast->thinking_piece_title = $faker->sentence();
            $podcast->thinking_piece_date =  Carbon::parse('2020-07-08')->addDay($i);
            $podcast->thinking_piece_image = 'uploads/thinking_piece/image_' . $i . '.jpg';
            $podcast->thinking_piece_address =  $faker->address;
            $podcast->description =  $faker->paragraph(50);
            $podcast->created_at = Carbon::parse('2020-07-08')->addDay($i);
            $podcast->save();
        }
    }
}