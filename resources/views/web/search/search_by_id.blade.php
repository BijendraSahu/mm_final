@if($errors->any())
    <div role='alert' id='alert' class='alert alert-danger'>{{$errors->first()}}</div>
@endif
{{--{!! Form::open(['url' => 'view_profile', 'class' => 'form-horizontal', 'id'=>'privacy_update']) !!}--}}
<div class="row">
    {!! Form::label('contact', 'Search By Profile Id', ['class' => 'col-sm-3 control-label']) !!}
    <div class='col-sm-9'>
        <div class='col-sm-1'>
            {!! Form::label('mm', 'MM', ['class' => 'control-label']) !!}
        </div>
        <div class='col-sm-10'>
            <input type="number" min="0" class="form-control input-sm numberOnly" id="profile_id"
                   placeholder="Enter Profile Id">
        </div>
    </div>
    <div class='col-sm-offset-4 col-sm-9'>
            <button type="button" onclick="search_by_profileid();" class="btn btn-sm btn-primary" style="margin-top: 10px;">Search</button>
    </div>
</div>
{{--<p class="clearfix"></p>--}}
{{--<div class="col-sm-12">--}}
    {{--<div class='form-group'>--}}

    {{--</div>--}}
{{--</div>--}}
{{--{!! Form::close() !!}--}}
<script type="text/javascript">
    function search_by_profileid() {
        var profile_id = $('#profile_id').val();
        if (profile_id == '') {
            swal("Warning", "Please enter profile id", "info");
        } else {
            window.location.href = "{{url('view_profile').'/'}}" + profile_id;
        }
    }
</script>
