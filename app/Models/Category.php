<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['description', 'status'];

    public static function getAllCategories($request){
        $query = Category::select(
            DB::raw('row_number() OVER (ORDER BY description asc) AS nro'),
            'id',
            'description',
            'status'
        );

        if ($request->start <> "") $query = $query->skip($request->start);
        if ($request->length <> "") $query = $query->take($request->length);

        return $query;
    }

    public static function countAllCategories(){
        return Category::all()->count();
    }
}