<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">予約フォーム</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group row">
            <label for="reserve-date" class="col-form-label">日付</label>
            <div class="reserve-div">
              <input class="form-control" type="date" value="2011-08-19" id="reserve-date">
            </div>
          </div>
          <div class="form-group row">
            <label for="reserve-time" class="col-form-label">開始時間</label>
            <div class="reserve-div">
              <input  id="reserve-time" type="time" name="reserve-time" size="6">
            </div>
          </div>
          <div class="form-group row">
            <label for="reserve-minute" class="col-form-label">授業時間</label>
            <div class="reserve-div">
              <select class="form-control" id="reserve-minute" name="reserve-minute">
                <option value="30" selected="selected">30分</option>
                <option value="60" >60分</option>
                <option value="90">90分</option>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
        @if (\Session::get('user'. \Auth::user()->id)->privilege_type > 1)
            <button type="button" id="modal-success" class="btn btn-primary" onclick="create(event)">予約</button>
        @endif
      </div>
    </div>
  </div>
</div>
