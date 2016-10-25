$(document).ready(function() {						
	
	function getConfigType(config){
		if (config[config.length-1] == '}') {
			return config;
		}
		return config.replace(/\([^\)]*\)/gi, "").replace(/(.*[^\d])[\d]+([^\d])/gi,"$1n$2");
	}
	
	configTypes=new Array();
	
	for (var i=0;i<level_list.length;i++){
		var configTypeResult = getConfigType(level_list[i].CONFIG);
		var configFlag = true;
		var atomicCoresString = level_list[i].CONFIG.replace(/\)/gi,"),").replace(/,[^\(]*$/,"").replace(/,[^\(]*/gi,",").replace(/^[^\(]*/,"").replace(/[\(\)]/gi,"");
		level_list[i].atomicCores = atomicCoresString.split(",");		
		level_list[i].atomicCoresString = atomicCoresString;
		for (var j = 0; j<configTypes.length;j++){
			if (configTypes[j].name==configTypeResult){
				configFlag = false;
				configTypes[j].levellist[configTypes[j].levellist.length] = i;
				break;
			}
		}		
		if (configFlag){
			configTypes[configTypes.length] = {}
			configTypes[configTypes.length-1].name = configTypeResult;
			configTypes[configTypes.length-1].levellist = new Array();
			configTypes[configTypes.length-1].levellist[0] = i;
		}		
	}
	
	for (var i=0;i<configTypes.length;i++){
		$('#showmethemoney').html($('#showmethemoney').html()+'<b>Type: '+configTypes[i].name+'</b><br>');
		configTypes[i].atomicCores = new Array();
		for (var j=0;j<configTypes[i].levellist.length;j++){
			//$('#showmethemoney').html($('#showmethemoney').html()+'Level: '+level_list[configTypes[i].levellist[j]].CONFIG+' '+level_list[configTypes[i].levellist[j]].atomicCores+'<br>');
			for (var k=0; k<level_list[configTypes[i].levellist[j]].atomicCores.length;k++){
				var coreFlag = 0;
				
			}
		}
	}
	//alert(level_list[0].CONFIG);	
});