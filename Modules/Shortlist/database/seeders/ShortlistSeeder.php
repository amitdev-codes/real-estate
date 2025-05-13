<?php

namespace Modules\Shortlist\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Agent\Models\Agent;
use Modules\Agency\Models\Agency;
use Illuminate\Support\Facades\DB;
use Modules\Property\Models\Property;
use Modules\Shortlist\Models\Shortlist;

class ShortlistSeeder extends Seeder
{
    public function run()
    {
        // Get users, properties, agents, and agencies
        $users = User::take(50)->get();
        $properties = Property::all();
        $agents = Agent::all();
        $agencies = Agency::all();
        
        if ($users->isEmpty() || $properties->isEmpty()) {
            $this->command->info('Cannot seed shortlists: Users or Properties not found');
            return;
        }
        
        // Clear existing shortlists
        DB::table('shortlists')->truncate();
        
        $shortlistData = [];
        
        foreach ($users as $user) {
            // Each user shortlists 1-5 properties randomly
            $propertyCount = rand(1, 5);
            $shortlistedProperties = $properties->random($propertyCount);
            
            foreach ($shortlistedProperties as $property) {
                // Get random agent and agency
                $agent = $agents->isNotEmpty() ? $agents->random() : null;
                $agency = $agencies->isNotEmpty() ? $agencies->random() : null;
                
                $shortlistData[] = [
                    'user_id' => $user->id,
                    'agent_id' => $agent ? $agent->id : null,
                    'agency_id' => $agency ? $agency->id : null,
                    'property_id' => $property->id,
                    'shortlistable_id' => $property->id,
                    'shortlistable_type' => get_class($property),
                    'notes' => fake()->boolean(30) ? fake()->sentence() : null,
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ];
            }
        }
        
        // Insert in chunks to avoid memory issues
        foreach (array_chunk($shortlistData, 100) as $chunk) {
            DB::table('shortlists')->insert($chunk);
        }
        
        $this->command->info('Shortlists seeded successfully: ' . count($shortlistData) . ' entries created');
    }

    private function generatePropertyNote($property)
    {
        $notes = [
            'Great location, need to schedule viewing',
            'Price seems reasonable for the area',
            'Check availability for next month',
            'Perfect size but might need renovation',
            'Good investment opportunity',
            'Like the garden, need to check nearby schools',
            'Modern design, matches requirements',
            'Need to verify parking situation',
        ];

        return $notes[array_rand($notes)].' - Added on '.now()->format('M d, Y');
    }

    private function generateAgencyNote($agency)
    {
        $notes = [
            'Highly rated, contact for portfolio',
            'Good reviews on property management',
            'Check their current listings',
            'Known for luxury properties',
            "Specializes in the area I'm interested in",
            'Need to verify commission rates',
            'Schedule consultation meeting',
        ];

        return $notes[array_rand($notes)].' - Added on '.now()->format('M d, Y');
    }
}
