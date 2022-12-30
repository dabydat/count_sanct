<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
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

    public function list(Request $request){
        $draw = $request->draw;
        $data = Student::getAllStudents($request)->get();
        $totalRecords = Student::countAllStudents();
        $datas = [];
        foreach ($data as $key => $value) {
            $status = $value->status == true ? 'Activado' : 'Desactivado';
            $datas[] = [
                'nro' => $value->nro,
                'name' => $value->name,
                'last_name' => $value->last_name,
                'dni' => $value->dni,
                'phone' => $value->phone,
                'email' => $value->email,
                'status' => $status,
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

    public function getAction($route, $id){
        $actions = "<a class='btn btn-outline-primary btn-sm mr-2' href='" . route($route . '.show', $id) . "' title='Ver'><i class='fa fa-eye'></i></a>";
        $actions .= "<a class='btn btn-outline-primary btn-sm' href='" . route($route . '.edit', $id) . "' title='Editar'><i class='fa fa-edit'></i></a>";
        return "<div class='text-center d-flex justify-content-around'>" . $actions . "</div>";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('students.create-edit');
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
        dd($request);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('students.create-edit');
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('students.create-edit');
        //
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
        //
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
}
