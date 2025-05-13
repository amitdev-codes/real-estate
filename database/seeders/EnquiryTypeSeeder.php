<?php

namespace Database\Seeders;

use App\Models\EnquiryType;
use Illuminate\Database\Seeder;

class EnquiryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Property Inquiry',
            'Rent Inquiry',
            'Sale Inquiry',
            'Agent Assistance',
            'Legal Assistance',
            'General Inquiry',
            'Price guide',
            'Completion date',
            'Development size',
            'Inspection times',
            'Request floor plan',

        ];

        foreach ($types as $type) {
            EnquiryType::firstOrCreate(['name' => $type]);
        }
    }
}
