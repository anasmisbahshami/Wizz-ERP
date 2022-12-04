<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplicant;

class JobApplicantController extends Controller
{
    public function view($id)
    {
        $id = decrypt($id);
        $job_applicant = JobApplicant::find($id);
        return view('dashboard.jobs.details.view', compact('job_applicant'));
    }

    public function download_resume($id)
    {
        $id = decrypt($id);
        $job_applicant = JobApplicant::find($id);
        return \Storage::disk('s3')->download($job_applicant->resume);
        // return \Storage::download($job_applicant->resume);
    }

    public function delete_applicant($id)
    {
        $id = decrypt($id);
        JobApplicant::find($id)->delete();

        return redirect('/job/view')->with('success', 'Applicant deleted successfully!');
    }

    public function shortlist(Request $request, $id)
    {
        $id = decrypt($id);
        $job_applicant = JobApplicant::find($id);
        $job_applicant->short_listed = 'Yes';
        $job_applicant->save();

        $data = array(
            'name' => $job_applicant->first_name.' '.$job_applicant->last_name,
            'email' => $job_applicant->email,
            'meeting_link' => $request->meeting_link,
            'email_message' => $request->email_message
        );

        //Sending Mail and Invoice to User Email
        \Mail::send('emails.shortlist_applicant', $data,
        function($message) use($data){
        $message->to($data['email'], $data['name'])
        ->subject('Shortlisted for Interview | Wizz Express')
        ->from('donotreply@wizz-express.com','Wizz Express & Logistics');
        });

        return redirect('/job/view')->with('success', 'Applicant shortlisted successfully! Email sent to the applicant.');
    }
}
