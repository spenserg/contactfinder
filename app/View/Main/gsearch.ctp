<form method="post" action="/main/gsearch/<?=$web_id?>" id="mainform">
<div class="well">
  <?=564 - $web_id?> LEFT!
  <div class="row">
    <div class="col-sm-2 col-md-1">
      Name:
    </div>
    <div class="col-sm-9">
      <button class="btn btn-danger" onclick="window.open('https://www.google.com/search?q=www.<?=$url?>+contact', 'newwindow', 'width=1000,height=1000'); return false;">GOOGLE</button>
      &nbsp;&nbsp;&nbsp;(Cmd + W) to close popup window
    </div>
  </div><br/>
  
  <div class="row">
    <div class="col-sm-3">
      Google Page Copypaste:
    </div>
    <div class="col-sm-9">
      <textarea name="google_info" rows="5" cols="50"></textarea>
    </div>
  </div><br/>
  
  <button class="btn btn-success" type="submit">SUBMIT</button><br/><br/>
  <input name="name" type="text" size="70" value="<?=$url?>" readonly>
</div>
</form>

<?=$str?>