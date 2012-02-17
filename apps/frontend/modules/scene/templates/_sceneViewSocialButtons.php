Репинов: <?php echo $repins_count?><br />
Лайков: <?php echo $likes_count?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1&appId=365665100128423";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<fb:like send="false" layout="box_count" width="55" show_faces="true"></fb:like>
<br />