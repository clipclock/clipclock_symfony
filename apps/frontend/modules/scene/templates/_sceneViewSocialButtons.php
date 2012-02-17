Репинов: <?php echo $repins_count?><br />
Лайков: <?php echo $likes_count?>
<div id="fb-root"></div>

<script>

    function toggleFBLikeButton(scene_id, user_id, state) {
        $.ajax({
            url: "<?php echo url_for('@scene_change_liked_state'); ?>",
            type: "GET",
            data: { user_id : user_id, scene_id : scene_id, state: state },
        });
    }

    window.fbAsyncInit = function() {
    FB.init({
      appId      : 365665100128423,
      channelUrl : '//viddii.dev/channel.html',
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });

    FB.Event.subscribe('edge.create',
        function(response) { toggleFBLikeButton(<?php echo sprintf('%d, %d, 1', $scene_id, $user->getProfile()->getId()) ?>); }
    );

    FB.Event.subscribe('edge.remove',
        function(response) { toggleFBLikeButton(<?php echo sprintf('%d, %d, 0', $scene_id, $user->getProfile()->getId()) ?>); }
    );

    };

  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));

</script>
<fb:like send="false" layout="box_count" width="55" show_faces="true"></fb:like>
<br />
