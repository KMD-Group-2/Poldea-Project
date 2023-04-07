<?php

namespace App\Http\Controllers;

use App\Http\Requests\Staff\StoreStaffRequest;
use App\Http\Requests\Staff\UpdateStaffRequest;
use App\Models\Department;
use App\Models\Idea;
use App\Models\Position;
use App\Models\Staff;
use App\Traits\FilterHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    use FilterHandler;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin', ['only' => ['index','store','update','destroy','massDestroy']]);
        $this->middleware('role:QA Coordinator', ['only' => ['StaffList']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffs = Staff::with(['department','position'])->paginate(10);

        $departments = Department::select('id','name')->get();
        $positions = Position::select('id','name')->get();

        return view('pages.staffs.index',compact('staffs','departments','positions'));
    }

    public function StaffList()
    {
        $qa_coordinator = Auth::user()->staff;

        $staffs = Staff::where('department_id',$qa_coordinator->department_id)->with(['department','position'])->paginate(10);

        return view('pages.staffs.qa_c_staff_list',compact('staffs'));
    }

    public function StaffIdeaList(Staff $staff, Request $request)
    {
        $ideas = Idea::IdeaWithFilter(null,null,$request['sort_by'],$staff->users()->pluck('id')->toArray())->paginate(5);

        $filterArray = $this->FilterURL();

        return view('pages.staffs.qa_c_staff_idea_list',compact('ideas','filterArray'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStaffRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStaffRequest $request)
    {
        Staff::create($request->validated());

        return response()->json(['success' => 'Succesfully Added']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStaffRequest  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStaffRequest $request, Staff $staff)
    {
        $staff->update($request->validated());

        return response()->json(['success' => 'Succesfully Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();

        return response()->json(['success' => 'Succesfully Deleted']);
    }

    public function massDestroy(Request $request)
    {
        Staff::whereIn('id',$request->ids)->delete();

        return response()->json(['success' => 'Succesfully Deleted']);
    }
}
