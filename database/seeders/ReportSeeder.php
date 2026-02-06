<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['category' => 'reduce', 'metric_name' => 'Waste Reduction', 'value' => '15%'],
            ['category' => 'reduce', 'metric_name' => 'Energy Savings', 'value' => '20%'],
            ['category' => 'reduce', 'metric_name' => 'Material Efficiency', 'value' => '10%'],
            ['category' => 'reuse', 'metric_name' => 'Component Reuse Rate', 'value' => '25%'],
            ['category' => 'reuse', 'metric_name' => 'Recycled Parts', 'value' => '30%'],
            ['category' => 'reuse', 'metric_name' => 'Lifecycle Extension', 'value' => '40%'],
            ['category' => 'recycle', 'metric_name' => 'Recycling Rate', 'value' => '95%'],
            ['category' => 'recycle', 'metric_name' => 'Material Recovery', 'value' => '85%'],
            ['category' => 'recycle', 'metric_name' => 'CO2 Reduction', 'value' => '50 tons'],
            ['category' => 'recover', 'metric_name' => 'Energy Recovery', 'value' => '60%'],
            ['category' => 'recover', 'metric_name' => 'Heat Utilization', 'value' => '70%'],
            ['category' => 'recover', 'metric_name' => 'Fuel Savings', 'value' => '35%'],
            ['category' => 'rethink', 'metric_name' => 'New Initiatives', 'value' => '5'],
            ['category' => 'rethink', 'metric_name' => 'Innovation Rate', 'value' => '12%'],
            ['category' => 'rethink', 'metric_name' => 'Sustainability Score', 'value' => '8.5/10'],
        ];

        foreach ($data as $item) {
            \App\Models\Report::create($item);
        }
    }
}
