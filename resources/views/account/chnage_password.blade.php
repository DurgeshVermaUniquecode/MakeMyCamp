@extends('layouts.app')
@section('title', 'Profile')
@section('content')
    <div class="row">
        <div class="col-md-12">

            <!-- Change Password -->
            <div class="card mb-6">
                <h5 class="card-header">Change Password</h5>
                <div class="card-body pt-1">
                    <form action="{{route('change_password')}}" method="POST">
                        @csrf
                        <div class="row gy-sm-6 gy-2 mb-sm-0 mb-2">
                            <div class="mb-6 col-md-6 form-password-toggle form-control-validation">
                                <label class="form-label" for="password">New Password</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control" type="password" id="password" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <span class="input-group-text cursor-pointer"><i
                                            class="icon-base ti tabler-eye-off icon-xs"></i></span>
                                </div>
                                @error('password')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="mb-6 col-md-6 form-password-toggle form-control-validation">
                                <label class="form-label" for="password_confirmation">Confirm New Password</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control" type="password" name="password_confirmation" id="password_confirmation"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <span class="input-group-text cursor-pointer"><i
                                            class="icon-base ti tabler-eye-off icon-xs"></i></span>
                                </div>
                                @error('password_confirmation')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- <h6 class="text-body">Password Requirements:</h6>
                        <ul class="ps-4 mb-0">
                            <li class="mb-4">Minimum 8 characters long - the more, the better</li>
                            <li class="mb-4">At least one lowercase character</li>
                            <li>At least one number, symbol, or whitespace character</li>
                        </ul> --}}
                        <div class="mt-6">
                            <button type="submit" class="btn btn-primary me-3">Update</button>
                            <button type="reset" class="btn btn-label-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--/ Change Password -->



        </div>
    </div>
@endsection
