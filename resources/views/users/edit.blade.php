@extends ('layouts.base')

@section ('content')

<!-- header -->
<section class="content-header">
    <h1>ユーザ編集</h1>
    {!! Form::open(['url' => '/users/'.$id, 'method' => 'PATCH']) !!}
        <div class="row">
            <!-- col -->
            <div class="col-xs-12">
                <div class="box box-primary box-home">
                    <div class="box-header">
                        <h3 class="box-title">{!! Form::label('name', 'ユーザ名') !!}</h3>
                    </div>
                    <div class="box-body">
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                        <p>{!! Form::input('text', 'name', $record->name, ['class' => 'form-control']) !!}</p>
                    </div>
                </div>

                <div class="box box-primary box-home">
                    <div class="box-header">
                        <h3 class="box-title">{!! Form::label('email', 'メールアドレス') !!}</h3>
                    </div>
                    <div class="box-body">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                        <p>{!! Form::input('text', 'email', $record->email, ['class' => 'form-control']) !!}</p>
                    </div>
                </div>

                <div class="box box-primary box-home">
                    <div class="box-header">
                        <h3 class="box-title">{!! Form::label('password', 'パスワード') !!}</h3>
                    </div>
                    <div class="box-body">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                        <p>{!! Form::input('password', 'password', $record->password, ['class' => 'form-control']) !!}</p>
                    </div>
                </div>

                <div class="box box-primary box-home">
                    <div class="box-header">
                        <h3 class="box-title">{!! Form::label('role_id', 'ロール') !!}</h3>
                    </div>
                    <div class="box-body">
                        @if ($errors->has('role_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('role_id') }}</strong>
                            </span>
                        @endif
                        <p>{!! Form::select('role_id', $roles, $record->role_id) !!}</p>
                    </div>
                </div>

            </div>
            <div class="col-xs-12">
                {!! Form::submit('更新', ['class' => 'btn btn-primary form-control']) !!}
        </div>
        </div><!-- end row -->
    {!! Form::close() !!}
</section>

@endsection
