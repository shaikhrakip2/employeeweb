<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    public function index(Request $request)
    {

        $title = 'Faq';
        $cmsfaq = Cms::where('id', '7')->where('status', 1)->first();

        DB::statement("SET SQL_MODE = ''");
        $faqData = Faq::select('faq_categories.id', 'faq_categories.name as cat_name', 'faq_categories.slug as cat_slug', 'faq_categories.status', 'faqs.faq_category_id', 'faqs.question', 'faqs.answer', 'faqs.slug', 'faqs.sort_order', 'faqs.created_at')
            ->leftJoin('faq_categories', 'faqs.faq_category_id', '=', 'faq_categories.id')
            ->where('faq_categories.status', '1')
            ->where('faqs.status', '1')
            ->paginate(8);

        $faqcatData = FaqCategory::where('status', '1')
            ->orderBy('id', 'asc')
            ->get();

        $sidefaqData = Faq::select('faq_categories.id', 'faq_categories.name as cat_name', 'faq_categories.slug as cat_slug', 'faq_categories.status', 'faqs.faq_category_id', 'faqs.question', 'faqs.answer', 'faqs.slug', 'faqs.sort_order', 'faqs.created_at')
            ->leftJoin('faq_categories', 'faqs.faq_category_id', '=', 'faq_categories.id')
            ->where('faq_categories.status', '1')
            ->where('faqs.status', '1')
            ->inRandomOrder()
            ->limit(5)
            ->get();

        return view('frontend.faq', compact('title', 'faqData', 'faqcatData', 'sidefaqData', 'cmsfaq'));
    }
}
