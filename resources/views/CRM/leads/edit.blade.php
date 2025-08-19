@extends('layouts.app')
@section('content')
    <!-- Basic Layout -->
    <div class="row mb-6 gy-6">

        <div class="col-xl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Update Lead</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('edit_lead',[$lead->id]) }}" method="POST">

                        @csrf
                        <div class="row">




                            <div class="col-sm-3">
                                <div class="mb-6">
                                    <label class="form-label" for="name">Name <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <span id="name2" class="input-group-text"><i
                                                class="icon-base ti tabler-user"></i></span>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Name" aria-label="Name" required value="{{ old('name',$lead->user_name) }}"
                                            aria-describedby="name2" />
                                    </div>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-sm-3">
                                <div class="mb-6">
                                    <label class="form-label" for="email">Email <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <span id="email2" class="input-group-text"><i
                                                class="icon-base ti tabler-mail"></i></span>
                                        <input type="text" class="form-control" id="email" name="email"
                                            placeholder="Email" aria-label="Email" required value="{{ old('email',$lead->email) }}"
                                            aria-describedby="email2" />
                                    </div>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="mb-6">
                                    <label class="form-label" for="phone">Phone <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <span id="phone2" class="input-group-text"><i
                                                class="icon-base ti tabler-phone"></i></span>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            placeholder="Phone" aria-label="Phone" required value="{{ old('phone',$lead->phone) }}"
                                            aria-describedby="phone2" />
                                    </div>
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-sm-3">
                                <div class="mb-6">
                                    <label class="form-label" for="company_name">Company Name</label>
                                    <div class="input-group input-group-merge">
                                        <span id="company_name2" class="input-group-text"><i
                                                class="icon-base ti tabler-components"></i></span>
                                        <input type="text" class="form-control" id="company_name" name="company_name"
                                            placeholder="Company Name" aria-label="Company Name"
                                            value="{{ old('company_name',$lead->company_name) }}" aria-describedby="company_name2" />
                                    </div>
                                    @error('company_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="mb-6">
                                    <label class="form-label" for="address">Address</label>
                                    <div class="input-group">
                                        <textarea id="address" name="address" class="form-control" placeholder="Address" aria-label="address"
                                            aria-describedby="Address">{{ old('address',$lead->address) }}</textarea>
                                    </div>
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-sm-3">
                                <div class="mb-6">
                                    <label for="lead_source" class="form-label">Lead Source<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="lead_source" name="lead_source"
                                        aria-label="Select Lead Source" required>
                                        <option value="">Select Lead Source</option>
                                        <option value="Website" @selected(old('lead_source',$lead->source) == 'Website')>Website</option>
                                        <option value="Referral"  @selected(old('lead_source',$lead->source) == 'Referral')>Referral</option>
                                        <option value="Social Media"  @selected(old('lead_source',$lead->source) == 'Social Media')>Social Media</option>
                                        <option value="Other"  @selected(old('lead_source',$lead->source) == 'Other')>Other</option>
                                    </select>
                                    @error('lead_source')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-sm-12">
                                <div class="mb-6">
                                    <label class="form-label" for="description">Description</label>
                                    <div class="input-group">
                                        <textarea id="description" name="description" class="form-control" placeholder="Description"
                                            aria-label="Description" aria-describedby="Description">{{ old('description',$lead->source_description) }}</textarea>
                                    </div>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>


                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
