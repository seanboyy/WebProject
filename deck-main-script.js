var funqueue = [];

var decks = [];

$(document).ready(function(){
	var temp = document.getElementsByTagName("body")[0].innerHTML.split(/<span class.*?>/);
	for(var i = 1; i < temp.length - 1; ++i){
		decks.push(new DeckHolder());
	}
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
		$("#dpu" + deckId).html(newCount[1]);
	});
	decks[deckId - 1].hasDownvoted = !decks[deckId - 1].hasDownvoted;
}

function executeQueue(){
	if(funqueue.length > 0) (funqueue.shift())();
}

setInterval(executeQueue, 5);