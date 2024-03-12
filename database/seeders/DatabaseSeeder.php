<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Treatments;
use App\Models\WorkingHour;
use Illuminate\Database\Seeder;
use App\Models\NotificationTemplate;
use File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $categories = Category::all();
        // foreach($categories as $key=>$category){
        //     Category::where('id',$category->id)->update(['order_by'=>$key+1]);
        // }

        // $treatments = Treatments::all();
        // foreach($treatments as $key=>$treatment){
        //     Treatments::where('id',$treatment->id)->update(['order_by'=>$key+1]);
        // }

        // $workingHours = WorkingHour::all();
        // WorkingHour::where('day_index','!=', 'Sunday')->delete(); 
        // foreach($workingHours as $workingHour){
        //     $workingHour->update(['booking_date'=>date('Y-m-d')]);
        // }

        $json = File::get("database/seeders/mailTemplate.json");
        $mailTemplates = json_decode($json,true);

        foreach($mailTemplates as $mailTemplate){
            NotificationTemplate::create($mailTemplate);
        }
    }
}
