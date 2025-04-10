<?php

namespace Database\Seeders;

use App\Models\Candidate;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    public function run(): void
    {
        $candidates = [
            [
                'name' => 'John Doe',
                'vision' => 'Building a transparent and secure digital voting system',
                'mission' => 'Implement blockchain technology to ensure vote integrity and provide real-time verification',
                'photo_path' => null
            ],
            [
                'name' => 'Jane Smith',
                'vision' => 'Creating an inclusive and accessible voting platform',
                'mission' => 'Develop user-friendly interfaces and provide multi-language support for all voters',
                'photo_path' => null
            ],
            [
                'name' => 'Mike Johnson',
                'vision' => 'Revolutionizing democratic participation',
                'mission' => 'Increase voter turnout through education and easy-to-use digital solutions',
                'photo_path' => null
            ]
        ];

        foreach ($candidates as $candidate) {
            Candidate::create($candidate);
        }
    }
} 