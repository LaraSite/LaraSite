<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use App\Entities\Article;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('articles')->delete();

        $statuses = Article::$statuses;
        $faker = Faker\Factory::create('en_US');
        $today = Carbon::today();

        for ($i = 0; $i < 1000; $i++) {
            Article::create([
              'title' => $faker->sentence(),
              'body' => $faker->paragraph(),
              'status' => $statuses[array_rand($statuses)],
              'published_at' => $today,
            ]);
        }

        Model::reguard();
    }
}
