<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';
    protected $primaryKey = 'id';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['name', 'last_name', 'dni', 'phone', 'email', 'status'];

    public static function getAllStudents($request){
        $query = Student::select(
            DB::raw('row_number() OVER (ORDER BY name asc) AS nro'),
            'id',
            'name',
            'last_name',
            'dni',
            'phone',
            'email',
            'status'
        );

        if ($request->start <> "") $query = $query->skip($request->start);
        if ($request->length <> "") $query = $query->take($request->length);

        return $query;
    }

    public static function countAllStudents(){
        return Student::all()->count();
    }

    public function contributions(){
        return $this->hasMany(Contribution::class);
    }
}

