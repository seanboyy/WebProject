var funqueue = [];

var decks = [];

$(document).ready(function(){
	var url = "/WebProject/get-max.php?type=deck";
	var jqxhr = $.get(url);
	jqxhr.done(function(data){
		var _max = data.split(/<.?body>/);
		for(var i = 1; i < parseInt(_max[0]); ++i){
			decks.push(new DeckHolder());
		}	
	});
});

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


function deckHolder(html){
	this.defaultHTML = html;
}

var wrapFunction = function(fn, context, params){
	return function(){
		fn.apply(context, params);
	}
}

function updateText(el, text){
	$(el).html(text);
}

var reversed_decks;

function doEntry(deckNum, editSpan){
	hovering = editSpan.id;
	oldHTML = editSpan.innerHTML;
	setTimeout(function(){
		if(hovering == editSpan.id && !doneonce){
			var newcontent = "<table><tbody><tr><td>" + reversed_decks[deckNum - 1].defaultHTML + "</td><td><table><tbody><tr><td class=\"descrip\">"
			var url = "/WebProject/get-deck-data.php?id=" + deckNum;
			var jqxhr = $.get(url);
			jqxhr.done(function(data){
				var desc = data.split(/<.?body>/);
				if(desc[1] != "") newcontent = newcontent.concat("Description: " + desc[1]);
				else newcontent = newcontent.concat("User did not upload a description");
				newcontent = newcontent.concat("</td></tr><tr><td><form><table><tbody><tr><td><input class='vote' type='button' onclick='doUpvote(" + cardNum + ")' value='Upvote'></td><td id='mpp" + cardNum + "'>");
				url2 = "/WebProject/get-points.php?type=deck&id=" + deckNum;
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

function doLeave(deckNum, editSpan){
	hovering = 0;
	editSpan.innerHTML = reversed_decks[deckNum - 1].defaultHTML;
	doneonce = false;
}

function doUpvote(deckId){
	var getString = "type=deck&isUpvoting&";
	getString = getString.concat("id=" + deckId);
	var url = "/WebProject/do-voting.php?" + getString;
	console.log(url);
	var jqxhr = $.get(url);
	jqxhr.done(function(data){
		var newCount = data.split(/<.?body>/);
		var fun = wrapFunction(updateText, document, ['#dpu' + deckId, newCount[1]]);
		funqueue.push(fun);
	});
}

function doDownvote(deckId){
	var getString = "type=deck&isDownvoting&";
	getString = getString.concat("id=" + deckId);
	var url = "/WebProject/do-voting.php?" + getString;
	console.log(url);
	var jqxhr = $.get(url);
	jqxhr.done(function(data){
		var newCount = data.split(/<.?body>/);
		var fun = wrapFunction(updateText, document, ['#dpu' + deckId, newCount[1]]);
		funqueue.push(fun);
	});
}

function loadImageOurs(){
	var url = "/WebProject/get-deck-images.php";
	var jqxhr = $.get(url);
	jqxhr.done(function(data){
		var _images = data.split(/<.?body>/);
		$("#decks").append(_images[1]);
		var __images = _images[1].split(/<span.*?>/);
		for(var i = 1; i < __images.length; ++i){
			var inner = __images[i].split(/<.span>/);
			decks.push(new deckHolder(inner[0]));
		}
		reversed_decks = decks.reverse();
		var url2 = "/WebProject/get-deck-ids.php";
		var jqxhr2 = $.get(url2);
		jqxhr2.done(function(data2){
			var _ids = data2.split(/<.?body>/);
			var __ids = _ids[1].split(/<br>/);
			var url3 = "/WebProject/get-max.php?type=card";
			var jqxhr3 = $.get(url3);
			jqxhr3.done(function(data3){
				var _max = data3.split(/<.?body>/);
				for(var i = decks.length; i < parseInt(_max[1]); ++i){
					reversed_decks.push(new deckHolder(""));
				}
				reversed_ids = __ids.reverse()
				for(var i = reversed_ids.length - 1 ; i >= 0; --i){
					reversed_decks[reversed_ids[i] - 1] = reversed_cards[i];
				}
				console.log(JSON.stringify(reversed_decks));
			});
		});
	});
}

function executeQueue(){
	if(funqueue.length > 0) (funqueue.shift())();
}

setInterval(executeQueue, 5);