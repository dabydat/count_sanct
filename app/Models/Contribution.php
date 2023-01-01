<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contribution extends Model
{
    use HasFactory;
    protected $table = 'contributions';
    protected $primaryKey = 'id';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['student_id', 'category_id', 'period_id', 'amount', 'description', 'status'];


    public static function getAllContributions($request){
        $query = Contribution::with(
            ['student' => function ($query) {$query->where('status', true);}],
            ['category' => function ($query) {$query->where('status', true);}],
            ['period' => function ($query) {$query->where('status', true);}]
        )->select(
            DB::raw('row_number() OVER (ORDER BY period_id asc) AS nro'),
            'id',
            'student_id',
            'category_id',
            'amount',
            'description',
            'period_id',
            'contribution_date'
        );

        if ($request->start <> "") $query = $query->skip($request->start);
        if ($request->length <> "") $query = $query->take($request->length);

        return $query;
    }

    public static function countAllContributions(){
        $query = Contribution::with(
            ['student' => function ($query) {$query->where('status', true);}],
            ['category' => function ($query) {$query->where('status', true);}],
            ['period' => function ($query) {$query->where('status', true);}]
        )->select(
                DB::raw('row_number() OVER (ORDER BY id asc) AS nro'),
                'id',
                'student_id',
                'category_id',
                'amount',
                'description',
                'period_id',
                'contribution_date'
            )->count();

        return $query;
    }

    public function student(){
        return $this->belongsTo(Student::class)->where('status', true);
    }

    public function category(){
        return $this->belongsTo(Category::class)->where('status', true);
    }

    public function period(){
        return $this->belongsTo(Period::class)->where('status', true);
    }
}
