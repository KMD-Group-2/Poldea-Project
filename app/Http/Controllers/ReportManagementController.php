<?php

namespace App\Http\Controllers;

use App\Exports\ExportAcademicYear;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\AcademicYear;
use App\Models\Category;
use App\Models\Idea;
use App\Traits\FileHandler;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Image;

class ReportManagementController extends Controller
{
    use FileHandler;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin', ['only' => ['adminReport']]);
        $this->middleware('role:QA Manager', ['only' => ['qaManagerReport','ReportExport']]);
        $this->middleware('role:QA Coordinator', ['only' => ['qaCoordinatorReport']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIdeaReport(Request $request)
    {
        $last_academic_year = AcademicYear::whereDate('final_closure_date', '>=', Carbon::now())->latest()->first();
        // Report Data
        $ideas = Idea::IdeaReportWithFilter($last_academic_year, $request->all());

        // For Selection
        $academic_years = AcademicYear::select('id', 'academic_year', 'final_closure_date')->get();

        $categories = Category::select('id', 'name')->get();
        $departments = Department::select('id', 'name')->get();

        // For Plugins
        view()->share([
            'select2' => true,
            'daterangepicker' => true,
        ]);

        return view('pages.reports.report', compact('ideas', 'academic_years', 'categories', 'departments','last_academic_year'));
    }

    public function qaManagerReport(Request $request)
    {
        $last_academic_year = AcademicYear::whereDate('final_closure_date', '>=', Carbon::now())->latest()->first();
        // Report Data
        $ideas = Idea::IdeaReportWithFilter($last_academic_year, $request->all());

        // For Selection
        $academic_years = AcademicYear::select('id', 'academic_year', 'final_closure_date')->get();

        $categories = Category::select('id', 'name')->get();
        $departments = Department::select('id', 'name')->get();

        // For Plugins
        view()->share([
            'select2' => true,
            'daterangepicker' => true,
        ]);

        return view('pages.reports.report', compact('ideas', 'academic_years', 'categories', 'departments','last_academic_year'));
    }

    public function qaCoordinatorReport(Request $request)
    {
        $qa_c = Auth::user()->staff;

        $last_academic_year = AcademicYear::whereDate('final_closure_date', '>=', Carbon::now())->latest()->first();

        // Report Data
        $ideas = Idea::IdeaReportWithFilter($last_academic_year,$request->all(),$qa_c->department_id);

        // For Selection
        $academic_years = AcademicYear::select('id', 'academic_year', 'final_closure_date')->get();
        $categories = Category::select('id', 'name')->get();

        // For Plugins
        view()->share([
            'select2' => true,
            'daterangepicker' => true,
        ]);

        return view('pages.reports.report', compact('ideas', 'academic_years', 'categories','last_academic_year'));
    }

    public function ReportExport(Request $request)
    {
        $academic_year = AcademicYear::findOrFail($request->academic_year_id);

        if(now()->diffInDays(Carbon::parse($academic_year->final_closure_date), false) < 0) {
            return Excel::download(new ExportAcademicYear($academic_year->id), $academic_year->academic_year . '_' . date('d_m_Y') . '_' . time() . '.csv');
        }

        return abort(404);
    }

    public function ZipExport(Request $request)
    {
        $idea = Idea::findOrFail($request->idea_id);

        if($idea->documents->count() > 0) {
            $fileName = $idea->academic_year->academic_year . '_' . str_replace(array('\\','/',':','*','?','"','<','>','|',' ','@','#','$','%','^','&','*'),'',$idea->title) . '.zip'; // Name of our archive to download

            $path = public_path() . '/upload/export.zip';

            File::put($path,'');

            // Initializing PHP class
            $zip = new ZipArchive();

            if($zip->open($path, ZipArchive::CREATE) === TRUE) {

                foreach($idea->documents as $value) {
                    $file_exist = File::exists(public_path() . $value->file_path);

                    if($file_exist) {
                        $file = public_path() . $value->file_path;

                        $relativeNameInZipFile = $value->file_name . '.' . $value->type;

                        $zip->addFile($file, $relativeNameInZipFile);
                    }
                }

                $zip->close();
            }

            // We return the file immediately after download
            return Response::download($path, $fileName, ['Content-Type: application/zip'])->deleteFileAfterSend(true);
        }

        return abort(404);
    }
}
