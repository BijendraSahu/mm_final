@if($errors->any())
    <div role='alert' id='alert' class='alert alert-danger'>{{$errors->first()}}</div>
@endif
{!! Form::open(['url' => 'privacy_update', 'class' => 'form-horizontal', 'id'=>'privacy_update']) !!}
<div class="container-fluid">
    <div class="container-fluid">
        <div class="col-sm-12">
            <div class='form-group'>
                {!! Form::label('contact', 'Name:', ['class' => 'col-sm-4 control-label']) !!}
                <div class='col-sm-8'>
                    {!! Form::label('mm', ucfirst($user->name), ['class' => 'control-label']) !!}
                </div>
            </div>
            {{--<div class='form-group'>--}}
            {{--{!! Form::label('contact', 'Profile', ['class' => 'col-sm-3 control-label']) !!}--}}
            {{--<div class='col-sm-9'>--}}
            {{--<img src="{{url('').'/'.$image->pic1}}" alt="" style="height: auto; width: 220px;">--}}
            {{--</div>--}}
            {{--</div>--}}

            <div class='form-group'>
                {!! Form::label('contact', 'Primary Contact:', ['class' => 'col-sm-4 control-label']) !!}
                <div class='col-sm-8'>
                    {{--                    {!! Form::label('mm', , ['class' => 'control-label']) !!}--}}
                    <label for="" class="control-label">{{isset($user->contact)?$user->contact:'Not Mentioned'}}</label>
                </div>
            </div>
            <div class='form-group'>
                {!! Form::label('contact', 'Alternate Contact:', ['class' => 'col-sm-4 control-label']) !!}
                <div class='col-sm-8'>
                    {{--                    {!! Form::label('mm', , ['class' => 'control-label']) !!}--}}
                    <label for="" class="control-label">{{isset($user->mob)?$user->mob:'Not Mentioned'}}</label>
                </div>
            </div>
            <div class='form-group'>
                {!! Form::label('contact', 'Landline No:', ['class' => 'col-sm-4 control-label']) !!}
                <div class='col-sm-8'>
                    {{--                    {!! Form::label('mm', , ['class' => 'control-label']) !!}--}}
                    <label for="" class="control-label">{{isset($user->mob2)?$user->mob2:'Not Mentioned'}}</label>
                </div>
            </div>

            <div class='form-group'>
                {!! Form::label('contact', 'Address:', ['class' => 'col-sm-4 control-label']) !!}
                <div class='col-sm-8'>
                    {{--                    {!! Form::label('mm', , ['class' => 'control-label']) !!}--}}
                    <label for="" class="control-label">{{isset($user->address)?$user->address:'Not Mentioned'}}</label>
                </div>
            </div>

        </div>
    </div>
</div>
{!! Form::close() !!}
