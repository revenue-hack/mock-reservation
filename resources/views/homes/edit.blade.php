@extends ('layouts.base')
@section ('content')
<!-- コンテンツヘッダ -->
<section class="content-header">
    <h1>アカウント管理</h1>
</section>

<!-- メインコンテンツ -->
<section class="content">
    {!! Form::open(['url' => '/homes/'. $user->id, 'method' => 'PATCH']) !!}
    <div class="row">
        <!-- col -->
        <div class="col-xs-6">
            <div class="box box-primary box-home">
                <div class="box-header">
                    <h3 class="box-title">{!! Form::label('name', '名前') !!}</h3>
                </div>
                <div class="box-body">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                    <p>{!! Form::input('text', 'name', $user->name, ['class' => 'form-control']) !!}</p>
                </div>
            </div>
        </div>

        <!-- col -->
        <div class="col-xs-6">
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
                    <p>{!! Form::input('password', 'password', $user->password, ['class' => 'form-control']) !!}</p>
                </div>
            </div>
        </div>

        <!-- col -->
        <div class="col-xs-6">
            <div class="box box-primary box-home">
                <div class="box-header">
                    <h3 class="box-title">{!! Form::label('email', 'Eメール') !!}</h3>
                </div>
                <div class="box-body">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    <p>{!! Form::input('email', 'email', $user->email, ['class' => 'form-control']) !!}</p>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
        {!! Form::submit('アカウント変更', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div><!-- end row -->
    {!! Form::close() !!}
</section>
@endsection
