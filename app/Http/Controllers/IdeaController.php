<?php

namespace App\Http\Controllers;

use App\Http\Requests\Idea\StoreIdeaPublishRequest;
use App\Http\Requests\Idea\StoreInfoRequest;
use App\Http\Requests\Idea\StoreUploadFileRequest;
use App\Jobs\SendCommentSubmittedNotification;
use App\Jobs\SendIdeaSubmittedNotification;
use App\Models\AcademicYear;
use App\Models\Category;
use App\Models\Department;
use App\Models\Idea;
use App\Models\IdeaComments;
use App\Models\IdeaDocuments;
use App\Traits\FileHandler;
use App\Traits\FilterHandler;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class IdeaController extends Controller
{
    use FileHandler, FilterHandler;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Staff')->except('show');
        $this->middleware('role:Staff|QA Manager|Admin|QA Coordinator')->only('show');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addInformationView(Idea $idea = null)
    {
        if ($idea) {
            if ($idea->posted_at != null || auth()->user()->id != $idea->user_id) {
                return abort(404);
            }
        }

        $categories = Category::select('id', 'name')->get();
        $academicYears = AcademicYear::select('id', 'academic_year')->whereDate('closure_date', '>=', Carbon::now())->get();

        if (count($categories) == 0)
            return redirect()->back()->withErrors(['create-idea' => "There is no category to submit an idea. Please contact system administrator!"]);

        if (count($academicYears) == 0)
            return redirect()->back()->withErrors(['create-idea' => "There is no academic year to submit an idea. Please contact system administrator!"]);
        // plugin ON
        view()->share([
            'steps' => true,
            'htmleditor' => true,
        ]);

        return view('pages.ideas.add-info', compact('categories', 'academicYears', 'idea'));
    }

    public function uploadFilesView(Idea $idea)
    {
        if ($idea->posted_at != null || auth()->user()->id != $idea->user_id) {
            return abort(404);
        }

        view()->share([
            'steps' => true,
            'progressbar' => true,
            'carousel' => true,
            'sweetalert' => true,
            'imagePopup' => true,
        ]);

        return view('pages.ideas.upload-files', compact('idea'));
    }

    public function ideas(Request $request)
    {
        $now = Carbon::now();

        $ideas = Idea::IdeaWithFilter($request->all())->paginate(5);

        $ideas->appends($request->all());

        $academicYears = AcademicYear::select('id', 'academic_year', DB::raw("(if(id=(SELECT MAX(id) FROM academic_years WHERE final_closure_date>='$now'),true,false)) As last"))->whereDate('final_closure_date', '>=', Carbon::now())->get();

        $departments = Department::FilterWithCount($request->all());

        $categories = Category::FilterWithCount($request->all());

        $filterArray = $this->FilterURL($request['a'],$request['c'],$request['d'], $request['page']);

        return view('pages.ideas.ideas', compact('ideas', 'academicYears', 'departments', 'categories', 'filterArray'));
    }

    public function previewIdeaView(Idea $idea)
    {
        if ($idea->posted_at != null || auth()->user()->id != $idea->user_id) {
            return abort(404);
        }

        view()->share([
            'steps' => true,
            'sweetalert' => true,
            'carousel' => true,
            'imagePopup' => true,
        ]);
        return view('pages.ideas.preview-idea', compact('idea'));
    }

    public function publishedIdeaView(Request $request)
    {
        $now = Carbon::now();

        $ideas = Idea::IdeaWithFilter($request->all(), true, Auth::user()->id)->paginate(5);

        $ideas->appends($request->all());
        
        $filterArray = $this->FilterURL(null, null, null, $request['page']);

        return view('pages.ideas.published', compact('ideas', 'filterArray'));
    }

    public function draftIdeaView()
    {
        $user_id = auth()->user()->id;
        $ideas = DB::select("SELECT ideas.*, categories.name AS category, academic_years.academic_year, academic_years.closure_date FROM ideas left join categories on categories.id = ideas.category_id LEFT JOIN academic_years on ideas.academic_year_id = academic_years.id where ideas.posted_at is null and ideas.user_id = $user_id");
        return view('pages.ideas.draft', compact('ideas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeInfo(StoreInfoRequest $request)
    {
        $idea = Idea::updateOrCreate([
            'id' => $request->idea_id ? $request->idea_id : 0,
        ], $request->validated());

        return response()->json(['id' => $idea->id], 200);
    }

    public function uploadFiles(StoreUploadFileRequest $request)
    {
        $OriginalFileName = trim($request->validated()['file']->getClientOriginalName(), '.' . $request->validated()['file']->getClientOriginalExtension());
        $checkFileName = IdeaDocuments::where('file_name', 'LIKE', '%' . $OriginalFileName . '%')->get();

        if ($checkFileName->last()) {
            $ServerFileName = $checkFileName->last()->file_name;
            if ($OriginalFileName == $ServerFileName) {
                $fileName = $OriginalFileName . ' (1)';
            } else {
                preg_match('#\((.*?)\)#', substr($OriginalFileName, -4), $brack);
                if (count($brack) > 0) {
                    preg_match('#\((.*?)\)#', substr($ServerFileName, -4), $match);

                    (int)$match[1]++;
                    $fileName = $OriginalFileName . ' (' . $match[1] . ')';
                } else {
                    $fileName = $OriginalFileName;
                }
            }
        } else {
            $fileName = $OriginalFileName;
        }

        $filePath = $this->uploadFilePath($request->validated()['file'], Auth::user()->username . '_' . Auth::user()->id . '/' . $request->validated()['file']->getClientOriginalExtension());

        $ideaFile = IdeaDocuments::create([
            'type' => $request->validated()['file']->getClientOriginalExtension(),
            'file_path' => $filePath,
            'file_name' => $fileName,
            'idea_id' => $request->validated()['idea_id'],
        ]);
        $ideaFile->carbon_created_at = Carbon::parse($ideaFile->created_at)->format('d M Y, g:i A');

        return response()->json(['file' => $ideaFile], 200);
    }

    public function deleteFile(Request $request)
    {
        if ($request->id) {
            $file = IdeaDocuments::where('id', $request->id)->first();

            if ($file) {
                $this->deleteFilePath($file->file_path);
                $file->delete();

                return response()->json(['file' => 'Successfully Deleted!']);
            } else {
                return response()->json(['file' => 'File Not Found!'], 422);
            }
        } else {
            return response()->json(['file' => 'Invalid Request!'], 422);
        }
    }

    public function publishIdea(StoreIdeaPublishRequest $request)
    {
        $idea = Idea::findOrFail($request->idea_id);

        $idea->update($request->validated());

        $qa_c_emails = [];

        foreach($idea->publisher_department->staffs as $staff) {
            $qa_staff = $staff->users()->whereHas('roles', function($q) {
                $q->where('name', 'QA Coordinator');
            })->count() == 0 ? false : true;

            if($qa_staff) {
                array_push($qa_c_emails,$staff->email);
            }
        }

        try {
            SendIdeaSubmittedNotification::dispatch($qa_c_emails,$idea);
        } catch (\Throwable $th) {

        }

        return response()->json(['success' => 'Successfully Published!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // For carousel Plugin
        view()->share([
            'carousel' => true,
            'imagePopup' => true
        ]);

        $user_id = auth()->user()->id;

        $idea = collect(DB::select("SELECT ideas.*, categories.name AS category, academic_years.closure_date FROM ideas left join categories on categories.id = ideas.category_id LEFT JOIN academic_years on ideas.academic_year_id = academic_years.id   where ideas.id = $id"))->first();

        $staff = collect(DB::select("SELECT staffs.name, staffs.photo FROM users LEFT JOIN staffs ON users.staff_id = staffs.id where users.id = $idea->user_id"))->first();

        $department = collect(DB::select("SELECT `name` FROM departments where departments.id = $idea->publisher_department_id"))->first();

        $like = collect(DB::select("SELECT COALESCE(COUNT(like_unlike), 0) AS like_count FROM idea_like_unlikes where like_unlike = 1 AND idea_id = $idea->id"))->first();

        $unlike = collect(DB::select("SELECT COALESCE(COUNT(like_unlike), 0) AS unlike_count FROM idea_like_unlikes where like_unlike = 0 AND idea_id = $idea->id"))->first();

        $view = collect(DB::select("SELECT COALESCE(COUNT(idea_id), 0) AS view_count FROM idea_views WHERE idea_id = $idea->id"))->first();

        $comment = collect(DB::select("SELECT COALESCE(COUNT(idea_id), 0) AS comment_count FROM idea_comments WHERE idea_id = $idea->id"))->first();

        $comments = $this->getComments(1, $idea->id);

        $images = DB::select("SELECT file_path, file_name FROM idea_documents WHERE idea_id = $idea->id AND (`type` = 'jpg' OR `type` = 'png')");

        $files = DB::select("SELECT file_path, file_name, type, created_at FROM idea_documents WHERE idea_id = $idea->id AND (`type` = 'doc' OR `type` = 'docx' OR `type` = 'pdf')");

        $role = Auth::user()->roles()->first()->name;

        $user_like_unlike = DB::select("SELECT like_unlike FROM idea_like_unlikes WHERE user_id = $user_id AND idea_id = $idea->id");

        $alreadyVote = (count($user_like_unlike)>0)?(($user_like_unlike[0]->like_unlike==0)?"unlike":"like"):"novote";

        if($role=="QA Coordinator"){
            DB::statement("UPDATE ideas SET qa_c_read = 1 where id = $idea->id");
        }

        return view('pages.ideas.detail', compact('idea', 'staff', 'department', 'like', 'unlike', 'view', 'comment', 'comments', 'images', 'files', 'role', 'alreadyVote'));
    }

    public function getComments($pageNumber, $ideaId){
        $recordsPerPage = 5;
        $offset = ($pageNumber -1) * $recordsPerPage;
        return DB::select("SELECT idea_comments.`comment`, idea_comments.anonymous, idea_comments.created_at, if(idea_comments.anonymous>0,'anonymous',staffs.`name`) as name, if(idea_comments.anonymous>0,'',staffs.photo) as photo FROM idea_comments LEFT JOIN users ON idea_comments.user_id = users.id LEFT JOIN staffs ON users.staff_id = staffs.id WHERE idea_comments.idea_id = $ideaId ORDER BY idea_comments.created_at DESC LIMIT $offset, $recordsPerPage");
    }

    public function addComment(Request $request){
        $user_id = auth()->user()->id;
        $department = collect(DB::select("SELECT staffs.department_id FROM users LEFT JOIN staffs ON users.staff_id = staffs.id where users.id = $user_id"))->first();
        try {
            $comment_data = IdeaComments::create([
                'idea_id' => $request->idea_id,
                'user_id' => $user_id,
                'commenter_department_id' => $department->department_id,
                'comment' => $request->comment,
                'anonymous' => $request->anonymous
            ]);
            // DB::insert("INSERT INTO idea_comments (idea_id, user_id, commenter_department_id, comment, `anonymous`) values(?,?,?,?,?)", [$request->idea_id, $user_id, $department->department_id, $request->comment, $request->anonymous]);

            $idea = Idea::find($request->idea_id);

            try {
                SendCommentSubmittedNotification::dispatch($idea->user->staff->email,$comment_data);
            } catch (\Throwable $th) {

            }

            $comment = collect(DB::select("SELECT COALESCE(COUNT(idea_id), 0) AS comment_count FROM idea_comments WHERE idea_id = $request->idea_id"))->first();
            return response()->json(['status' => 'success', 'comments' => $this->getComments(1, $request->idea_id), 'comment_count' => $comment->comment_count], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error'], 500);
        }
    }

    public function addLike(Request $request){
        $user_id = auth()->user()->id;
        $user_like_unlike = DB::select("SELECT like_unlike FROM idea_like_unlikes WHERE user_id = $user_id AND idea_id = $request->idea_id");
        try {
            if(count($user_like_unlike)>0){
                DB::statement("UPDATE idea_like_unlikes SET like_unlike = $request->likeunlike WHERE user_id = $user_id AND idea_id = $request->idea_id");
            }else{
                DB::insert("INSERT INTO idea_like_unlikes (idea_id, user_id, like_unlike) values(?,?,?)", [$request->idea_id, $user_id, $request->likeunlike]);
            }
            $like = collect(DB::select("SELECT COALESCE(COUNT(like_unlike), 0) AS like_count FROM idea_like_unlikes where like_unlike = 1 AND idea_id = $request->idea_id"))->first();
            $unlike = collect(DB::select("SELECT COALESCE(COUNT(like_unlike), 0) AS unlike_count FROM idea_like_unlikes where like_unlike = 0 AND idea_id = $request->idea_id"))->first();
            return response()->json(['status' => 'success', 'like_count' => $like->like_count, 'unlike_count' => $unlike->unlike_count], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => $th], 500);
        }
    }

    public function increaseViewCount(Request $request){
        $user_id = auth()->user()->id;
        try {
            $ideas_views = collect(DB::select("SELECT COALESCE(COUNT(id)) AS count FROM idea_views WHERE idea_views.user_id = $user_id AND idea_views.idea_id = $request->idea_id"))->first();
            if($ideas_views->count==0){
                DB::insert("INSERT INTO idea_views (idea_id, user_id) values(?,?)", [$request->idea_id, $user_id]);
            }
            $view = collect(DB::select("SELECT COALESCE(COUNT(idea_id), 0) AS view_count FROM idea_views WHERE idea_id = $request->idea_id"))->first();
            return response()->json(['status' => 'success', 'view_count' => $view->view_count], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error'], 500);
        }
    }
}
