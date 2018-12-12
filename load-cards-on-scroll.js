var funqueue = [];

var funqueue2 = [];

$(document).ready(function(){
	funqueue.push(loadImageOurs);
	$('#f-card-img').change(function(e) {
		var filename = URL.createObjectURL(e.target.files[0]);
		//
		console.log(filename);
		$("#cardPreview").attr('src', filename);
	});
	/*
	for(var i = 0; i < 10; ++i){
		funqueue.push(loadImage);
	}
	*/
});

var wrapFunction = function(fn, context, params){
	return function(){
		fn.apply(context, params);
	}
}

function updateText(el, text){
	$(el).html(text);
}

var hovering = 0;

var doneonce = false;

var oldHTML;

//var cardHolder = {hasUpvoted: false, hasDownvoted: false, defaultHTML: ""};

function cardHolder(up, down, html){
	this.hasUpvoted = up;
	this.hasDownvoted = down;
	this.defaultHTML = html;
}

var cards = [];

var reversed_cards;

function doEntry(cardNum, editSpan){
	hovering = editSpan.id;
	oldHTML = editSpan.innerHTML;
	setTimeout(function(){
		if(hovering == editSpan.id && !doneonce){
			var newcontent = "<table><tbody><tr><td>" + reversed_cards[cardNum - 1].defaultHTML + "</td><td><table><tbody><tr><td class=\"descrip\">"
			var url = "/WebProject/get-card-data.php?id=" + cardNum;
			var jqxhr = $.get(url);
			jqxhr.done(function(data){
				var desc = data.split(/<.?body>/);
				if(desc[1] != "") newcontent = newcontent.concat("Description: " + desc[1]);
				else newcontent = newcontent.concat("User did not upload a description");
				newcontent = newcontent.concat("</td></tr><tr><td><form><table><tbody><tr><td><input class='vote' type='button' onclick='doUpvote(" + cardNum + ")' value='Upvote'></td><td id='mpp" + cardNum + "'>");
				url2 = "/WebProject/get-points.php?type=card&id=" + cardNum;
				jqxhr2 = $.get(url2);
				jqxhr2.done(function(data2){
					var points = data2.split(/<.?body>/);
					newcontent = newcontent.concat(points[1]);
					newcontent = newcontent.concat("</td><td><input class='vote' type='button' onclick='doDownvote(" + cardNum + ")' value='Downvote'></td></tr></tbody></table></form></td></tr></tbody></table>");
					editSpan.innerHTML = newcontent;
				});
			});
			doneonce = true;
		}
	}, 500);
}

function doLeave(cardNum, editSpan){
	hovering = 0;
	editSpan.innerHTML = reversed_cards[cardNum - 1].defaultHTML;
	doneonce = false;
}

function doUpvote(cardNum){
	var getString = "type=card&isUpvoting&";
	if(cards[cardNum - 1].hasUpvoted) getString = getString.concat("hasUpvoted&");
	if(cards[cardNum - 1].hasDownvoted) getString = getString.concat("hasDownvoted&");
	cards[cardNum - 1].hasDownvoted = false;
	getString = getString.concat("id=" + cardNum);
	var url = "/WebProject/do-voting.php?" + getString;
	console.log(url);
	var jqxhr = $.get(url);
	jqxhr.done(function(data){
		var newCount = data.split(/<.?body>/);
		var fun = wrapFunction(updateText, document, ['#mpp' + cardNum, newCount[1]]);
		funqueue2.push(fun);
	});
	cards[cardNum - 1].hasUpvoted = !cards[cardNum - 1].hasUpvoted;
}

function doDownvote(cardNum){
	var getString = "type=card&isDownvoting&";
	if(cards[cardNum - 1].hasUpvoted) getString = getString.concat("hasUpvoted&"); 
	cards[cardNum - 1].hasUpvoted = false;
	if(cards[cardNum - 1].hasDownvoted) getString = getString.concat("hasDownvoted&");
	getString = getString.concat("id=" + cardNum);
	var url = "/WebProject/do-voting.php?" + getString;
	console.log(url);
	var jqxhr = $.get(url);
	jqxhr.done(function(data){
		var newCount = data.split(/<.?body>/);
		var fun = wrapFunction(updateText, document, ['#mpp' + cardNum, newCount[1]]);
		funqueue2.push(fun);
	});
	cards[cardNum - 1].hasDownvoted = !cards[cardNum - 1].hasDownvoted;
}

function deleteDeck(deckID){
	var url = "/WebProject/delete-deck.php?id=" + deckID;
	console.log(url);
	var jqxhr = $.get(url);
	jqxhr.done(function(data){
		console.log("Deck Deleted!");
		window.location.href = 'deck-main.php';
	});
}

function deleteCard(cardID){
	var url = "/WebProject/delete-card.php?id=" + cardID;
	console.log(url);
	var jqxhr = $.get(url);
	jqxhr.done(function(data){
		console.log("Card Deleted!");
		window.location.href = 'index.html';
	});
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
		var __images = _images[1].split(/<span.*?>/);
		for(var i = 1; i < __images.length; ++i){
			var inner = __images[i].split(/<.span>/);
			cards.push(new cardHolder(false, false, inner[0]));
		}
		reversed_cards = cards.reverse();
		var url2 = "/WebProject/get-ids.php";
		var jqxhr2 = $.get(url2);
		jqxhr2.done(function(data2){
			var _ids = data2.split(/<.?body>/);
			var __ids = _ids[1].split(/<br>/);
			var url3 = "/WebProject/get-max.php?type=card";
			var jqxhr3 = $.get(url3);
			jqxhr3.done(function(data3){
				var _max = data3.split(/<.?body>/);
				for(var i = cards.length; i < parseInt(_max[1]); ++i){
					reversed_cards.push(new cardHolder(false, false, ""));
				}
				reversed_ids = __ids.reverse()
				for(var i = reversed_ids.length - 1 ; i >= 0; --i){
					reversed_cards[reversed_ids[i] - 1] = reversed_cards[i];
				}
				console.log(JSON.stringify(reversed_cards));
			});
		});
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

function executeQueue2(){
	if(funqueue2.length > 0) (funqueue2.shift())();
}

setInterval(executeQueue2, 5);

function executeQueue(){
	if(funqueue.length > 0) (funqueue.shift())();
}

setInterval(executeQueue, 75);
