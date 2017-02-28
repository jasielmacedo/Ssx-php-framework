 $(function(){
	$('.action').click(function(){
		var type = $(this).attr('data-type');
		
		switch(type)
		{
			case "delete":
				Ssx.confirm(function(){
					window.location.href = redirectUrl +"?user_delete=true";
				},"Tem certeza que deseja apagar esse "+singular+"?");
			break;
			case "status":
				var status = $(this).attr('data-status');
				var msg;
				
				 if(status){
					msg =  "Tem certeza que deseja desativar esse "+singular+"?\nEle não poderá mais logar no sistema\n";
				 }else{
					msg = "Tem certeza que deseja ativar esse "+singular+"?";
				 }
				
				Ssx.confirm(function(){
					window.location.href = redirectUrl +"?user_alter_status=true";
				},msg);
			break;
		}
	});
 });