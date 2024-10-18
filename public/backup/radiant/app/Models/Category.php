<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Category extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'parent_id', 'description', 'meta_title', 'meta_keyword', 'meta_keyword', 'is_feature', 'image', 'sort_order', 'status',
    ];

    protected $dates = ['deleted_at'];

    public function getparentCat($mode = 0)
    {

        $records = DB::select('SELECT c1.id,
                case WHEN c1.parent_id!=0 THEN c3.name ELSE "" END as main_id,
                case WHEN c2.parent_id=0 THEN c2.name ELSE
                case WHEN c1.parent_id!=0 THEN c2.name ELSE "" END END as parent_id,
                c1.name FROM categories c1
                LEFT JOIN categories c2 ON (c1.parent_id = c2.id AND c2.deleted_at IS NULL)
                LEFT JOIN categories c3 ON (c2.parent_id = c3.id AND c3.deleted_at IS NULL)
                where c1.status=1 AND  c1.deleted_at IS NULL order by c3.name, c2.name, c1.name');

        $newRecord = [];
        foreach ($records as $key => $row) {
            if ($mode == 0) {
                if (empty($row->main_id)) {
                    $catName = '';
                    if ($row->main_id) {$catName = $row->main_id . ' >> ';}
                    if ($row->parent_id) {$catName .= $row->parent_id . ' >> ';}
                    if ($row->name) {$catName .= $row->name;}
                    $newRecord[$key]['id'] = $row->id;
                    $newRecord[$key]['name'] = $catName;
                }
            } else {
                $catName = '';
                if ($row->main_id) {$catName = $row->main_id . ' >> ';}
                if ($row->parent_id) {$catName .= $row->parent_id . ' >> ';}
                if ($row->name) {$catName .= $row->name;}
                $newRecord[$key]['id'] = $row->id;
                $newRecord[$key]['name'] = $catName;
            }
        }

        return $newRecord;
    }

    public function childs()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    public function getCategories($parentId = 0, $level = 1)
    {
        $categories = DB::table('categories')
        ->select('id', 'name', 'slug', 'parent_id')
        ->where('parent_id', $parentId)
        ->where(['status' => 1])
        ->whereNull('deleted_at')
        ->get()
        ->toArray();

        $result = [];

        foreach ($categories as $category) {
            $category->level = $level;
            $category->children = $this->getCategories($category->id, $level + 1);
            $result[] = $category;
        }

        return $result;
    }

}
