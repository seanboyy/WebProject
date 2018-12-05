function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    ev.currentTarget.appendChild(document.getElementById(data));
	//$("#deck-images").append("<input type='button' id='removebtn'>");
	$('#f-deck-list').append(data + " ");
}
/*
function removeCard(){
	console.log("removing...");
	console.log($(this));
	//var imagesrc =  $(this).prev().attr('src');
	$(this).remove();
	//console.log(imagesrc);
	//var strArr = $('#f-deck-list').val().split(" ");
	//console.log(strArr.filter(e => e !== imagesrc));
	//strArr = strArr.filter(e => e !== imagesrc);
	//$('#f-deck-list').val() = strArr;
}
*/