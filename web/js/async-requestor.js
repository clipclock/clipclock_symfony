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
	callbacks: [],
	loaded: {},
	call: function(type, callback){

		var obj = this;

		console.log('asyncRequestor: loading ' + type);
		console.log('asyncRequestor: facebook ' + this.loaded.facebook);
		console.log('asyncRequestor: youtube ' + this.loaded.youtube);

		if (this.loaded[type] != undefined){

			callback();

		} else {

			this.callbacks.push(callback);

			switch(type){
				case 'facebook':

					window.fb_already_loaded = false;

					console.log('im in facebook');

					window.fbAsyncInit = function() {

						console.log('im in facebook async');

						FB.init({
							appId      : '365665100128423',
							channelUrl : '//clipclock.com/channel.html',
							status     : true, // check login status
							cookie     : true, // enable cookies to allow the server to access the session
							xfbml      : true, // parse XFBML
							oauth: true,
							frictionlessRequests : true
						});

						console.log(FB);

						function fbEnsureInit(callback, obj) {

							if(!window.fb_already_loaded) {

								setTimeout(function(){
									fbEnsureInit(callback);
								}, 50);

							} else {

								window.fb_already_loaded = true;
								obj.loaded[type] = true;

								var func;
								while((func = obj.callbacks.pop()) != null)
									func();
							}
						}

						fbEnsureInit(callback, obj);
					}

					__fbAsyncLoad();

					break;

				case 'youtube':

						window.onYouTubePlayerAPIReady = function(){
							obj.loaded[type] = true;
							var func;
							while((func = obj.callbacks.pop()) != null)
								func();
						}

						__youtubeAsyncLoad();

					break;
			}
		}
	}
}

var asyncRequestor = new asyncRequestor();