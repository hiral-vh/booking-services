@extends('admin.layouts.app')
@section('content')

    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Business FAQS</h4>
            </div>
        </div>

        <div class="page-content-wrapper ">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-11">
                                        <h4 class="m-t-0 m-b-30">Edit</h4>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{ route('faq.index') }}"><button type="button"
                                                class="btn waves-effect btn-secondary"><i
                                                    class="ion ion-md-arrow-back"></i></button></a>
                                    </div>
                                    <div class="col-12">
                                        <form method="POST" action="{{ route('faq.update',$faq->id) }}" id="faqEditForm"
                                            class="form-horizontal" enctype='multipart/form-data'>
                                            @csrf
                                            @method('put')
                                            <div class="form-group row">
                                                <label for="question" class="col-sm-1 control-label space-for-label">Question<span
                                                    class="error">*</span></label>
                                                    <div class="col-sm-10">
                                                    <textarea class="form-control" id="question" name="question" rows="3" placeholder="Question">{{$faq->question}}</textarea>
                                                    <span class="error" id="questionSpan">{{$errors->admin->first('question')}}</span>
                                                    </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="answer" class="col-sm-1 control-label space-for-label">Answer<span
                                                    class="error">*</span></label>
                                                    <div class="col-sm-10">
                                                    <textarea class="form-control" id="answer" name="answer" rows="10" placeholder="Answer">{{$faq->answer}}</textarea>
                                                    <span class="error" id="answerSpan">{{$errors->admin->first('answer')}}</span>
                                                    </div>
                                            </div>
                                            <div class="form-group m-b-0">
                                                <div class="col-sm-9">
                                                    <button type="submit"
                                                        class="btn btn-primary waves-effect waves-light">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- card-body -->
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->

    </div>
    <!-- Page content Wrapper -->

    </div>
    <script>
        var success = "{{ Session::get('success') }}";
        var error = "{{ Session::get('error') }}";
    </script>
    @section('js')
    <script>
        $("#faqEditForm").submit(function(e) {
            var temp = 0;
            if ($("#question").val() == "") {
                $("#questionSpan").html("Please enter Question");
                temp++;
            }else if($("#question").val().length > 100){
                $("#questionSpan").html("Question must not be greater than 100 character");
                temp++;
            }
            else {
                $("#questionSpan").html("");
            }

            if($("#answer").val() == "")
            {
                $("#answerSpan").html("Please enter Answer");
                temp++;
            }else if($("#answer").val().length > 200){
                $("#answerSpan").html("Answer must not be greater than 200 character");
                temp++;
            }
            else
            {
                $('#answerSpan').html('');
            }

            if(temp !== 0 )
            {
                return false;
            }
        });

        $('#businessFaqMenu').addClass('active');
    </script>
    @endsection
@endsection
