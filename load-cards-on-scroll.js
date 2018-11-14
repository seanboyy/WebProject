var funqueue = [];
var imgIdx = 0;

$(document).ready(function(){
	for(var i = 0; i < 1; ++i){
		funqueue.push(loadImage);
		//funqueue.push(sleep);
	}
});

var lastScrollTop = 0;
$(document).scroll(function(){
	var st = $(this).scrollTop();
	if (st > lastScrollTop){
		if(funqueue.length < 10){
			funqueue.push(loadImage);
			//funqueue.push(sleep);
		}
	}
	lastScrollTop = st;
});

function loadImage(){
	loadImages(1);
}

function sleep(){
	sleep(100);
}

function loadImages(count){
	var url = "/WebProject/card_images/";
	var jqxhr = $.get(url);
	jqxhr.done(function(data){
		var _images = data.match(/href="(.*?\.jpg|.*?\.png|.*?\.jpeg)"/gi);
		for(var i = 0; i < _images.length; ++i){
			var tokens = _images[i].split("\"");
			var imgsrc = url + tokens[1];
			$('#cards').append('<img alt="' + tokens[1] + '" src="' + imgsrc + '" class="cardFormat"/>');
		}
	});
	/*
	for(; imgIdx < count && imgIdx < files.length; ++imgIdx){
		
	}
	*/
}

/*
function loadImages(count){
	for(var i = 0; i < count; ++i){
		var imgsrc;
		var url = 'https://api.scryfall.com/cards/random';
		var jqxhr = $.get(url);
		jqxhr.done(function(data){
			var obj = data;
			imgsrc = obj.image_uris.normal;
			imgsrc = imgsrc.split("?")[0];
			$('#cards').append('<img alt="cardImage" src="' + imgsrc + '" class="cardFormat"/>');
		});
		sleep(100);
	}
}
*/

function sleep(milliseconds) {
	var start = new Date().getTime();
	for (var i = 0; i < 1e10; i++) {
		if ((new Date().getTime() - start) > milliseconds){
			break;
		}
	}
}

function executeQueue(){
	if(funqueue.length > 0) (funqueue.shift())();
}

setInterval(executeQueue, 100);
