<style>
  body {
    padding: 20px;
  }

  .cover {
    width: 300px;
    height: 300px;
    display: inline-block;
    background-size: cover;
    position: relative;
    border: 2px solid #fff;
  }
    
  .cover:hover {
    cursor: pointer;
  }

  .cover.playing {
    border: 2px solid #e45343;
  }
  
  .endgamebutton {
    background: #FDAB10;
    border: 1px solid black;
    border-radius: 4px;
    color: black;
    font-family: Helvetica, Arial, sans-serif;
    font-size:13px;
    font-weight: bold;
    height: 28px;
    letter-spacing: normal;
    padding: 0 4px 0 6px;
    padding-left: 4px;
    padding-right: 4px;
    text-align: center;
    text-transform: none;
    text-indent: 0px;
    text-shadow: none;
    vertical-align: middle;
    white-space: nowrap;
    word-spacing: normal;
  }
  
  .endgamebutton:hover {
    background: #C4830B;
  }
  
  .titletext {
    text-align: center;
  }

  .spotify-button {
    position: absolute;
    bottom: 0;
    right: 5px;
    cursor: pointer;
  }
  
</style>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div align="right">
  <iframe src="https://open.spotify.com/embed?uri=spotify%3Aartist%3A2TM0qnbJH4QPhGMCdPt7fH&theme=white&view=coverart" width="300" height="80" frameborder="0" allowtransparency="true"></iframe>
</div>

<h2 class="titletext">Neck Deep</h2>
<h2 class="titletext">The Peace and the Panic</h2>
<div style="text-align: center;" id="title_subtext">
  Are You Neck Deep's Biggest Fan? Prove It.<br/>
  Test your knowledge by answering the questions below<br/>
  and make sure to share your results!
</div><br/>

<div id="question_before" style="text-align:center">
  <button class="btn btn-primary" onclick="start_quiz()">Click to Begin Quiz!</button>
</div>
<div id="question_end" style="display:none">
  <h3 class="titletext" id="score"></h3>
  <div style="text-align: center;" id="end_comment"></div>
  <br/><br/>
  <div class="row">
    <div class="col-xs-6" style="text-align:right">
      <!--<a href="https://twitter.com/intent/tweet?screen_name=NeckDeepUK" class="twitter-mention-button" data-show-count="false">Share</a>&nbsp;&nbsp;
      <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>-->
      <div class="fb-share-button" data-href="https://www.facebook.com/neckdeepuk/" data-layout="button" data-size="large" data-mobile-iframe="true">
        <a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.facebook.com%2Fneckdeepuk%2F&amp;src=sdkpreparse">Share</a>
      </div>
    </div>
    <div class="col-xs-6">
      <button class="endgamebutton" onclick="start_quiz()">Try Again</button>
    </div>
  </div>
</div>
<div id="question_after" style="display: none;text-align:center">
  <input type="hidden" value="0" id="question_id" />
  <h3 class="titletext">What member of Neck Deep...</h3>
  <div style="text-align:center">
    <span id="q_text" style="font-size:16px"></span>
  </div><br/>
  <button class="btn btn-default btn-block" style="font-size:16px" onclick="next_question(0)">A. Ben</button><br/>
  <button class="btn btn-default btn-block" style="font-size:16px" onclick="next_question(1)">B. Fil</button><br/>
  <button class="btn btn-default btn-block" style="font-size:16px" onclick="next_question(2)">C. Dani</button><br/>
  <button class="btn btn-default btn-block" style="font-size:16px" onclick="next_question(3)">D. West</button><br/>
  <button class="btn btn-default btn-block" style="font-size:16px" onclick="next_question(4)">E. Sam</button><br/>
</div>

<br/><br/>

<div align="center">
  <img style="width:80%" src="https://www.rocksound.tv/assets/uploads/neckdeep_peacepanic_head.jpg">
</div>

<script>
var max = 2;
var q_left = Array(max + 1);
var num_right = 0;

var q_list = {
    0:['Has a name that is also a cardinal direction?',3],
    1:['Is first when all names are arranged alphabetically?',0],
    2:['Shares a name with a koala rescued after the 2009 bush fires in Victoria, Australia',4]
  };

$(function(){
  var client_id = '9703476fa53e4b85ab401b7c301a961d'; // Your client id
  var client_secret = 'e17b9f9ef5644e5296196157ae751108'; // Your secret key
});

function next_question(ans) {
  if (ans !== undefined && ans == q_list[$("#question_id").val()][1]) {
    num_right++;
  }
  if (q_left.length == 0) {
    end_quiz();
  } else {
    next_q = q_left.pop();
    $("#q_text").html(q_list[next_q][0]);
    $("#question_id").val(next_q);
  }
}

function end_quiz() {
  $("#question_after").hide();
  $("#title_subtext").hide();
  var percent = Math.floor(num_right * 100 / (max + 1));
  var comment = "";
  if (percent <= 50) {
    comment = "Do you even listen to Generic Pop Punk?";
  } else {
    comment = "You are definitely a fan, but you could<br/>brush up on your Sam Bowden knowledge";
  }
  $("#score").html("You scored " + percent + "%");
  $("#end_comment").html(comment);
  $("#question_end").show();
}

function start_quiz() {
  $("#question_before").hide();
  $("#question_end").hide();
  $("#question_after").show();
  $("#title_subtext").show();
  q_left = shuffleArray(Array.apply(null, {length: max + 1}).map(Function.call, Number));
  num_right = 0;
  next_question();
}

function shuffleArray(array) {
  for (var i = array.length - 1; i > 0; i--) {
    var j = Math.floor(Math.random() * (i + 1));
    var temp = array[i];
    array[i] = array[j];
    array[j] = temp;
  }
  return array;
}

</script>