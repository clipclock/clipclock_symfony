var __fbAsyncLoad = function()
{
	var d = document;
	var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement('script'); js.id = id; js.async = true;
	js.src = "//connect.facebook.net/en_US/all.js";
	ref.parentNode.insertBefore(js, ref);
}

var __youtubeAsyncLoad = function()
{
	var tag = document.createElement('script');
	tag.src = "http://www.youtube.com/player_api";
	var firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

var asyncRequestor = function(){};

asyncRequestor.prototype = {
	callbacks:{},
	loaded: {},
	called: {},
	call: function(type, callback){

		var obj = this;

		if (this.loaded[type] != undefined || $.browser.msie){

			if($.browser.msie)
			{
				setTimeout(function(){
					callback();
				}, 700);
			}
			else
			{
				callback();
			}

		} else {

			if (this.callbacks[type] == undefined){
				this.callbacks[type] = {};
				this.callbacks[type].arr = [];
			}
			this.callbacks[type].arr.push(callback);

			if (this.called[type] == undefined){

				this.called[type] = true;

				switch(type){
					case 'facebook':

						window.fb_already_loaded = false;

						window.fbAsyncInit = function() {

							FB.init({
								appId      : $('#site-data').attr('data-fb-app-id'),
								channelUrl : '//clipclock.com/channel.html',
								status     : true, // check login status
								cookie     : true, // enable cookies to allow the server to access the session
								xfbml      : true, // parse XFBML
								oauth: true,
								frictionlessRequests : true
							});

							window.fb_already_loaded = true;
							obj.loaded[type] = true;

							var func;
							while((func = obj.callbacks[type].arr.pop()) != null)
								func();
						}

						__fbAsyncLoad();

						break;

					case 'youtube':

						window.onYouTubePlayerAPIReady = function(){
							obj.loaded[type] = true;
							var func;

							while((func = obj.callbacks[type].arr.pop()) != null)
								func();
						}

						__youtubeAsyncLoad();

						break;
				}

			}
		}
	}
}

var asyncRequestor = new asyncRequestor();

asyncRequestor.call('facebook', function(){});
if (!$.browser.msie)
	asyncRequestor.call('youtube', function(){});