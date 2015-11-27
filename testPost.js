$(init);

function init()
{
	var userId = 2;
	var obj = {Tin: -1000, Plastic: 10, Glass: 45, Biological: 35};
	
	console.log(obj);
	
	API.awardPoints(userId, obj, function(res)
	{
		$("#result").text(res);
		API.getUser(userId, function(data){console.log(data)});
	});
	//API.registerNewUser("TestmanTweeNieuw", "TestTweeLol@Testland.com", "test");
	/*$.post("users.php", {newUser:{Name:'Appel', Email:"Appel@appelland.com", Password:"123"}}).done(function(data){
		$("#result").text(data);
	});*/
}