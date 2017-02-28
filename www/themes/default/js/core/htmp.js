var htmpIns;
var htmpUrlSender = "//ssxcommerce.com/";
var htmpInterval;
var htmpPressure = 0.02;

$(document).ready(function()
{
	function htmpInit()
	{
		var d = document, s = 'script', id = 'htmp-tck',
		js, hjs = d.getElementsByTagName(s)[0];
	    if (d.getElementById(id)) return;
	    js = d.createElement(s); js.id = id;
	    js.src = "//ssxcommerce.com/core/library/js/heatmap.min.js";
	    hjs.parentNode.insertBefore(js, hjs);
	    
	    js.onload = function(){
	    	 htmpIns = h337.create({
	 			container: document.querySelector('.htmp-c'),
	 			radius: 60
	 		});
	 		
	 		document.querySelector('.htmp-b').onmousemove = function(ev){
	 		   htmpIns.addData({
	 			  x: ev.layerX,
	 			  y: ev.layerY,
	 			  value: htmpPressure
	 		  });
	 		};	 		
	    };	   
	}
	
	htmpInit();
	
	$( "body" ).addClass('htmp-b');
	var dcanvas=document.createElement('div');
	$(dcanvas).addClass('htmp-c').hide().appendTo('body');
	$(window).on('beforeunload',function() { htmpCollect(); return "deseja realmente sair?";});
	
	function htmpCollect()
	{
		
		var data = htmpIns.getData();
		var dataToSend = {
		    'dajax':{
				'ua' : navigator.userAgent,
				'hdata' : data,
				'dwidth' : $(document).width(),
				'dheight' : $(document).height(),
				'url' : window.location.href
			}
		};	
		
		$.ajax({
			  url: htmpUrlSender,
			  data : dataToSend,
			  type: "POST",
			  dataType: 'json',
			  success : function(){},
			  error : function(){ console.log('error to collect htmp data');}
		});
	}
});


