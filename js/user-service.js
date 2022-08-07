var UserService = {
  init: function(){
    UserService.fillCategories('#categoryList');
    var token = localStorage.getItem("token");
    if (token){
      window.location.replace("index.html");
    }
    $('#login-form').validate({
      submitHandler: function(form) {
        var entity = Object.fromEntries((new FormData(form)).entries());
        UserService.login(entity);
      }
    });
    $('#register-form').validate({
      submitHandler: function(form) {
        var entity = Object.fromEntries((new FormData(form)).entries());
        UserService.register(entity);
      }
    });
  },

  register: function(entity){

    entity.category_id = $('select[class*="selectize"] option').val();
  //  console.log(entity);

    $.ajax({
         url: 'rest/register',
         type: 'POST',
         data: JSON.stringify(entity),
         contentType: "application/json",
         dataType: "json",
         success: function (response) {
           localStorage.setItem("token", response.token);
           toastr.success("Successfully registered!", "Information:");
           window.location.replace("index.html");

         },
         error: function (response) {

           toastr.error("Please try again.", "Error!");
         }
       });
  },

  login: function(entity){
    $.ajax({
      url: 'rest/login',
      type: 'POST',
      data: JSON.stringify(entity),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
        //console.log(result);
        localStorage.setItem("token", result.token);

      //  console.log('got here');

      //  console.log('bye');
        window.location.replace("index.html");
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
      }
    });
  },

  parseJWT: function (token) {
    var base64Url = token.split('.')[1];
    var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    var jsonPayload = decodeURIComponent(atob(base64).split('').map(function (c) {
      return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    return (JSON.parse(jsonPayload));
  },

  logout: function(){
    localStorage.clear();
    window.location.replace("login.html");
  },


  fillCategories: function (list, mun_id = null) {
   $.ajax({
     url: "rest/categories",
     type: "GET",

     success: function (data) {
       console.log(data);

       $(list).append("<option value=\"\"></option>");
       for (let i = 0; i < data.length; i++) {
         $(list).append("<option value='" + data[i].id + "'>" + data[i].name + '-' + data[i].description + "</option>");
       };

       var $select = $(list).selectize({
         create: false,
         sortField: "text",
         placeholder: "Enter your category"
       });

       var selectize = $select[0].selectize;
       if(mun_id != null){
         selectize.setValue(mun_id);
       }else{
         selectize.setValue('1000');
       }
     },

    error: function (XMLHttpRequest, textStatus, errorThrown) {
      toastr.error("Please try again.", "Error!");
    }
  });
},
}
