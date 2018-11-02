<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
  <!-- Sidebar user panel -->
  @if (!is_null($user))
  <div class="user-panel">
    <div class="pull-left info">
      <p><a href="/home">{{ $user->name }}</a></p>
    </div>
  </div>
  @endif
  <!-- search form -->
  <!--
  <form action="#" method="get" class="sidebar-form">
    <div class="input-group">
      <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
          </span>
    </div>
  </form>
  -->
  <!-- /.search form -->
  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>
    @if (!empty($user))
    <li class="treeview">
      <a href="#">
        <i class="fa fa-calendar"></i><span>勤怠管理</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @if ($user->role_id == 1)
        <li><a href="/reservation_frames"><i class="fa fa-circle-o"></i>タイムスケジュール</a></li>
        <li><a href="/reservation_frames"><i class="fa fa-circle-o"></i>出退勤歴</a></li>
        @endif
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-calendar"></i><span>承認申請</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @if ($user->role_id == 1)
        <li><a href="/reservation_frames"><i class="fa fa-circle-o"></i>承認</a></li>
        <li><a href="/reservation_frames"><i class="fa fa-circle-o"></i>申請</a></li>
        @endif
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-calendar"></i><span>週案管理</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @if ($user->role_id == 1)
        <li><a href="/reservation_frames"><i class="fa fa-circle-o"></i>作成</a></li>
        <li><a href="/reservation_frames"><i class="fa fa-circle-o"></i>過去の週案</a></li>
        @endif
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-calendar"></i><span>生徒情報</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-calendar"></i><span>先生情報</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-calendar"></i><span>日誌作成</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-calendar"></i><span>共有フォルダ</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-calendar"></i><span>施設予約</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @if ($user->role_id == 1)
        <li><a href="/reservation_frames"><i class="fa fa-circle-o"></i>一覧</a></li>
        <li><a href="/reservation_frames"><i class="fa fa-circle-o"></i>予約</a></li>
        @endif
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-calendar"></i><span>チャット</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-calendar"></i><span>スケジュール管理</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @if ($user->role_id == 1)
        <li><a href="/reservation_frames"><i class="fa fa-circle-o"></i>作成</a></li>
        <li><a href="/reservation_frames"><i class="fa fa-circle-o"></i>過去のスケジュール</a></li>
        @endif
      </ul>
    </li>
    @if ($user->user_flag)
    <li class="treeview">
      <a href="#">
        <i class="fa fa-user"></i><span>ユーザ管理</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="/users"><i class="fa fa-circle-o"></i>一覧</a></li>
        @if ($user->privilege_type >= 2)<li><a href="/auth/register"><i class="fa fa-circle-o"></i>新規作成</a></li>@endif
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-database"></i><span>ロール管理</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="/roles"><i class="fa fa-circle-o"></i>一覧</a></li>
        @if ($user->privilege_type >= 2)<li><a href="/roles/create"><i class="fa fa-circle-o"></i>新規作成</a></li>@endif
      </ul>
    </li>
    @endif
    <!--
    <li class="treeview">
      <a href="#">
        <i class="fa fa-edit"></i>
        <span>Layout Options</span>
        <span class="pull-right-container">
          <span class="label label-primary pull-right">4</span>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
        <li><a href="layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
        <li><a href="layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
        <li><a href="layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
      </ul>
    </li>
    -->
    @endif
  </ul>
</section>
<!-- /.sidebar -->
</aside>
