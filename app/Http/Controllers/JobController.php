<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobResponsibility;

class JobController extends Controller
{
    public function view()
    {
        $jobs = Job::all();
        return view('dashboard.jobs.view', compact('jobs'));
    }

    public function create()
    {
        return view('dashboard.jobs.add');
    }

    public function store(Request $request)
    {
        $job = new Job();
        $job->title = $request->title;
        $job->city_id = $request->city_id;
        $job->description = $request->description;
        $job->save();

        foreach ($request->responsibility_name as $key => $name) {
            $job_responsibility = new JobResponsibility();
            $job_responsibility->job_id = $job->id;
            $job_responsibility->name = $request->responsibility_name[$key];
            $job_responsibility->save();
        }

        return redirect('job/view')->with('success','New Job has been Posted!');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $job = Job::find($id);

        return view('dashboard.jobs.edit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        $id = decrypt($id);
        $job = Job::find($id);
        $job->title = $request->title;
        $job->city_id = $request->city_id;
        $job->description = $request->description;
        $job->save();

        foreach($job->responsibilities as $key => $job_responsibility){
            $job_responsibility->delete();
        }

        foreach ($request->responsibility_name as $key => $name) {
            $job_responsibility = new JobResponsibility();
            $job_responsibility->job_id = $job->id;
            $job_responsibility->name = $request->responsibility_name[$key];
            $job_responsibility->save();
        }

        return redirect('job/view')->with('success','Job has been updated.');
    }

    public function destroy($id)
    {
        $id = decrypt($id);
        $job = Job::find($id);

        foreach($job->responsibilities as $key => $job_responsibility){
            $job_responsibility->delete();
        }

        foreach($job->applicants as $key => $applicant){
            $applicant->delete();
        }

        $job->delete();
        
        return back()->with('success','Job has been deleted');
    }
}