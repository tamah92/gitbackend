<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Catagories;

class CatagoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $catagories = [
            [
                "label" => "Apple Articles",
                "value" => "apple",
                "search_param" => "q",
                "source_id" => 1,
            ],
            [
                "label" => "Tesla Car Articles",
                "value" => "tesla",
                "search_param" => "q",
                "source_id" => 1,
            ],
            [
                "label" => "Business Headlines in US",
                "value" => "business",
                "search_param" => "category",
                "source_id" => 1,
            ],
            [
                "label" => "TechCrunch",
                "value" => "techcrunch",
                "search_param" => "sources",
                "source_id" => 1,
            ],
            [
                "label" => "Wall Street Journal",
                "value" => "wsj.com",
                "search_param" => "domains",
                "source_id" => 1,
            ],
            [
                "label" => "US news",
                "value" => "us-news",
                "search_param" => "sectionId",
                "source_id" => 2,
            ],
            [
                "label" => "World news",
                "value" => "world",
                "search_param" => "sectionId",
                "source_id" => 2,
            ],
            [
                "label" => "Football",
                "value" => "football",
                "search_param" => "sectionId",
                "source_id" => 2,
            ],
            [
                "label" => "Politics",
                "value" => "politics",
                "search_param" => "sectionId",
                "source_id" => 2,
            ],
            [
                "label" => "Opinion",
                "value" => "commentisfree",
                "search_param" => "sectionId",
                "source_id" => 2,
            ],
            [
                "label" => "Australia news",
                "value" => "australia-news",
                "search_param" => "sectionId",
                "source_id" => 2,
            ],
            [
                "label" => "Arts",
                "value" => "arts",
                "search_param" => "n/a",
                "source_id" => 3,
            ],
            [
                "label" => "Science",
                "value" => "science",
                "search_param" => "n/a",
                "source_id" => 3,
            ],
            [
                "label" => "US Matters",
                "value" => "us",
                "search_param" => "n/a",
                "source_id" => 3,
            ],
            [
                "label" => "World",
                "value" => "world",
                "search_param" => "n/a",
                "source_id" => 3,
            ],
        ];

        foreach( $catagories as $catagory ) {
            $getCatagory = Catagories::where('label', $catagory["label"])->where('source_id', $catagory["source_id"])->first();
            if(empty($getCatagory)){
                $saveCatagory = new Catagories;
                $saveCatagory->label = $catagory["label"];
                $saveCatagory->source_id = $catagory["source_id"];
                $saveCatagory->value = $catagory["value"];
                $saveCatagory->search_param = $catagory["search_param"];
                $saveCatagory->save();
            }
        }
    }
}