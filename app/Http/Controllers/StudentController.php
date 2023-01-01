<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('students.index');
    }

    public function list(Request $request)
    {
        $draw = $request->draw;
        $data = Student::getAllStudents($request)->get();
        $totalRecords = Student::countAllStudents();
        $datas = [];
        foreach ($data as $key => $value) {
            $checked = $value->status == true ? 'checked' : '';
            $btn_status = "<div class='text-center'><input id=\"statusCheck{$value->id}\" data-size=\"xs\" type=\"checkbox\" {$checked} data-toggle=\"toggle\" data-width=\"50\" data-on=\"<i class='fas fa-check'></i>\" data-off=\"<i class='fas fa-times'></i>\" data-onstyle=\"primary\" data-offstyle=\"danger\"></div>";

            $datas[] = [
                'nro' => $value->nro,
                'name' => $value->name,
                'last_name' => $value->last_name,
                'dni' => $value->dni,
                'phone' => $value->phone,
                'email' => $value->email,
                'status' => $btn_status,
                'actions' => $this->getAction('students', $value->id)
            ];
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $datas
        );

        return json_encode($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $method = $this->method($request->route()->getName());
        return view('students.form', compact('method'));
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        try {
            Student::updateOrCreate(
                ['email' => $request->input('email')],
                [
                    'name' => $request->input('name'),
                    'last_name' => !is_null($request->input('last_name')) ? $request->input('last_name') : 'NA',
                    'dni' => !is_null($request->input('dni')) ? $request->input('dni') : 'NA',
                    'phone' => !is_null($request->input('phone')) ? $request->input('phone') : 'NA',
                    'status' => true
                ]
            );
            DB::commit();
            return redirect()->route('students.index');
        } catch (\Throwable $th) {
            DB::rollback();
            $this->handleExceptionLog('StudentsController.store', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $method = $this->method($request->route()->getName());
        $student = Student::where('id', $id)->first();
        return view('students.form', compact('student', 'method'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $method = $this->method($request->route()->getName());
        $student = Student::where('id', $id)->first();
        return view('students.form', compact('student', 'method'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            Student::updateOrCreate(
                ['email' => $request->input('email')],
                [
                    'name' => $request->input('name'),
                    'last_name' => !is_null($request->input('last_name')) ? $request->input('last_name') : 'NA',
                    'dni' => !is_null($request->input('dni')) ? $request->input('dni') : 'NA',
                    'phone' => !is_null($request->input('phone')) ? $request->input('phone') : 'NA',
                    'status' => true
                ]
            );
            DB::commit();
            return redirect()->route('students.index');
        } catch (\Throwable $th) {
            DB::rollback();
            $this->handleExceptionLog('StudentsController.update', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Funcion cambio de estatus del estudiante
     */
    public function changeStatus(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            Student::where('id', $id)->update(['status' => $request->input('status')]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            $this->handleExceptionLog('StudentsController.changeStatus', $th->getMessage());
        }
    }
}