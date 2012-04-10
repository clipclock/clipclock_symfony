<?php if(!$user->getId()):?>
<script type="text/javascript">
	_kmq.push(['set', {'guest':'true'}]);
</script>
<ul class="autorizing">
	<li class="login"><a href="<?php echo url_for('connect_fb')?>">Login</a></li>
	<li class="about">
		<div class="arrow"></div>
		<a href="<?php echo $fb_page_url?>">About</a>
		<div class="sub">
			<ul>
				<li><a href="<?php echo $fb_page_url?>">Blog</a></li>
			</ul>
		</div>
	</li>
</ul>
<?php else: ?>
<script type="text/javascript">
	_kmq.push(['set', {'guest':'false'}]);
	_kmq.push(['identify', '<?php echo $user->getFullName()?>']);
</script>
<ul class="autorized">
	<li class="invite">
		<div class="arrow"></div>
		<a id="fb_invite_some" href="#">My friends</a>
		<div class="sub">
			<ul>
				<li><a id="fb_invite_many" href="#">Invite many</a></li>
				<li><a id="fb_invite" href="#">Ask some</a></li>
			</ul>
		</div>
	</li>
	<li class="user">
		<div class="arrow"></div>
		<a href="<?php echo url_for('user', $user)?>"><span><img src="<?php echo $user_image?>" alt="" width="21" height="21" /></span><strong><?php echo $user->getFirstName()?></strong></a>
		<div class="sub">
			<ul>
				<li><a href="<?php echo url_for('my_scenes', $user)?>">Clips</a></li>
				<li><a href="<?php echo url_for('my_boards', $user)?>">Channels</a></li>
				<li class="before-divider"><a href="<?php echo url_for('my_likes', $user)?>">Likes</a></li>
				<li class="divider"><a href="<?php echo url_for('list_followings', $user)?>">Following</a></li>
				<li class="before-divider"><a href="<?php echo url_for('list_followers', $user)?>">Followers</a></li>
				<li class="divider"><a href="<?php echo url_for('sf_guard_signout')?>">Logout</a></li>
			</ul>
		</div>
	</li>
	<li class="about">
		<div class="arrow"></div>
		<a href="<?php echo $fb_page_url?>">About</a>
		<div class="sub">
			<ul>
				<li><a href="">Copyright</a></li>
				<li><a href="<?php echo $fb_page_url?>">Blog</a></li>
			</ul>
		</div>
	</li>
</ul>
<script type="text/javascript">
	//fbHooks(<?php echo $fb_app_id?>, false, false, false, '<?php echo url_for('invites_callback')?>');

	asyncRequestor.call('facebook', function(){
		function sendRequestViaMultiFriendSelector() {
			FB.ui({method: 'apprequests',
				message: 'Please comment my new video clips!',
				filters: ["app_non_users"]
			}, function(response){
				$.ajax({
					url: '<?php echo url_for('invites_callback')?>',
					type: "POST",
					data: {result: response},
					/*beforeSend: function(){highliteControlTab(scene_id);seekTo(secs);},*/
					success: function(result){
						$.each(response.to, function(index, value){
							_kmq.push(['record', 'Invited friend', {'Where':'facebook', 'friend':value}]);
						});
					}
				});
			});
		}

		function sendRequestViaMultiFriendSelectorMany() {
			var user_ids = [];
			FB.api('/me/friends', function(response) {
				$(response.data).each(function(index, value){
					user_ids.push(value.id);
				});
				function randOrd(){
					return (Math.round(Math.random())-0.5); }
				user_ids = user_ids.sort( randOrd );
				FB.ui({method: 'apprequests',
					message: 'Please comment my new video clips!',
					filters: ["app_non_users"],
					to: user_ids.slice(0, 50)
				}, function(response){
					$.ajax({
						url: '<?php echo url_for('invites_callback')?>',
						type: "POST",
						data: {result: response},
						/*beforeSend: function(){highliteControlTab(scene_id);seekTo(secs);},*/
						success: function(result){
							$.each(response.to, function(index, value){
								_kmq.push(['record', 'Invited friend', {'Where':'facebook', 'friend':value}]);
							});
						}
					});
				});
			});
			return false;
		}
		$('#fb_invite').click(function(){
			sendRequestViaMultiFriendSelector();
			return false;
		});

		$('#fb_invite_some').click(function(){
			sendRequestViaMultiFriendSelector();
			return false;
		});

		$('#fb_invite_many').click(function(){
			sendRequestViaMultiFriendSelectorMany();
			return false;
		});
	});
</script>
<?php endif;?>