$(document).ready(function(){

	$("#managerDB").click(function(){
		$(".manager-db").show();
		$(".enable-supplier").hide();
		$(".blocked-user").hide();
	});

	$("#enableSupplier").click(function(){
		$(".manager-db").hide();
		$(".enable-supplier").show();
		$(".blocked-user").hide();
	});

	$("#blockedUser").click(function(){
		$(".manager-db").hide();
		$(".enable-supplier").hide();
		$(".blocked-user").show();
	});


});