<?php

namespace Database\Seeders;

use App\Models\Listing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create the Admin's listing
        Listing::factory()->create([
            'user_id' => 1,
            'title' => 'Admin Administrator',
            'description' => 'We are seeking a highly organized Admin Administrator to join our dynamic team. The ideal candidate will manage office tasks, including scheduling meetings, handling correspondence, and maintaining records. Strong communication skills and proficiency in office software are essential. Join us to support our daily operations and ensure smooth administrative workflows.',
            'salary' => 71000,
            'company' => 'AdminCo.',
            'address' => 'P. Sherman 42 Wallaby Way',
            'city' => 'Sydney',
            'phone' => '08 3412 8008',
            'email' => 'admin@example.com',
            'requirements' => 'A minimum of 2 years of administrative experience with proficiency in Microsoft Office Suite. Excellent organizational skills and the ability to multitask in a fast-paced environment are essential.',
            'benefits' => 'Competitive salary, comprehensive health insurance, and opportunities for professional development.'
        ]);

        for ($i = 0; $i < 10; $i++) {
            Listing::factory()->create();
        }
    }
}
