<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index');
    }

    public function list(Request $request)
    {
        $draw = $request->draw;
        $data = Category::getAllCategories($request)->get();
        $totalRecords = Category::countAllCategories();
        $datas = [];
        foreach ($data as $key => $value) {
            $checked = $value->status == true ? 'checked' : '';
            $btn_status = "<div class='text-center'><input id=\"statusCheck{$value->id}\" data-size=\"xs\" type=\"checkbox\" {$checked} data-toggle=\"toggle\" data-width=\"50\" data-on=\"<i class='fas fa-check'></i>\" data-off=\"<i class='fas fa-times'></i>\" data-onstyle=\"primary\" data-offstyle=\"danger\"></div>";

            $datas[] = [
                'nro' => $value->nro,
                'description' => $value->description,
                'status' => $btn_status,
                'actions' => $this->getAction('categories', $value->id)
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
        return view('categories.form', compact('method'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            Category::updateOrCreate(['description' => $request->input('description')], ['status' => true]);
            DB::commit();
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            DB::rollback();
            $this->handleExceptionLog('CategoryController.store', $th->getMessage());
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
        $category = Category::where('id', $id)->first();
        return view('categories.form', compact('category', 'method'));
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
        $category = Category::where('id', $id)->first();
        return view('categories.form', compact('category', 'method'));
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
            Category::where('id', $id)->update(['description' => $request->input('description')], ['status' => true]);
            DB::commit();
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            DB::rollback();
            $this->handleExceptionLog('CategoryController.update', $th->getMessage());
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
     * Funcion cambio de estatus de la categoria
     */
    public function changeStatus(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            Category::where('id', $id)->update(['status' => $request->input('status')]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            $this->handleExceptionLog('CategoryController.changeStatus', $th->getMessage());
        }
    }
}