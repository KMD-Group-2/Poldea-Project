<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Category;
use App\Models\Idea;
use App\Traits\FilterHandler;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{
    use FilterHandler;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin', ['only' => ['adminDashboard']]);
        $this->middleware('role:QA Manager', ['only' => ['QAManagerDashboard']]);
        $this->middleware('role:QA Coordinator', ['only' => ['QACoordinatorDashboard']]);
        $this->middleware('role:Staff', ['only' => ['StaffDashboard']]);
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('QA Manager')) {
            return redirect()->route('qa_m.dashboard');
        } elseif ($user->hasRole('QA Coordinator')) {
            return redirect()->route('qa_c.dashboard');
        } elseif ($user->hasRole('Staff')) {
            return redirect()->route('staff.dashboard');
        }else{
            Auth::logout();

            throw ValidationException::withMessages([
                'username' => trans('auth.failed'),
            ]);
        }
    }

    public function adminDashboard()
    {
        view()->share(['high_chart' => true]);

        return view('pages.landing-pages.admin_dashboard',  $this->adminQAManagerDashboardData());
    }

    public function QAManagerDashboard()
    {
        view()->share(['high_chart' => true]);
        return view('pages.landing-pages.qa_manager_dashboard', $this->adminQAManagerDashboardData());
         //return $this->adminDashboard();
        
    }

    public function adminQAManagerDashboardData(){
        $counts = DB::select("SELECT 'Department' AS name, COUNT(*) AS count FROM departments 
                            UNION SELECT 'Staff' AS name, COUNT(*) AS count FROM staffs 
                            UNION SELECT 'User' AS name, COUNT(*) AS count FROM users 
                            UNION SELECT 'Idea' AS name, COUNT(*) AS count FROM ideas WHERE ideas.posted_at IS NOT NULL");

        $ideaCountByDeparment = DB::select("SELECT departments.name, COUNT(departments.name) AS count FROM ideas LEFT JOIN departments ON ideas.publisher_department_id = departments.id WHERE ideas.posted_at IS NOT NULL GROUP BY departments.name");

        //need to check posted at null
        $ideaAndcommentCountByDepartment = DB::select("SELECT name, SUM(idea_count) AS idea_count, SUM(comment_count) as comment_count FROM (SELECT departments.name, COUNT(ideas.publisher_department_id) AS idea_count, 0 AS comment_count FROM departments
                                                        LEFT JOIN ideas ON ideas.publisher_department_id = departments.id 
                                                        WHERE ideas.posted_at IS NOT NULL
                                                        GROUP BY departments.name, ideas.publisher_department_id
                                                        HAVING COUNT(ideas.publisher_department_id) > 0
                                                        UNION
                                                        SELECT departments.name, 0 AS idea_count, COUNT(idea_comments.commenter_department_id) AS comment_count FROM departments
                                                        LEFT JOIN idea_comments ON idea_comments.commenter_department_id = departments.id
                                                        GROUP BY departments.name, idea_comments.commenter_department_id
                                                        HAVING COUNT(idea_comments.commenter_department_id) > 0) AS depart_idea_comment_count GROUP BY name");

        $recentIdeas = DB::select("SELECT ideas.id, ideas.title, if(ideas.anonymous>0,'anonymous',staffs.`name`) as name, departments.name AS department, ideas.posted_at, ideas.anonymous, staffs.photo, categories.name as category FROM ideas 
                                LEFT JOIN users ON ideas.user_id = users.id 
                                LEFT JOIN staffs ON users.staff_id = staffs.id 
                                LEFT JOIN departments ON ideas.publisher_department_id = departments.id 
                                LEFT JOIN categories ON categories.id = ideas.category_id 
                                WHERE ideas.posted_at IS NOT NULL ORDER BY ideas.posted_at DESC LIMIT 5");

        $recentComments = DB::select("SELECT ideas.id, if(idea_comments.anonymous>0,'anonymous',staffs.`name`) as name, staffs.photo, idea_comments.`comment`, idea_comments.anonymous, idea_comments.created_at, departments.name AS department, categories.name as category FROM idea_comments
                                    LEFT JOIN ideas ON idea_comments.idea_id = ideas.id
                                    LEFT JOIN departments ON departments.id = idea_comments.commenter_department_id
                                    LEFT JOIN users ON idea_comments.user_id = users.id
                                    LEFT JOIN staffs ON users.staff_id = staffs.id
                                    LEFT JOIN categories ON categories.id = ideas.category_id 
                                    WHERE ideas.posted_at IS NOT NULL ORDER BY idea_comments.created_at  DESC LIMIT 5");

        return compact('counts', 'ideaCountByDeparment', 'ideaAndcommentCountByDepartment', 'recentIdeas', 'recentComments');

    }

    public function QACoordinatorDashboard()
    {
        view()->share(['high_chart' => true]);

        $user_id = auth()->user()->id;
        $userDepartment = collect(DB::select("SELECT staffs.department_id FROM users LEFT JOIN staffs ON users.staff_id = staffs.id where users.id = $user_id"))->first();
        $departmentID = $userDepartment->department_id;

        $counts = DB::select("SELECT 'Like' AS name, COUNT(*) AS count FROM idea_like_unlikes INNER JOIN
                                (SELECT ideas.id FROM ideas LEFT JOIN departments ON ideas.publisher_department_id = departments.id WHERE departments.id = $departmentID) as idea
                                ON idea.id = idea_like_unlikes.idea_id WHERE idea_like_unlikes.`like_unlike` = 1 UNION
                                SELECT 'Unlike' AS name, COUNT(*) AS count FROM idea_like_unlikes INNER JOIN
                                (SELECT ideas.id FROM ideas LEFT JOIN departments ON ideas.publisher_department_id = departments.id WHERE departments.id = $departmentID) as idea
                                ON idea.id = idea_like_unlikes.idea_id WHERE idea_like_unlikes.`like_unlike` = 0 UNION
                                SELECT 'Staff' AS name, COUNT(*) AS count FROM staffs WHERE staffs.department_id = $departmentID UNION
                                SELECT 'User' AS name, COUNT(*) AS count FROM users LEFT JOIN staffs on users.staff_id = staffs.id WHERE staffs.department_id = $departmentID UNION
                                SELECT 'Idea' AS name, COUNT(departments.name) AS count FROM ideas LEFT JOIN departments ON ideas.publisher_department_id = departments.id WHERE departments.id = $userDepartment->department_id");


        $recentIdeas = DB::select("SELECT ideas.id, ideas.title, if(ideas.anonymous>0,'anonymous',staffs.`name`) as name, departments.name AS department, ideas.posted_at, ideas.anonymous, staffs.photo, categories.name as category FROM ideas 
                                LEFT JOIN users ON ideas.user_id = users.id 
                                LEFT JOIN staffs ON users.staff_id = staffs.id 
                                LEFT JOIN departments ON ideas.publisher_department_id = departments.id 
                                LEFT JOIN categories ON categories.id = ideas.category_id 
                                WHERE ideas.publisher_department_id = $departmentID ORDER BY ideas.posted_at DESC LIMIT 5");

        $recentComments = DB::select("SELECT ideas.id, if(idea_comments.anonymous>0,'anonymous',staffs.`name`) as name, staffs.photo, idea_comments.`comment`, idea_comments.anonymous, idea_comments.created_at, departments.name AS department, categories.name as category FROM idea_comments
                                    LEFT JOIN ideas ON idea_comments.idea_id = ideas.id
                                    LEFT JOIN departments ON departments.id = idea_comments.commenter_department_id
                                    LEFT JOIN users ON idea_comments.user_id = users.id
                                    LEFT JOIN staffs ON users.staff_id = staffs.id 
                                    LEFT JOIN categories ON categories.id = ideas.category_id WHERE ideas.publisher_department_id = $departmentID
                                    ORDER BY idea_comments.created_at DESC LIMIT 5");

        return view('pages.landing-pages.qa_coordinator_dashboard',  compact('counts', 'recentIdeas', 'recentComments'));

        //return view('pages.landing-pages.qa_manager_dashboard');
    }

    public function StaffDashboard()
    {
        $user_id = auth()->user()->id;

        $counts = DB::select("SELECT 'Like' AS name, COUNT(*) AS count FROM idea_like_unlikes INNER JOIN 
                                (SELECT ideas.id FROM ideas WHERE ideas.user_id = $user_id) as idea 
                                ON idea.id = idea_like_unlikes.idea_id WHERE idea_like_unlikes.`like_unlike` = 1 UNION 
                                SELECT 'Unlike' AS name, COUNT(*) AS count FROM idea_like_unlikes INNER JOIN 
                                (SELECT ideas.id FROM ideas WHERE ideas.user_id = $user_id) as idea 
                                ON idea.id = idea_like_unlikes.idea_id WHERE idea_like_unlikes.`like_unlike` = 0 UNION 
                                SELECT 'Idea' AS name, COUNT(ideas.id) AS count FROM ideas WHERE ideas.user_id = $user_id");

        $recentIdeas = DB::select("SELECT ideas.id, ideas.title, if(ideas.anonymous>0,'anonymous',staffs.`name`) as name, departments.name AS department, ideas.posted_at, ideas.anonymous, staffs.photo, categories.name as category FROM ideas 
                                LEFT JOIN users ON ideas.user_id = users.id LEFT JOIN staffs ON users.staff_id = staffs.id 
                                LEFT JOIN departments ON ideas.publisher_department_id = departments.id 
                                LEFT JOIN categories ON categories.id = ideas.category_id 
                                WHERE users.id = $user_id AND ideas.posted_at IS NOT NULL
                                ORDER BY ideas.posted_at DESC LIMIT 5");

        $recentComments = DB::select("SELECT ideas.id, if(idea_comments.anonymous>0,'anonymous',staffs.`name`) as name, staffs.photo, idea_comments.`comment`, idea_comments.anonymous, idea_comments.created_at, departments.name AS department, categories.name as category FROM idea_comments
                                    LEFT JOIN ideas ON idea_comments.idea_id = ideas.id
                                    LEFT JOIN departments ON departments.id = idea_comments.commenter_department_id
                                    LEFT JOIN users ON idea_comments.user_id = users.id
                                    LEFT JOIN categories ON categories.id = ideas.category_id 
                                    LEFT JOIN staffs ON users.staff_id = staffs.id WHERE users.id = $user_id
                                    ORDER BY idea_comments.created_at DESC LIMIT 5");

        return view('pages.landing-pages.staff_dashboard', compact('counts', 'recentIdeas', 'recentComments'));
    }
}
