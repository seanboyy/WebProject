var funqueue = [];

$(document).ready(function(){
	funqueue.push(loadImageOurs);
	/*
	for(var i = 0; i < 10; ++i){
		funqueue.push(loadImage);
	}
	*/
});

var hovering = false;

function doEntry(){
	hovering = true;
	setTimeout(function(){
		if(hovering){
			console.log("hello");
		}
		else{
			console.log("where did you go?");
		}
	}, 1000);
}

function doLeave(){
	hovering = false;
	console.log("goodbye");
}

/*
var lastScrollTop = 0;
$(document).scroll(function(){
	var st = $(this).scrollTop();
	if (st > lastScrollTop){
		if(funqueue.length < 5){
			funqueue.push(loadImage);
		}
	}
	lastScrollTop = st;
});
*/

function loadImage(){
	loadImages(1);
}

function loadImageOurs(){
	var url = "/WebProject/get-images.php";
	var jqxhr = $.get(url);
	jqxhr.done(function(data){
		var _images = data.split(/<.?body>/);
		$("#cards").append(_images[1]);
	});
}

function sleep(){
	sleep(100);
}

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

setInterval(executeQueue, 75);
