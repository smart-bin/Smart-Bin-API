$(init);

function init()
{
	var userId = 2;
	API.awardPoints(userId, {Plastic: 10, Glass: 45, Organic: 35});
	
	//API.registerNewUser("TimsPostTest", "Post@Test.com", "test");
	/*$.post("users.php", {newUser:{Name:'Appel', Email:"Appel@appelland.com", Password:"123"}}).done(function(data){
		$("#result").text(data);
	});*/
}