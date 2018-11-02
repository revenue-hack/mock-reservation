@extends ('layouts.base')

@section ('content')
@include ('modules.save_status')

<!-- コンテンツヘッダ -->
<section class="content-header">
    <h1>ユーザ管理</h1>
</section>

<!-- メインコンテンツ -->
<section class="content">
    <!-- コンテンツ1 -->
    <div class="box">
        <div class="box-header with-border">
            {{-- <h3 class="box-title">ユーザ一覧</h3> --}}

            @include ('modules.searchform', ['title' => "ユーザ検索", 'q' => $q])
            @if ((int) \Auth::user()->privilege_type >= 2)
            <div class="create-button"><a href="/auth/register" class="index-button"><button class="btn btn-info">新規作成</button></a></div>
            @endif

        </div>
        <div class="box-body">
            <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>ユーザ名</th>
                <th>メールアドレス</th>
                <th>作成日</th>
                <th>更新日</th>
                <th>操作</th>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->created_at}}</td>
                    <td>{{$user->updated_at}}</td>
                    <td>
                        <div class="btn-group">
                            @if (getActiveUser()->privilege_type >= 2)
                            <a href="/users/{{$user->id}}/edit" class=index-button">
                                <button type="button" class="btn btn-info">編集</button>
                            </a>
                            @endif
                            @if (getActiveUser()->privilege_type >= 3)
                            <div class="delete-form">
                            {!! Form::open(['url' => '/users/'.$user->id, 'method' => 'DELETE']) !!}
                            {!! Form::submit('削除', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                            </div>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </table>
        </div>
        @include ('modules.pagination', ['q' => $q or "", 'pagers' => $users])
    </div>
</section>

@endsection
