
function Post_Gonder(formid,islemad){ 
    
    var veriler = $('#'+formid).serialize(); 
    $.ajax({ 
        type: "POST", 
        url: "inc/islem.php?"+islemad+"=1", 
        data: veriler, 
    success:function(cevap){ 
        $("#bilgi").html(""+cevap); 
    } 
})}; 





 


