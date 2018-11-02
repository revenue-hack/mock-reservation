@extends ('layouts.base')

@section ('content')
@include ('modules.save_status')

<!-- コンテンツヘッダ -->
<section class="content-header">
    <h1>ロール管理</h1>
</section>

<!-- メインコンテンツ -->
<section class="content">
    <!-- コンテンツ1 -->
    <div class="box">
        <div class="box-header with-border">
            {{-- <h3 class="box-title">ロール一覧</h3> --}}

            @include ('modules.searchform', ['title' => "ロール名検索", 'q' => $q])
            @if ((int) \Auth::user()->privilege_type >= 2)
            <div class="create-button"><a class="index-button" href="/roles/create"><button class="btn btn-info">新規作成</button></a></div>
            @endif
        </div>
        <div class="box-body">
            <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>権限区分(1:参照,2:編集,3:削除)</th>
                <th>ユーザ管理権限</th>
                <th>作成日</th>
                <th>更新日</th>
                <th>操作</th>
            </tr>
            @if (!empty($roles))
                @foreach ($roles as $role)
                    <tr>
                        <td>{{$role->id}}</td>
                        <td>{{$role->role_name}}</td>
                        <td>{{$role->privilege_type}}</td>
                        @if ($role->user_flag)
                        <td>あり</td>
                        @else
                        <td>なし</td>
                        @endif
                        <td>{{$role->created_at}}</td>
                        <td>{{$role->updated_at}}</td>
                        <td>
                            <div class="btn-group">
                                @if (getActiveUser()->privilege_type >= 2)
                                <a href="/roles/{{$role->id}}/edit" class=index-button">
                                    <button type="button" class="btn btn-info">編集</button>
                                </a>
                                @endif
                                @if (getActiveUser()->privilege_type >= 3)
                                <div class="delete-form">
                                {!! Form::open(['url' => '/roles/'.$role->id, 'method' => 'DELETE']) !!}
                                {!! Form::submit('削除', ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                                </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
            <p>データはありません</p>
            @endif
            </table>
        </div>
        @if (!empty($roles))
            @include ('modules.pagination', ['q' => $q or "", 'pagers' => $roles])
        @endif
    </div>
</section>

@endsection
