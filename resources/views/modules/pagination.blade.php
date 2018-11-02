<div class="box-footer clearfix">
    @if (!empty($q))
        {!! $pagers->appends(['q' => $q])->render() !!}
    @else
        {!! $pagers->render() !!}
    @endif
</div>
