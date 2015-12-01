$(init);

function init()
{
	//API.awardPoints(10, {Plastic: 10});
	//API.awardPoints(2, {Organic: 10, Glass: 45});
	//API.registerNewHistory(1, 5, 1448965165, function(data){console.log(data)});
	
	//API.getAllUsers("bins", function(data){console.log(data)});
	
	/*var apiBaseUrl = "http://timfalken.com/hr/internetfornature/";
	var binId = 1;
	var weight = 3;
	var unixTimestamp = 1448965065;
	
	
	
	$.post(apiBaseUrl + "history.php", {newStamp:{BinId:binId, Weight:weight, UnixTimestamp:unixTimestamp}}).done(function(data){
			if (typeof onSuccess === "function")
				onSuccess(data);
		});*/
	API.registerNewUser("TimsPointsTest", "Point@Test.com", "testin", function(data){console.log(data)});
	/*$.post("users.php", {newUser:{Name:'Appel', Email:"Appel@appelland.com", Password:"123"}}).done(function(data){
		$("#result").text(data);
	});*/
}