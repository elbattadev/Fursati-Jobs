<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::query();

        // فلترة حسب الحقول النصية والاختيارية
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('work_place')) {
            $query->where('work_place', 'like', '%' . $request->work_place . '%');
        }

        if ($request->filled('education_level_id')) {
            $query->where('education_level_id', $request->education_level_id);
        }

        if ($request->filled('country_of_graduation')) {
            $query->where('country_of_graduation', $request->country_of_graduation);
        }

        if ($request->filled('country_of_residence')) {
            $query->where('country_of_residence', $request->country_of_residence);
        }

        if ($request->filled('work_field_id')) {
            $query->where('work_field_id', $request->work_field_id);
        }

        if ($request->filled('gender_preference')) {
            $query->where('gender_preference', $request->gender_preference);
        }

        if ($request->filled('work_experience')) {
            $query->where('work_experience', $request->work_experience);
        }

        if ($request->filled('business_man_id')) {
            $query->where('business_man_id', $request->business_man_id);
        }

        // فلترة حسب فترة التواريخ (من - إلى)
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // فلترة حسب فترة التوظيف (from_date, to_date)
        if ($request->filled('job_from_date')) {
            $query->whereDate('from_date', '>=', $request->job_from_date);
        }

        if ($request->filled('job_to_date')) {
            $query->whereDate('to_date', '<=', $request->job_to_date);
        }

        if ($request->filled('favorite')) {
            $query->where('favorite', $request->favorite);
        }

        return response()->json($query->get());
    }

    public function show($id)
    {
        $job = Job::find($id);

        if ($job) {
            return response()->json($job);
        }

        return response()->json(['error' => 'Job not found'], 404);
    }

    public function markFavorite($id)
    {
        $job = Job::find($id);

        if ($job) {
            $job->favorite = !$job->favorite;
            $job->save();

            return response()->json(['message' => 'Marked as favorite', 'job' => $job]);
        }

        return response()->json(['error' => 'Job not found'], 404);
    }

    public function bookmarked()
    {
        $jobs = Job::where('favorite', true)->get();

        return response()->json($jobs);
    }
}
