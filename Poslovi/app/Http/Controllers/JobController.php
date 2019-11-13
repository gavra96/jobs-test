<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use App\JobModeration;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;

use App\Http\Helpers\Mail;

use App\Http\Requests\JobRequest;

class JobController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkAdmin')->only(['activate' , 'spam']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->role->name == "admin"){
            $jobs = Job::paginate(10);
        }else{
            $jobs = Job::where('user_id', auth()->user()->id)->paginate(10);
        }
        return view('layouts.jobs.job_index')->with('jobs', $jobs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.jobs.job_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobRequest $request)
    {
        try{
            try{
                $model = JobModeration::where('email', $request->email)->firstOrFail();
                if($model->posted_before){
                    $job = Job::create($request->all());
                    $job->active = 1;
                    $job->save();
                    return redirect()->action('JobController@index')->with('message', 'Job created');
                }
                else{
                    $job = Job::create($request->all());
                    $Mail = new Mail();
                    $Mail->JobPostFirstTime($request->email);// ukoliko se trazi ulogovan korisnik auth()->user()->email
                    return redirect()->action('JobController@index')->with('message', 'Job is under moderation.');
                }
            }catch(ModelNotFoundException $e){
                JobModeration::create(['email'=> $request->email, 'posted_before' => 0]);
                $job = Job::create($request->all());
                $Mail = new Mail();
                $Mail->JobPostFirstTime($request->email);// ukoliko se trazi ulogovan korisnik auth()->user()->email
                $moderators = User::with(['role' => function ($query) {
                    $query->where('name', 'admin');
                }])->get();
                foreach($moderators as $mod){
                    $body = "$job->email first job to activate him click <a href='http://localhost:8000/activate/job/$job->id'>here</a> or mark as spam click <a href='http://localhost:8000/status/job/$job->id'>here</a>";
                    $Mail->ToModeratorJobPost($mod->email, $job->email, $body);
                    
                    
                }
                return redirect()->action('JobController@index')->with('message', 'Job is under moderation.');
            }
        }catch(\Exception $e){
            return redirect()->action('JobController@index')->with('message', 'An error accured');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        try{
            $job = Job::find($id);
            $job->active = !$job->active;
            $job->save();
            return redirect()->action('JobController@index')->with('message', 'Updated.');
        }catch(\Exception $e){
            return redirect()->action('JobController@index')->with('message', 'An error accured.');
        }
    }

    public function spam($id)
    {
        try{
            $job = Job::find($id);
            if($job->status == 'spam'){
                $job->status = 'normal';
            }else{
                $job->status = 'spam';
            }
            $job->save();
            return redirect()->action('JobController@index')->with('message', 'Updated.');
        }catch(\Exception $e){
            return redirect()->action('JobController@index')->with('message', 'An error accured.');
        }
    }
}
