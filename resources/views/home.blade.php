@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Vložiť miesto</div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="panel-body">
                   {!!
                   Form::open([
                   'route' => 'store',
                   'files'=>'true'])
                   !!}
                    <div class="form-group">
                   {!!Form::label('name', 'označenie') !!}
                   {!! Form::text('name') !!}
                    </div>
                    <div class="form-group">
                   {!!Form::label('address', 'adresa') !!}
                   {!! Form::text('address') !!}
                    </div>
                    <div class="form-group">
                   {!!Form::label('type', 'ikona') !!}
                   {!!
                   Form::select('type', array(
                   'restaurant' => 'ikona1',
                   'bar' => 'ikona2'))
                   !!}
                    </div>
                    <div class="form-group">
                        {!!Form::label('kraj', 'kraj') !!}
                        <select id="kraj" name="kraj">
                            @foreach($regions as $region)
                              <option value="{{ $region->id }}">{{ $region->name }}</option>
                            @endforeach
                        </select>
                    </div><!-- /.form-group -->
                    <div  class="form-group">
                        <input type="text" list="mesto" placeholder="mesto" name="mesto">
                        <datalist id="mesto">
                            @foreach($cities as $city)
                                <option>{{ $city->name }}</option>
                            @endforeach
                        </datalist>
                    </div>
                    <input type="hidden" name="size" value="small" />
                    <input type="checkbox" name="size" value="big" />
                    {!! Form::file('image') !!}<br>
                   {!! Form::submit('Vložiť') !!}
                   {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
