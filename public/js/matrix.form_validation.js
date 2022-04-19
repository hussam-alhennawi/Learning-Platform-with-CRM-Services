$(document).ready(function(){
	/// check current password is correct or not
	$("#pwd_current").keyup(function () {
		var pwd_current=$("#pwd_current").val();
		$.ajax({
            type:'get',
            url:'/admin/check-pwd',
            data:{pwd_current:pwd_current},
            success:function(resp){
                if(resp=="false"){
                    $("#chkPwd").html("<span style='color: red; font-weight: bold;'>Current Password is Incorrect</span>");
                }else if(resp=="true"){
                    $("#chkPwd").html("<span style='color: green;font-weight: bold;'>Current Password is Correct</span>");
                }
            },error:function(){
                alert("Error Ajax");
            }
        });
	});
	////// Check Username is exist or not
	$("#username").keyup(function () {
		var username=$("#username").val();
		$.ajax({
			type:'get',
			url:'/admin/check_user_name',
			data:{username:username},
			success:function (resp) {
				if(resp=="false"){
					$("#user_name").html("<span style='color: green;'>This Username is OK</span>");
				}else if(resp=="true"){
                    $("#user_name").html("<span style='color: red;'>The Username has already been taken.</span>");
				}
            },error:function () {
				alert("Error Ajax");
            }
		});
	});
	////// Check email is exist or not
	$("#email").keyup(function () {
		var email=$("#email").val();
		$.ajax({
			type:'get',
			url:'/admin/check_email',
			data:{email:email},
			success:function (resp) {
				if(resp=="false"){
					$("#CHemail").html("<span style='color: green;'>This email is OK</span>");
				}else if(resp=="true"){
                    $("#CHemail").html("<span style='color: red;'>The email has already been taken.</span>");
				}
            },error:function () {
				alert("Error Ajax");
            }
		});
	});
	
	////// Check phone is valid or not
	// $("#phone").keyup(function () {
	// 	var email=$("#phone").val();
	// 	$.ajax({
	// 		type:'get',
	// 		url:'/admin/check_phone',
	// 		data:{phone:phone},
	// 		success:function (resp) {
	// 			if(resp=="true"){
	// 				$("#CHphone").html("<span style='color: green;'>This phone number is valid</span>");
	// 			}else if(resp=="false"){
    //                 $("#CHphone").html("<span style='color: red;'>The phone isn\'t valid.</span>");
	// 			}
    //         },error:function () {
	// 			alert("Error Ajax");
    //         }
	// 	});
    // });
	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();
	
	$('select').select2();
	
	// Form Validation
    $("#basic_validate").validate({
		rules:{
			name:{
				required:true
			},
			email:{
				required:true,
				email: true
			},
			date:{
				required:true,
				date: true
			},
			url:{
				required:true,
				url: true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
	
	$("#number_validate").validate({
		rules:{
			min:{
				required: true,
				min:10
			},
			max:{
				required:true,
				max:24
			},
			number:{
				required:true,
				number:true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
	
	$("#add_userpassword_validate").validate({
		rules:{
            password:{
				required: true,
				minlength:8,
				maxlength:20
			},
            password_confirm:{
				required:true,
				minlength:8,
				maxlength:20,
				equalTo:"#password"
			},
			email:{
				required:true,
				email: true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
	
	$("#password_validate").validate({
		rules:{
            pwd_current:{
                required: true,
                minlength:8,
                maxlength:20
            },
            pwd_new:{
				required: true,
				minlength:8,
				maxlength:20
			},
            pwdnew_confirm:{
				required:true,
				minlength:8,
				maxlength:20,
				equalTo:"#pwd_new"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
});
