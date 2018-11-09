$(document).ready(function(){
	var i = 1;
	i = loadImages(i, 3);
});

function loadImages(offPoint, count){
	var i = offPoint;
	for(; i < count; ++i){
		console.log('#cardImg'.concat(i));
		$('#cardImg'.concat(i)).attr('src', 'https://api.scryfall.com/cards/random?format=image&version=normal');
		//setImage('#cardImg'.concat(i), 'https://api.scryfall.com/cards/random?format=image&version=normal');
		console.log("doing wait");
		sleep(1000);
		console.log("waited");
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
