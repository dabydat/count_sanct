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
    protected $fillable = ['student_id', 'category_id', 'period_id', 'amount', 'description', 'contribution_date', 'status'];


    public static function getAllContributions($request){
        $query = Contribution::with(
            ['student' => function ($query) {$query->where('status', true);}],
            ['category' => function ($query) {$query->where('status', true);}],
            ['period' => function ($query) {$query->where('status', true);}]
        )->select(
            DB::raw('row_number() OVER (ORDER BY contribution_date asc) AS nro'),
            'id',
            'student_id',
            'category_id',
            'amount',
            'description',
            'period_id',
            'contribution_date'
        );

        // $query = $query->orderBy('contribution_date', 'asc')->orderBy('period_id', 'desc');

        if ($request->start <> "") $query = $query->skip($request->start);
        if ($request->length <> "") $query = $query->take($request->length);

        return $query;
    }

    public static function countAllContributions(){
        $query = Contribution::with(
            ['student' => function ($query) {$query->where('status', true);}],
            ['category' => function ($query) {$query->where('status', true);}],
            ['period' => function ($query) {$query->where('status', true);}]
        )->select('*')->count();

        return $query;
    }

    public static function totalAmounPerPeriod($request){
        $query = Contribution::select(
            DB::raw('row_number() OVER (ORDER BY periods.id asc) AS nro'),
            'periods.description',
            DB::raw('SUM(amount) as total_amount')
        )
            ->join('periods', 'periods.id', 'contributions.period_id')
            ->groupBy('periods.id');

        if ($request->start <> "") $query = $query->skip($request->start);
        if ($request->length <> "") $query = $query->take($request->length);

        return $query;
    }

    public static function exportAllContributions(){
        return Contribution::select(
            'contributions.contribution_date as dia_aporte',
            DB::raw('CONCAT(students.name, \' \',students.last_name) AS estudiante_nombre'),
            'categories.description as categoria',
            'contributions.amount as monto',
            'contributions.description as descripcion_aporte',
            'periods.description as periodo',
        )->join('students', 'student_id', 'students.id')
        ->join('categories', 'category_id', 'categories.id')
        ->join('periods', 'period_id', 'periods.id')
        ->orderBy('contribution_date')
        ->get();
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
