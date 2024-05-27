@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('login') }}">{{ env('APP_NAME') }}</a></li>
                                <li class="breadcrumb-item active"><a href="{{ route('email-list') }}">Email</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Email</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card-box">

                        <h4 class="header-title mb-4">Edit</h4>

                        <div class="row">
                            <div class="col-xl-12">
                                <form action="{{route('email-update')}}" method="POST" id="editEmailForm"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="id" name="id" value="{{$email_data->id}}">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Title</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            placeholder="Title" value="{{(!empty($email_data->title))?$email_data->title:''}}"
                                            maxlength="200" required data-parsley-trigger="keyup"
                                            data-parsley-required-message="Please enter Title.">
                                        <span class="error"
                                            id="titleErrorSpan">{{ $errors->emailTemp->first('title') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Subject</label>
                                        <input type="text" class="form-control" id="subject" name="subject"
                                            placeholder="Subject" value="{{(!empty($email_data->subject))?$email_data->subject:''}}"
                                            maxlength="200" required data-parsley-trigger="keyup"
                                            data-parsley-required-message="Please enter Subject.">
                                        <span class="error"
                                            id="subjectErrorSpan">{{ $errors->emailTemp->first('subject') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mail</label>
                                        <textarea  class="form-control" id="mail" name="mail"
                                        placeholder="Mail" rows="15" required data-parsley-trigger="keyup"
                                        data-parsley-required-message="Please enter Mail.">{{(!empty($email_data->mail))?$email_data->mail:''}}</textarea>
                                        <span class="error"
                                            id="mailErrorSpan">{{ $errors->emailTemp->first('mail') }}</span>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                            <!-- end col -->

                        </div>
                        <!-- end row -->
                    </div>
                </div>
                <!-- end col -->
            </div>
        </div>
    </div>
@section('script')
    <script>
        $(document).ready(function() {
            $('#emailMenu').addClass('active');
            $('#editEmailForm').parsley();
        });
    </script>
@endsection
@endsection
