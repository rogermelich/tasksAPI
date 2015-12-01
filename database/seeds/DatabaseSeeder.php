<?php

use App\Tag;
use App\Task;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(UserTableSeeder::class);

        $faker = Faker\Factory::create();

        $this->seedTasks();
        $this->seedTags();

        Model::reguard();
    }

    /**
     * @param Faker $faker
     */
    private function seedTasks(Faker $faker){
        foreach ( range(0, 100) as $item) {
            $task = new  Task();

            $task->name = $faker->name();
            $task->done = $faker->boolean();
            $task->priority = $faker->randomDigit();
            $task->save();
        }
    }

    /**
     * @param Faker $faker
     */
    private function seedTags(Faker $faker){
        foreach ( range(0, 100) as $item) {
            $tag = new  Tag();

            $tag->name = $faker->name();
            $tag->save();
        }
    }
}
