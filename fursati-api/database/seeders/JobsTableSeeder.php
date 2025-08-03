<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class JobsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('jobs')->insert([
            [
                'title' => 'Web and Mobile Developer',
                'work_place' => 'Remote',
                'education_level_id' => 2,
                'country_of_graduation' => 1,
                'country_of_residence' => 1,
                'work_field_id' => 3,
                'gender_preference' => 'all',
                'work_experience' => 3,
                'business_man_id' => 1,
                'from_date' => Carbon::now()->subDays(10),
                'to_date' => Carbon::now()->addDays(20),
                'favorite' => false,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10),
            ],
            [
                'title' => 'Senior Backend Engineer',
                'work_place' => 'On-site',
                'education_level_id' => 3,
                'country_of_graduation' => 2,
                'country_of_residence' => 2,
                'work_field_id' => 5,
                'gender_preference' => 'male',
                'work_experience' => 5,
                'business_man_id' => 2,
                'from_date' => Carbon::now()->subDays(20),
                'to_date' => Carbon::now()->addDays(15),
                'favorite' => true,
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(20),
            ],
            [
                'title' => 'Marketing Specialist',
                'work_place' => 'Hybrid',
                'education_level_id' => 1,
                'country_of_graduation' => 3,
                'country_of_residence' => 3,
                'work_field_id' => 7,
                'gender_preference' => 'female',
                'work_experience' => 2,
                'business_man_id' => 3,
                'from_date' => Carbon::now()->subDays(5),
                'to_date' => Carbon::now()->addDays(25),
                'favorite' => false,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
        ]);
    }
}
