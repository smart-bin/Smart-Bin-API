var API = 
{
	apiBaseUrl: "http://localhost/hr/internetfornature/",

	registerNewUser: function (name, email, password, onSuccess)
	{
		$.post(this.apiBaseUrl + "users.php", {newUser:{Name:name, Email:email, Password:password}}).done(function(data){
			onSuccess(data);
		});
	},
	
	registerNewBin: function (ownerId, name, type, onSuccess)
	{
		$.post(this.apiBaseUrl + "users.php", {newBin:{Name:name, OwnerId:ownerId, Type:type}}).done(function(data){
			onSuccess(data);
		});
	},
	
	getUser: function(userId, onSuccess)
	{
		return $.ajax({
			dataType: "JSON",
			method:"GET",
			url: this.apiBaseUrl + "users.php?id=" + userId,
			success: function(data)
			{
				onSuccess(data);
			}	
		});
	},
	
	getAllUsers: function(onSuccess)
	{
		return $.ajax({
			dataType: "JSON",
			method:"GET",
			url: this.apiBaseUrl + "users.php",
			success: function(data)
			{
				onSuccess(data);
			}	
		});
	},
	
	getBin: function(binId, onSuccess)
	{
		return $.ajax({
			dataType: "JSON",
			method:"GET",
			url: this.apiBaseUrl + "bins.php?id=" + binId,
			success: function(data)
			{
				onSuccess(data);
			}	
		});
	},
	
	getAllBins: function(onSuccess)
	{
		return $.ajax({
			dataType: "JSON",
			method:"GET",
			url: this.apiBaseUrl + "bins.php",
			success: function(data)
			{
				onSuccess(data);
			}	
		});
	},
	
	updateBinWeight: function(id, weight, onSuccess)
	{
		$.post(this.apiBaseUrl + "updateBinWeight.php", {userId: id, newWeight: weight}).done(function(data){
			onSuccess(data);
		});
	},
	
	awardPoints: function(id, pointObject, onSuccess)
	{
		$.post(this.apiBaseUrl + "awardPoints.php", {userId: id, points: pointObject}).done(function(data){
			onSuccess(data);
		});
	}
}