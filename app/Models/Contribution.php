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
    protected $fillable = ['student_id', 'category_id', 'period_received_id','period_affected_id', 'amount', 'description', 'contribution_date', 'status'];


    public static function getAllContributions($request){
        $query = Contribution::with(
            ['student' => function ($query) {$query->where('status', true);}],
            ['category' => function ($query) {$query->where('status', true);}],
            ['period' => function ($query) {$query->where('status', true);}]
        )->select(
            DB::raw('row_number() OVER (ORDER BY contribution_date asc) AS nro'),
            'contributions.id',
            'student_id',
            'category_id',
            'amount',
            'contributions.description',
            'period_received_id',
            'period_affected_id',
            'contribution_date',
            'periods_affected.description as period_affected',
            'periods_received.description as period_received',
        )
        ->join('periods as periods_affected', 'periods_affected.id', 'period_affected_id')
        ->join('periods as periods_received', 'periods_received.id', 'period_received_id');

        if ($request->start <> "") $query = $query->skip($request->start);
        if ($request->length <> "") $query = $query->take($request->length);

        return $query;
    }

    public static function countAllContributions(){
        $query = Contribution::with(
            ['student' => function ($query) {$query->where('status', true);}],
            ['category' => function ($query) {$query->where('status', true);}],
            ['period' => function ($query) {$query->where('status', true);}]
        )->count();

        return $query;
    }

    public static function totalAmounPerPeriod($request){
        $query = Contribution::select(
            DB::raw('row_number() OVER (ORDER BY periods.id asc) AS nro'),
            'periods.description',
            DB::raw('SUM(amount) as total_amount')
        )
            ->join('periods', 'periods.id', 'contributions.period_affected_id')
            ->groupBy('periods.id');

        if ($request->start <> "") $query = $query->skip($request->start);
        if ($request->length <> "") $query = $query->take($request->length);

        return $query;
    }

    public static function totalAmounPerPeriodCount(){
        return Contribution::select(
            DB::raw('row_number() OVER (ORDER BY periods.id asc) AS nro'),
            'periods.description',
            DB::raw('SUM(amount) as total_amount')
        )
            ->join('periods', 'periods.id', 'contributions.period_affected_id')
            ->groupBy('periods.id')->get()->count();
    }

    public static function totalAmounPerPerStudentPeriod($request){

        $query = Contribution::select(
            DB::raw('row_number() OVER (ORDER BY periods.description asc) AS nro'),
            DB::raw('array_to_string(ARRAY[students.name, students.last_name], \' \'::text) AS student_full_name'),
            'periods.description as period',
            DB::raw('SUM(amount) as total_amount_student')
        )
            ->join('periods', 'periods.id', 'contributions.period_affected_id')
            ->join('students', 'students.id', 'contributions.student_id')
            ->groupBy('periods.id','students.id')
            ->orderBy('periods.description', 'ASC');

        if ($request->start <> "") $query = $query->skip($request->start);
        if ($request->length <> "") $query = $query->take($request->length);

        return $query;
    }

    public static function totalAmounPerPerStudentPeriodCount()
    {
        return Contribution::select(
            DB::raw('row_number() OVER (ORDER BY periods.description asc) AS nro'),
            DB::raw('array_to_string(ARRAY[students.name, students.last_name], \' \'::text) AS student_full_name'),
            'periods.description as period',
            DB::raw('SUM(amount) as total_amount_student')
        )
            ->join('periods', 'periods.id', 'contributions.period_affected_id')
            ->join('students', 'students.id', 'contributions.student_id')
            ->groupBy('periods.id', 'students.id')
            ->orderBy('periods.description', 'ASC')->get()->count();
    }

    public static function totalAmountReceivedPerPeriodReceived($request){
        $query = Contribution::select(
            DB::raw('row_number() OVER (ORDER BY periods.id asc) AS nro'),
            'periods.description',
            DB::raw('SUM(amount) as total_amount')
        )
            ->join('periods', 'periods.id', 'contributions.period_received_id')
            ->groupBy('periods.id');

        if ($request->start <> "") $query = $query->skip($request->start);
        if ($request->length <> "") $query = $query->take($request->length);

        return $query;
    }

    public static function totalAmountReceivedPerPeriodReceivedCount(){
        return Contribution::select(
            DB::raw('row_number() OVER (ORDER BY periods.id asc) AS nro'),
            'periods.description',
            DB::raw('SUM(amount) as total_amount')
        )
            ->join('periods', 'periods.id', 'contributions.period_received_id')
            ->groupBy('periods.id')->get()->count();
    }

    public static function exportAllContributions($period_id){
        // return Contribution::select(
        //     'contributions.contribution_date as dia_aporte',
        //     DB::raw('CONCAT(students.name, \' \',students.last_name) AS estudiante_nombre'),
        //     'categories.description as categoria',
        //     'contributions.amount as monto',
        //     'contributions.description as descripcion_aporte',
        //     'periods.description as periodo',
        // )->join('students', 'student_id', 'students.id')
        // ->join('categories', 'category_id', 'categories.id')
        // ->join('periods', 'period_id', 'periods.id')
        // ->orderBy('contribution_date')
        // ->get();
        return Contribution::with(['student'],['category'])->select(
            'contributions.id',
            'contributions.student_id',
            'contributions.category_id',
            'contributions.amount',
            'contributions.bs_amount',
            'contributions.description',
            'period_affected_id',
            'contributions.contribution_date',
            'periods_affected.description as period_affected',
        )->join('periods as periods_affected', 'periods_affected.id', 'period_affected_id')
        ->where('period_affected_id', $period_id)
        ->orderBy('contribution_date')
        ->orderBy('contributions.category_id')
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
