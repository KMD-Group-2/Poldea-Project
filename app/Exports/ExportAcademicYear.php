<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ExportAcademicYear implements FromCollection, WithHeadings, WithStrictNullComparison
{
    public $academic_year_id;

    public function __construct($academic_year_id)
    {
        $this->academic_year_id = $academic_year_id;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $ExportData = DB::table('ideas')->select(
            'academic_years.academic_year',
            'academic_years.closure_date',
            'academic_years.final_closure_date',
            'departments.name as department_name',
            'categories.name as category_name',
            'ideas.title',
            'ideas.description',
            'ideas.posted_at',
            'ideas.created_at',
            DB::raw("if(ideas.anonymous=1,'Yes','No') AS anonymous"),
            DB::raw("if(comments.comment_count>0,comments.comment_count,0) AS comment_count"),
            DB::raw("if(likes.like_count>0,likes.like_count,0) AS like_count"),
            DB::raw("if(unlikes.unlike_count>0,unlikes.unlike_count,0) AS unlike_count"),
            DB::raw("if(views.view_count>0,views.view_count,0) AS view_count")
        )->where('posted_at', '!=', null)
            ->join(DB::raw('(SELECT * FROM academic_years WHERE id='.$this->academic_year_id.') AS academic_years'), 'academic_years.id', '=', 'ideas.academic_year_id')
            ->leftJoin('departments', 'departments.id', '=', 'ideas.publisher_department_id')
            ->leftJoin('categories', 'categories.id', '=', 'ideas.category_id')
            ->leftJoin(DB::raw('(SELECT idea_id, COUNT(idea_id) AS comment_count FROM idea_comments GROUP BY idea_id) AS comments'), 'comments.idea_id', '=', 'ideas.id')
            ->leftJoin(DB::raw('(SELECT idea_id, COUNT(idea_id) AS like_count FROM idea_like_unlikes WHERE like_unlike = 1 GROUP BY idea_id) AS likes'), 'likes.idea_id', '=', 'ideas.id')
            ->leftJoin(DB::raw('(SELECT idea_id, COUNT(idea_id) AS unlike_count FROM idea_like_unlikes WHERE like_unlike = 0 GROUP BY idea_id) AS unlikes'), 'unlikes.idea_id', '=', 'ideas.id')
            ->leftJoin(DB::raw('(SELECT idea_id, COUNT(idea_id) AS view_count FROM idea_views GROUP BY idea_id) AS views'), 'views.idea_id', '=', 'ideas.id')
            ->leftJoin(DB::raw('(SELECT idea_id, COUNT(idea_id) AS document_count FROM idea_documents GROUP BY idea_id) AS documents'), 'documents.idea_id', '=', 'ideas.id')
            ->get();

        return $ExportData;
    }

    public function headings(): array
    {
        return [
            "Academic Year", "Closure Date", "Final Closure Date",
            "Department Name", "Category Name", "Idea Title",
            "Idea Description", "Idea Published Date", "Idea Created Date",
            "Anonymous", "Comment Count", "Like Count", "Unlike Count", "View Count"
        ];
    }

    public function prepareRows($rows)
    {
        return Arr::where($rows, function($row) {
            $row->closure_date = Carbon::parse($row->closure_date)->format('d M Y');
            $row->final_closure_date = Carbon::parse($row->final_closure_date)->format('d M Y');
            $row->posted_at = Carbon::parse($row->posted_at)->format('d M Y, g:i A');
            $row->created_at = Carbon::parse($row->created_at)->format('d M Y, g:i A');

            return $row;
        });
    }
}
