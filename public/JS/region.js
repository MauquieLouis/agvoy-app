var regions = document.getElementsByTagName('path')
	 var regionsData = $('.js-regions')
	 var namesRegions = []
	 for(var i = 0; i<regions.length; i++)
	 {
	 	//créer un tableau contenant les noms de régions
	 	namesRegions[i] = regions[i].id;
	 }
	 //Supprimer les doubles du tableau
	 namesRegions = [...new Set(namesRegions)];
	 
	 regionsLink = []
//	 console.log(regionsData)
	 console.log(namesRegions)
	 for(var i = 0; i<regionsData.length; i++)
	 {
	 	//créer un tableau contenant les noms de régions associés aux lien pour les détails d'une région
	 	for(var j = 0; j< namesRegions.length; j++){
			console.log($(regionsData[i]).data('region'))
		 	if($(regionsData[i]).data('region') == namesRegions[j] ){
		 		regionsLink[namesRegions[j]] = $(regionsData[i]).data('link')
		 	}
	 	}
	 }
	 console.log(regionsLink)
	 
	 for(var i = 0; i<regions.length; i++){
	 	regions[i].onclick = function() {
	  		document.location.href=regionsLink[this.id];
	 	}
	 }
