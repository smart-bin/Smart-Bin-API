var API = 
{
	apiBaseUrl: "http://timfalken.com/hr/internetfornature/",

	registerNewUser: function (name, email, password, onSuccess)
	{
		$.post(this.apiBaseUrl + "users.php", {newUser:{Name:name, Email:email, Password:password}}).done(function(data){
			if (typeof onSuccess === "function")
				onSuccess(data);
		});
	},
	
	registerNewBin: function (ownerId, name, type, onSuccess)
	{
		$.post(this.apiBaseUrl + "users.php", {newBin:{Name:name, OwnerId:ownerId, Type:type}}).done(function(data){
			if (typeof onSuccess === "function")
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
				if (typeof onSuccess === "function")
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
				if (typeof onSuccess === "function")
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
				if (typeof onSuccess === "function")
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
				if (typeof onSuccess === "function")
					onSuccess(data);
			}	
		});
	},
	
	updateBinWeight: function(id, weight, onSuccess)
	{
		$.post(this.apiBaseUrl + "updateBinWeight.php", {userId: id, newWeight: weight}).done(function(data){
			if (typeof onSuccess === "function")
				onSuccess(data);
		});
	},
	
	awardPoints: function(id, pointObject, onSuccess)
	{
		$.post(this.apiBaseUrl + "awardPoints.php", {userId: id, points: pointObject}).done(function(data){
			if (typeof onSuccess === "function")
				onSuccess(data);
		});
	}
}