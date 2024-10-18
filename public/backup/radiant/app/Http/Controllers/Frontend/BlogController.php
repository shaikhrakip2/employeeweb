<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index(Request $request)
    {
      
        $title = 'Blogs';

            DB::statement("SET SQL_MODE = ''");
            $blogData = Blog::select('blog_categories.id', 'blog_categories.name as cat_name','blog_categories.slug as cat_slug','blog_categories.status','blogs.category_id','blogs.title','blogs.slug','blogs.image','blogs.sort_description','blogs.post_by','blogs.sort_order','blogs.created_at')
                 ->leftJoin('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
                 ->where('blog_categories.status', '1')
                 ->where('blogs.status', '1')
                 ->orderBy('blogs.sort_order', 'desc')
                 ->paginate(8);

            $blogcatData = BlogCategory::where('status','1')
                ->orderBy('id', 'asc')
                ->get();
            
            $sideblogData = Blog::select('blog_categories.id', 'blog_categories.name as cat_name','blog_categories.slug as cat_slug','blog_categories.status','blogs.category_id','blogs.title','blogs.slug','blogs.image','blogs.sort_description','blogs.post_by','blogs.sort_order','blogs.created_at')
                ->leftJoin('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
                ->where('blog_categories.status', '1')
                ->where('blogs.status', '1')
                ->inRandomOrder()
                ->limit(5)
                ->get();

                $footer_cat = Category::where('status', '1')
                ->whereNull('deleted_at')
                ->where('status', '1')
                ->get();

        return view('frontend.blogs', compact('title','blogData','footer_cat','blogcatData','sideblogData'));
    }


    public function categoryblogs(Request $request,$catblogslug)
    {
        
        $title = 'Blogs';

            DB::statement("SET SQL_MODE = ''");
            $blogData = Blog::select('blog_categories.id', 'blog_categories.name as cat_name','blog_categories.slug as cat_slug','blog_categories.status','blogs.category_id','blogs.title','blogs.slug','blogs.image','blogs.sort_description','blogs.post_by','blogs.sort_order','blogs.created_at')
                 ->leftJoin('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
                 ->where('blog_categories.slug', $catblogslug)
                 ->where('blog_categories.status', '1')
                 ->orderBy('blogs.sort_order', 'desc')
                 ->paginate(8);
            // dd($blogData);
            
            $blogcatData = BlogCategory::where('status','1')
                ->orderBy('id', 'asc')
                ->get();

            $sideblogData = Blog::select('blog_categories.id', 'blog_categories.name as cat_name','blog_categories.slug as cat_slug','blog_categories.status','blogs.category_id','blogs.title','blogs.slug','blogs.image','blogs.sort_description','blogs.post_by','blogs.sort_order','blogs.created_at')
                ->leftJoin('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
                ->where('blog_categories.status', '1')
                // ->orderBy('blogs.sort_order', 'desc')
                ->inRandomOrder()
                ->limit(5)
                ->get();

                $footer_cat = Category::where('status', '1')
                ->whereNull('deleted_at')
                ->where('status', '1')
                ->get();

                $slug = $catblogslug;
           
        // $title = $blogData->isNotEmpty() ? $blogData->first()->cat_name : null;

        return view('frontend.catblogs', compact('title','slug','footer_cat','blogData','blogcatData','sideblogData'));
    }
   

    public function blogdetails(Request $request,$blogslug)
    {
      
        $title = 'Blog Details';

            DB::statement("SET SQL_MODE = ''");
            $blogData = Blog::select('blog_categories.id','blogs.meta_title','blogs.meta_keyword', 'blogs.meta_description','blog_categories.name as cat_name','blog_categories.slug as cat_slug','blog_categories.status','blogs.category_id','blogs.title','blogs.slug','blogs.image','blogs.description','blogs.post_by','blogs.sort_order','blogs.created_at')
                 ->leftJoin('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
                 ->where('blogs.slug', $blogslug)
                 ->where('blog_categories.status', '1')
                 ->orderBy('blogs.sort_order', 'desc')
                 ->get();
            // dd($blogData);
            
            $blogcatData = BlogCategory::where('status','1')
                ->orderBy('id', 'asc')
                ->get();

           if(!empty($blogData[0]['cat_slug']))
           {
            $slug = $blogData[0]['cat_slug'];
           }
           else 
           {
               $slug = '';
           }

           $footer_cat = Category::where('status', '1')
           ->whereNull('deleted_at')
           ->where('status', '1')
           ->get();
              

            $sideblogData = Blog::select('blog_categories.id', 'blog_categories.name as cat_name','blog_categories.slug as cat_slug','blog_categories.status','blogs.category_id','blogs.title','blogs.slug','blogs.image','blogs.sort_description','blogs.post_by','blogs.sort_order','blogs.created_at')
                ->leftJoin('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
                ->where('blog_categories.status', '1')
                // ->orderBy('blogs.sort_order', 'desc')
                ->inRandomOrder()
                ->limit(5)
                ->get();


           
        
        return view('frontend.blogdetails', compact('title','footer_cat','slug','blogData','blogcatData','sideblogData'));
    }

}
