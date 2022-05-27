<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subject = [
            [
                'subject_name' => 'Bangla',
            ],
            [
                'subject_name' => 'English',
            ],
        ];

        foreach ($subject as $key => $value) {
            Subject::create($value);
        }
    }

}
