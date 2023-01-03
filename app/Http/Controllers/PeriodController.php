<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeriodRequest;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('periods.index');
    }

    public function list(Request $request)
    {
        $draw = $request->draw;
        $data = Period::getAllPeriods($request)->get();
        $totalRecords = Period::countAllPeriods();
        $datas = [];
        foreach ($data as $key => $value) {
            $datas[] = [
                'nro' => $value->nro,
                'description' => $value->description,
                'actions' => $this->getAction('periods', $value->id)
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
        return view('periods.form', compact('method'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PeriodRequest $request)
    {
        try {
            Period::updateOrCreate(['description' => $request->input('description')], ['status' => true]);
            DB::commit();
            return redirect()->route('periods.index');
        } catch (\Throwable $th) {
            DB::rollback();
            $this->handleExceptionLog('PeriodController.store', $th->getMessage());
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
        $period = Period::where('id', $id)->first();
        return view('periods.form', compact('period', 'method'));
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
        $period = Period::where('id', $id)->first();
        return view('periods.form', compact('period', 'method'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PeriodRequest $request, $id)
    {
        try {
            Period::where('id', $id)->update(['description' => $request->input('description')], ['status' => true]);
            DB::commit();
            return redirect()->route('periods.index');
        } catch (\Throwable $th) {
            DB::rollback();
            $this->handleExceptionLog('PeriodController.update', $th->getMessage());
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

    public function getPeriods()
    {
        $periods = Period::where('status', true)->orderBy('id', 'desc')->get();
        $response = [
            'code' => 3,
            'type' => 'success',
            'data' => $periods
        ];
        return response()->json($response);
    }
}