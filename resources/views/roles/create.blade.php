@extends ('layouts.base')

@section ('content')

<!-- header -->
<section class="content-header">
    <h1>ロール新規作成</h1>
    {!! Form::open(['url' => '/roles']) !!}
        <div class="row">
            <!-- col -->
            <div class="col-xs-12">
                <div class="box box-primary box-home">
                    <div class="box-header">
                        <h3 class="box-title">{!! Form::label('name', 'ロール名') !!}</h3>
                    </div>
                    <div class="box-body">
                        @if ($errors->has('role_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('role_name') }}</strong>
                            </span>
                        @endif
                        <p>{!! Form::input('text', 'role_name', null, ['class' => 'form-control']) !!}</p>
                    </div>
                </div>

                <div class="box box-primary box-home">
                    <div class="box-header">
                        <h3 class="box-title">{!! Form::label('privilege_type', '権限区分') !!}</h3>
                    </div>
                    <div class="box-body">
                        @if ($errors->has('privilege_type'))
                            <span class="help-block">
                                <strong>{{ $errors->first('privilege_type') }}</strong>
                            </span>
                        @endif
                        <p>{!! Form::select('privilege_type', [1 => "参照", 2 => "参照+編集", 3 => "参照+編集+削除"]) !!}</p>
                    </div>
                </div>

                <div class="box box-primary box-home">
                    <div class="box-header">
                        <h3 class="box-title">{!! Form::label('user_flag', 'ユーザ管理権限') !!}</h3>
                    </div>
                    <div class="box-body">
                        @if ($errors->has('user_flag'))
                            <span class="help-block">
                                <strong>{{ $errors->first('user_flag') }}</strong>
                            </span>
                        @endif
                        <p>{!! Form::select('user_flag', [1 => "あり", 0 => "なし"]) !!}</p>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                {!! Form::submit('登録', ['class' => 'btn btn-primary form-control']) !!}
        </div>
        </div><!-- end row -->
    {!! Form::close() !!}
</section>

@endsection
