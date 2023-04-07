<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcademicYear\StoreAcademicYearRequest;
use App\Http\Requests\AcademicYear\UpdateAcademicYearRequest;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AcademicYearController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin')->except('index');
        $this->middleware('role:Admin|QA Manager', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $years = DB::table('academic_years')
            ->select(
                'academic_years.id',
                'academic_years.academic_year',
                'academic_years.closure_date',
                'academic_years.final_closure_date',
                'ideas_total.total_category',
                'ideas_total.total_participants',
                'ideas_total.total_post'
            )
            ->leftJoin(DB::raw(
                '(SELECT academic_year_id, COUNT(DISTINCT category_id) AS total_category, COUNT(DISTINCT user_id) as total_participants, COUNT(id) AS total_post FROM ideas GROUP BY academic_year_id) AS ideas_total'
            ), 'academic_years.id', '=', 'ideas_total.academic_year_id')
            ->paginate(10);

        view()->share(['datepicker' => true]);
        return view('pages.academic-years.index', compact('years'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAcademicYearRequest $request)
    {
        AcademicYear::create($request->validated());

        return response()->json(['success' => 'Succesfully Added']);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAcademicYearRequest $request, AcademicYear $academic_year)
    {
        $academic_year->update($request->validated());

        return response()->json(['success' => 'Succesfully Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AcademicYear $academic_year)
    {
        $academic_year->delete();

        return response()->json(['success' => 'Succesfully Deleted']);
    }
}
