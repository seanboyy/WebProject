function makeAdmin(userId){
	var url = "/WebProject/admin_button.php?id="+userId;
	console.log(url);
	var jqxhr = $.get(url);
	jqxhr.done(function(data){
		console.log("Made Admin!");
		window.location.href = 'other_profiles.php';
	});
}
