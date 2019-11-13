@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                @endif
                <div class="card-header">List of jobs</div>

                <div class="card-body">
                <table class="table table-dark">
                    <thead>
                        <tr>
                        
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Email</th>
                        <th scope="col">Active</th>
                        @if(Auth::user()->role->name == 'admin')
                            <th scope="col">Status</th>
                        @endif
                        </tr>
                    </thead>
                    
                    
                    <tbody>
                    @foreach($jobs as $job)
                        <tr>
                            
                            <td>{{$job->title}}</td>
                            <td>{{$job->description}}</td>
                            <td>{{$job->email}}</td>
                            @if(Auth::user()->role->name == 'admin')
                                <td> @if($job->active)
                                    <a href="{{route('activate.job', $job->id)}}">Deactivate</a>
                                @else
                                    <a href="{{route('activate.job', $job->id)}}">Activate</a>
                                @endif </td>
                                <td>
                                    <p>{{$job->status}}</p> <a href="{{route('job.spam', $job->id)}}">Change status</a>
                                </td>
                            @else
                                <td>{{$job->active}}</td>
                            @endif
                            
                        </tr>
                    @endforeach
                        
                    </tbody>
                </table>
                {{ $jobs->links() }}



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
