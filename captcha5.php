<html>
<head>
  <meta charset="utf-8">
  <title>Captcha Study - Custom Captcha</title>
  <script type="text/javascript" src="jquery-1.8.3.min.js"></script>
      <script type="text/javascript">
      $(function()
      {
          var start = null;
          $(window).load(function(event) {
              start = event.timeStamp;
          });
          $(window).unload(function(event) {
              var time = event.timeStamp - start;
              var captcha = "fifth";
              $.post('timer.php', {time: time, captcha: captcha});
          })
      });
  </script>
  <script type="text/javascript">
  function alignGrid(/*string*/ id, /*int*/ cols, /*int*/ cellWidth, 
    /*int*/ cellHeight, /*int*/ padding) {
    
    var x = 0;
    var y = 0;
    var count = 1;

    jQuery("#" + id).each(function() {1
        jQuery(this).css("position", "relative");2
        
        jQuery(this).children("div").each(function() {3
            jQuery(this).css("width", cellWidth + "em");
            jQuery(this).css("height", cellHeight + "em");
            jQuery(this).css("position", "absolute");
            
            jQuery(this).css("left", x + "em");
            jQuery(this).css("top", y + "em");
            
            if ((count % cols) == 0) {4
                x = 0;
                y += cellHeight + padding;
            } else {
                x += cellWidth + padding;
            }
            
            count++;
        });
    });
  }
  </script>
  <script type="text/javascript">
    jQuery(document).ready(function() {
      alignGrid("basicgrid", 3, 9, 5, 1);
    });
  </script>
</head>
<body>
<form method="post" action="captcha5verify.php">
<div id="question"><img src="custom/G_whichCanYouEat.jpg" /></div>
<div id="basicgrid">
    <div class="cell"><a href="captcha5bad.php"><img src="custom/A_Laptop.png" /></a></div>
    <div class="cell"><a href="captcha5bad.php"><img src="custom/B_Car.png" /></a></div>
    <div class="cell"><a href="captcha5bad.php"><img src="custom/C_hat.png" /></a></div>
    <div class="cell"><a href="captcha5bad.php"><img src="custom/D_Whale.png" /></a></div>
    <div class="cell"><a href="captcha5bad.php"><img src="custom/E_Boat.png" /></a></div>
    <div class="cell"><a href="captcha5bad.php"><img src="custom/F_hammeNail.png" /></a></div>
    <div class="cell"><a href="captcha5good.php"><img src="custom/G_GingerBreadMen.png" /></a></div>
    <div class="cell"><a href="captcha5bad.php"><img src="custom/H_CatSink.png" /></a></div>
    <div class="cell"><a href="captcha5bad.php"><img src="custom/I_Earth.png" /></a></div>
</div>
<!-- Confident CAPTCHA end -->
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<input type="submit" name="op" value="Submit" />
</form>
</body>
</html>