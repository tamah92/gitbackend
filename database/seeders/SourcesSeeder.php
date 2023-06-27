<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sources;

class SourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $sources = [
            [
                "label" => "News",
            ],
            [
                "label" => "The Guardian",
            ],
            [
                "label" => "New York Times",
            ],
        ];

        foreach( $sources as $source ) {
            $getSource = Sources::where('label', $source["label"])->first();
            if(empty($getSource)){
                $saveSource = new Sources;
                $saveSource->label = $source["label"];
                $saveSource->save();
            }
        }
    }
}
