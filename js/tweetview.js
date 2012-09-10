var twitter = new Object();

twitter.parseText = function(text) {
	var regexp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
	text = text.replace(regexp, '<a href="$1" target="_blank">$1<\/a>');

	var regexp = /\s?(#([A-Z0-9äöü]+))/ig;
	text = text .replace(regexp, ' <a href="http://twitter.com/#!/search?q=%23$2" target="_blank">$1<\/a>');

	var regexp = /([@])([\w]+)/ig;
	return text.replace(regexp, '<a href="http://twitter.com/#!/$2" target="_blank">$1$2<\/a>');
};

String.prototype.delNofollow = function() {
	return this.replace(/ ?rel="nofollow"/ig, '');
};

twitter.calcTime = function(tstr) {
	var str;
	var now = new Date();
	var d = tstr.substring(8, 10);
	var m = tstr.substring(4, 7);
	var y = tstr.substring(26, 30);
	var time = tstr.substring(10, 19);
	var date = d + ' ' + m + ' ' + y + ' ' + time + ' +0000';
	var ts = parseInt(Date.parse(date)) / 1000;
	var diff = Math.round(now.getTime() / 1000 - ts);

	if (diff < 60) {
		str = diff + ((diff > 1) ? ' ' + localizing_tweetview_js.seconds : ' ' + localizing_tweetview_js.second);
	} else if (diff < 3600) {
		str = Math.round(diff / 60);
		str += ((str > 1) ? ' ' + localizing_tweetview_js.minutes : ' ' + localizing_tweetview_js.minute);
	} else if (diff < 86400) {
		str = Math.round(diff / 3600);
		str += ((str > 1) ? ' ' + localizing_tweetview_js.hours : ' ' + localizing_tweetview_js.hour);
	} else {
		str = Math.round(diff / 86400);
		str += ((str > 1) ? ' ' + localizing_tweetview_js.days : ' ' + localizing_tweetview_js.day);
	}

	return str;
};

twitter.load = function(name, tweetcount) {
	jQuery.getJSON('http://twitter.com/status/user_timeline/' + name + '.json?count=' + tweetcount + '&callback=?', function(data) {
		var twitterbox = document.getElementById('tweetview_tweetlist');
		twitterbox.innerHTML = '';

		jQuery.each(data, function(i, tweet) {
			if (tweet.created_at != undefined) {
				text = twitter.parseText(tweet.text);
				source = tweet.source.delNofollow();

				var lItem = document.createElement('li');

				lItem.setAttribute('class', 'tweet');

				twitterbox.appendChild(lItem);
				twitterbox.lastChild.innerHTML = '<span class="tweetview-widget-tweettext">' + text + '<\/span><br \/><span class="tweetview-widget-time-ago">' + localizing_tweetview_js.ago + ' <a href="http://twitter.com/#!/' + name + '/status/' + tweet.id_str + '">' + twitter.calcTime(tweet.created_at) + '<\/a><\/span>';
			}
		});
	});
};