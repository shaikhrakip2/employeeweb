<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index(Request $request)
    {
      
        $title = 'Events';

            DB::statement("SET SQL_MODE = ''");
            $eventData = Event::select('event_categories.id', 'event_categories.name as cat_name','event_categories.slug as cat_slug','event_categories.status','events.category_id','events.title','events.slug','events.image','events.sort_description','events.sort_order','events.created_at')
                 ->leftJoin('event_categories', 'events.category_id', '=', 'event_categories.id')
                 ->where('event_categories.status', '1')
                 ->where('events.status', '1')
                 ->orderBy('events.sort_order', 'desc')
                 ->paginate(8);

            $eventcatData = EventCategory::where('status','1')
                ->orderBy('id', 'asc')
                ->get();
            
            $sideeventData = Event::select('event_categories.id', 'event_categories.name as cat_name','event_categories.slug as cat_slug','event_categories.status','events.category_id','events.title','events.slug','events.image','events.sort_description','events.sort_order','events.created_at')
                ->leftJoin('event_categories', 'events.category_id', '=', 'event_categories.id')
                ->where('event_categories.status', '1')
                ->where('events.status', '1')
                ->inRandomOrder()
                ->limit(5)
                ->get();

                $footer_cat = Category::where('status', '1')
                ->whereNull('deleted_at')
                ->where('status', '1')
                ->get();

        return view('frontend.events', compact('title','eventData','footer_cat','eventcatData','sideeventData'));
    }


    public function categoryevents(Request $request,$cateventslug)
    {
        
        $title = 'Events';

            DB::statement("SET SQL_MODE = ''");
            $eventData = Event::select('event_categories.id', 'event_categories.name as cat_name','event_categories.slug as cat_slug','event_categories.status','events.category_id','events.title','events.slug','events.image','events.sort_description','events.sort_order','events.created_at')
                 ->leftJoin('event_categories', 'events.category_id', '=', 'event_categories.id')
                 ->where('event_categories.slug', $cateventslug)
                 ->where('event_categories.status', '1')
                 ->orderBy('events.sort_order', 'desc')
                 ->paginate(8);
            // dd($eventData);
            
            $eventcatData = EventCategory::where('status','1')
                ->orderBy('id', 'asc')
                ->get();

            $sideeventData = Event::select('event_categories.id', 'event_categories.name as cat_name','event_categories.slug as cat_slug','event_categories.status','events.category_id','events.title','events.slug','events.image','events.sort_description','events.sort_order','events.created_at')
                ->leftJoin('event_categories', 'events.category_id', '=', 'event_categories.id')
                ->where('event_categories.status', '1')
                // ->orderBy('events.sort_order', 'desc')
                ->inRandomOrder()
                ->limit(5)
                ->get();

                $footer_cat = Category::where('status', '1')
                ->whereNull('deleted_at')
                ->where('status', '1')
                ->get();

                $slug = $cateventslug;
           
        // $title = $eventData->isNotEmpty() ? $eventData->first()->cat_name : null;

        return view('frontend.catevents', compact('title','slug','footer_cat','eventData','eventcatData','sideeventData'));
    }
   

    public function eventdetails(Request $request,$eventslug)
    {
      
        $title = 'Event Details';

            DB::statement("SET SQL_MODE = ''");
            $eventData = Event::select('event_categories.id','event_categories.name as cat_name','event_categories.slug as cat_slug','event_categories.status','events.category_id','events.title','events.slug','events.image','events.description','events.sort_order','events.created_at')
                 ->leftJoin('event_categories', 'events.category_id', '=', 'event_categories.id')
                 ->where('events.slug', $eventslug)
                 ->where('event_categories.status', '1')
                 ->orderBy('events.sort_order', 'desc')
                 ->get();
            // dd($eventData);
            
            $eventcatData = EventCategory::where('status','1')
                ->orderBy('id', 'asc')
                ->get();

           if(!empty($eventData[0]['cat_slug']))
           {
            $slug = $eventData[0]['cat_slug'];
           }
           else 
           {
               $slug = '';
           }

           $footer_cat = Category::where('status', '1')
           ->whereNull('deleted_at')
           ->where('status', '1')
           ->get();
              

            $sideeventData = Event::select('event_categories.id', 'event_categories.name as cat_name','event_categories.slug as cat_slug','event_categories.status','events.category_id','events.title','events.slug','events.image','events.sort_description','events.sort_order','events.created_at')
                ->leftJoin('event_categories', 'events.category_id', '=', 'event_categories.id')
                ->where('event_categories.status', '1')
                // ->orderBy('events.sort_order', 'desc')
                ->inRandomOrder()
                ->limit(5)
                ->get();
        
        return view('frontend.eventdetails', compact('title','footer_cat','slug','eventData','eventcatData','sideeventData'));
    }

}
