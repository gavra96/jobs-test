@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a job</div>

                <div class="card-body">
                <form action="{{route("jobs.store")}}" method="post">
                @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" name="email" class="form-control"  aria-describedby="emailHelp" placeholder="Enter email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Job title</label>
                        <input type="text" class="form-control" name="title" placeholder="title">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Job description</label>
                        <textarea class="form-control" name="description" placeholder="Required example textarea" required></textarea>
                    </div>
                    <input type="text" style="display: none;" name="user_id" value="{{ Auth::user()->id }}" placeholder="title">
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
