<?php

namespace App\Http\Controllers;

use App\Exports\ContributionExport;
use App\Http\Requests\ContributionRequest;
use App\Models\Category;
use App\Models\Contribution;
use App\Models\Period;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ContributionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contributions.index');
    }

    public function list(Request $request)
    {
        $draw = $request->draw;
        $data = Contribution::getAllContributions($request)->get();
        $totalRecords = Contribution::countAllContributions();
        $datas = [];
        foreach ($data as $key => $value) {
            $datas[] = [
                'nro' => $value->nro,
                'contribution_date' => $value->contribution_date,
                'period_received' => $value->period_received,
                'student' => $value->student->name . ' ' . $value->student->last_name,
                'category' => $value->category->description,
                'amount' => $value->amount,
                'period_affected' => $value->period_affected,
                'description' => substr($value->description, 0, 35) . '...',
                'actions' => $this->getAction('contributions', $value->id)
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

    public function contributionsPerPeriodsList(Request $request)
    {
        $draw = $request->draw;
        $data = Contribution::totalAmounPerPeriod($request)->get();
        $totalRecords = Contribution::totalAmounPerPeriodCount();
        $datas = [];
        foreach ($data as $key => $value) {
            $datas[] = [
                'nro' => $value->nro,
                'description' => $value->description,
                'total_amount' => $value->total_amount,
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

    public function contributionsPerStudentPerPeriodsList(Request $request)
    {
        $draw = $request->draw;
        $data = Contribution::totalAmounPerPerStudentPeriod($request)->get();
        $totalRecords = Contribution::totalAmounPerPerStudentPeriodCount();
        $datas = [];
        foreach ($data as $key => $value) {
            $datas[] = [
                'nro' => $value->nro,
                'student_full_name' => $value->student_full_name,
                'period' => $value->period,
                'total_amount_student' => $value->total_amount_student,
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

    public function contributionsPerPeriodsReceivedList(Request $request)
    {
        $draw = $request->draw;
        $data = Contribution::totalAmountReceivedPerPeriodReceived($request)->get();
        $totalRecords = Contribution::totalAmountReceivedPerPeriodReceivedCount();
        $datas = [];
        foreach ($data as $key => $value) {
            $datas[] = [
                'nro' => $value->nro,
                'description' => $value->description,
                'total_amount' => $value->total_amount,
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
        $students = Student::where('status', true)->get();
        $categories = Category::where('status', true)->get();
        $periods = Period::where('status', true)->get();
        return view('contributions.form', compact('method', 'students', 'categories', 'periods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContributionRequest $request)
    {
        try {
            Contribution::create([
                'student_id' => $request->input('students'),
                'category_id' => $request->input('categories'),
                'period_affected_id' => $request->input('periods_affected'),
                'period_received_id' => $request->input('periods_received'),
                'amount' => $request->input('amount'),
                'bs_amount' => $request->input('bs_amount'),
                'description' => $request->input('description'),
                'contribution_date' => $request->input('contribution_date')
            ]);
            DB::commit();
            return redirect()->route('contributions.index');
        } catch (\Throwable $th) {
            DB::rollback();
            $this->handleExceptionLog('ContributionController.store', $th->getMessage());
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
        $contribution = Contribution::with(['student' => function ($query) {$query->where('status', true);}],[ 'category' => function ($query) {$query->where('status', true);}])
        ->select('periods_affected.description as periods_affected', 'periods_received.description as periods_received', 'student_id', 'category_id', 'amount', 'bs_amount','contributions.description', 'contributions.id', 'contribution_date')
        ->join('periods as periods_affected', 'periods_affected.id', 'period_affected_id')
        ->join('periods as periods_received', 'periods_received.id', 'period_received_id')
        ->where('contributions.id', $id)->first();
        return view('contributions.form', compact('method', 'contribution'));
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
        $contribution = Contribution::where('id', $id)->first();
        $students = Student::where('status', true)->get();
        $categories = Category::where('status', true)->get();
        $periods = Period::where('status', true)->get();
        return view('contributions.form', compact('method', 'students', 'categories', 'periods', 'contribution'));
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
            Contribution::where('id', $id)->update([
                'student_id' => $request->input('students'),
                'category_id' => $request->input('categories'),
                'period_affected_id' => $request->input('periods_affected'),
                'period_received_id' => $request->input('periods_received'),
                'amount' => $request->input('amount'),
                'bs_amount' => $request->input('bs_amount'),
                'description' => $request->input('description'),
                'contribution_date' => $request->input('contribution_date')
            ]);
            DB::commit();
            return redirect()->route('contributions.index');
        } catch (\Throwable $th) {
            DB::rollback();
            $this->handleExceptionLog('ContributionController.store', $th->getMessage());
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

    public function export(Request $request)
    {
        $period_id = $request->input('periods');
        return Excel::download(new ContributionExport($period_id), 'aportes.xlsx');
    }
}