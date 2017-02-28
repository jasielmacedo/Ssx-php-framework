$(function(){
	$('.action').click(function(){
		var type = $(this).attr('data-type');
		
		switch(type)
		{
			case "delete":
				Ssx.confirm(function(){
					window.location.href = redirectUrl +"?delete=true";
				},"Tem certeza que deseja apagar esse "+singular+"? <br />Todos os usuários desse grupo não poderão mais logar,<br /> sendo necessário edita-los e coloca-los em outro "+singular);
			break;
			case "status":
				var status = $(this).attr('data-status');
				var msg;
				
				 if(status){
					msg = "Tem certeza que deseja desativar esse "+singular+"?\nNenhum usuário dentro dele conseguirá logar no sistema\n";
				 }else{
					msg = "Tem certeza que deseja ativar esse "+singular+"?";
				 }
				
				Ssx.confirm(function(){
					window.location.href = redirectUrl +"?group_alter_status=true";
				},msg);
			break;
		}
	});
 });