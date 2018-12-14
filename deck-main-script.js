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

function DeckHolder(){
	this.hasUpvoted = false;
	this.hasDownvoted = false;
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
	if(decks[deckId - 1].hasUpvoted) getString = getString.concat("hasUpvoted&");
	if(decks[deckId - 1].hasDownvoted) getString = getString.concat("hasDownvoted&");
	decks[deckId - 1].hasDownvoted = false;
	getString = getString.concat("id=" + deckId);
	var url = "/WebProject/do-voting.php?" + getString;
	console.log(url);
	var jqxhr = $.get(url);
	jqxhr.done(function(data){
		var newCount = data.split(/<.?body>/);
		var fun = wrapFunction(updateText, document, ['#dpu' + deckId, newCount[1]]);
		funqueue.push(fun);
	});
	decks[deckId - 1].hasUpvoted = !decks[deckId - 1].hasUpvoted;
}

function doDownvote(deckId){
	var getString = "type=deck&isDownvoting&";
	if(decks[deckId - 1].hasUpvoted) getString = getString.concat("hasUpvoted&");
	if(decks[deckId - 1].hasDownvoted) getString = getString.concat("hasDownvoted&");
	decks[deckId - 1].hasUpvoted = false;
	getString = getString.concat("id=" + deckId);
	var url = "/WebProject/do-voting.php?" + getString;
	console.log(url);
	var jqxhr = $.get(url);
	jqxhr.done(function(data){
		var newCount = data.split(/<.?body>/);
		var fun = wrapFunction(updateText, document, ['#dpu' + deckId, newCount[1]]);
		funqueue.push(fun);
	});
	decks[deckId - 1].hasDownvoted = !decks[deckId - 1].hasDownvoted;
}

function executeQueue(){
	if(funqueue.length > 0) (funqueue.shift())();
}

setInterval(executeQueue, 5);