var PostingService = {

    init: function(){
      PostingService.fillTiers('#tierList');
      $('#addPostingForm').validate({
        submitHandler: function(form) {
          var entity = Object.fromEntries((new FormData(form)).entries());
          if (!isNaN(entity.id)){
            // update method
            var id = entity.id;
            delete entity.id;
            PostingService.update(id, entity);
          }else{
            // add method
            PostingService.add(entity);
          }
        }
      });
      PostingService.list();
    },

    fillTiers: function (list, mun_id = null) {
     $.ajax({
       url: "rest/tiers",
       type: "GET",

       success: function (data) {

         $(list).append("<option value=\"\"></option>");
         for (let i = 0; i < data.length; i++) {
           $(list).append("<option value='" + data[i].id + "'>" + data[i].price + '-' + data[i].description + "</option>");
         };

         var $select = $(list).selectize({
           create: false,
           sortField: "text",
           placeholder: "Choose your pricing tier"
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
    listMyPostings: function(){
      var id = (UserService.parseJWT(localStorage.getItem("token"))).id;
      $.ajax({
         url: "rest/postings/" + id + "/photographer",
         type: "GET",
         beforeSend: function(xhr){
           xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
         },
         success: function(data) {

           $("#posting-list").html("");
           var html = "";
           for(let i = 0; i < data.length; i++){
             html += `
             <div class="col-lg-3">
               <div class="card" style="background-color:white">
                 <img class="card-img-top" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22286%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20286%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_17ff3c8cf14%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A14pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_17ff3c8cf14%22%3E%3Crect%20width%3D%22286%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22107.19140625%22%20y%3D%2296.3%22%3E286x180%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Card image cap">
                 <div class="card-body">
                   <h5 class="card-title">`+ data[i].title +`</h5>
                   <p class="card-text">`+ data[i].description +`</p>
                   <div class="btn-group" role="group">
                     <button type="button" class="btn btn-primary note-button" onclick="PostingService.getPhotographersInfo(`+data[i].id+`)">Info about photographer</button>
                     <button type="button" class="btn btn-success note-button" onclick="PostingService.getPricingInfo(`+data[i].id+`)">View price</button>
                     <button type="button" class="btn btn-danger note-button" onclick="PostingService.delete(`+data[i].id+`)">Delete</button>
                   </div>
                 </div>
               </div>
             </div>
             `;
           }
           $("#posting-list").html(html);
         },
         error: function(XMLHttpRequest, textStatus, errorThrown) {
           toastr.error(XMLHttpRequest.responseJSON.message);
           UserService.logout();
         }
      });
    },

    list: function(){
      $.ajax({
         url: "rest/postings",
         type: "GET",
         beforeSend: function(xhr){
           xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
         },
         success: function(data) {

           $("#posting-list").html("");
           var html = "";
           for(let i = 0; i < data.length; i++){
             html += `
             <div class="col-lg-3">
               <div class="card" style="background-color:white">
                 <img class="card-img-top" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22286%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20286%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_17ff3c8cf14%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A14pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_17ff3c8cf14%22%3E%3Crect%20width%3D%22286%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22107.19140625%22%20y%3D%2296.3%22%3E286x180%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Card image cap">
                 <div class="card-body">
                   <h5 class="card-title">`+ data[i].title +`</h5>
                   <p class="card-text">`+ data[i].description +`</p>
                   <div class="btn-group" role="group">
                     <button type="button" class="btn btn-primary note-button" onclick="PostingService.getPhotographersInfo(`+data[i].id+`)">Info about photographer</button>
                     <button type="button" class="btn btn-success note-button" onclick="PostingService.getPricingInfo(`+data[i].id+`)">View price</button>
                   </div>
                 </div>
               </div>
             </div>
             `;
           }
           $("#posting-list").html(html);
         },
         error: function(XMLHttpRequest, textStatus, errorThrown) {
           toastr.error(XMLHttpRequest.responseJSON.message);
           UserService.logout();
         }
      });
    },

    getPhotographersInfo: function(id){
      $.ajax({
         url: 'rest/' + id + '/photographers',
         type: "GET",
         beforeSend: function(xhr){
           xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
         },
         success: function(data) {
           PostingService.getCategoryInfo(data[0].id);
           var html="";
           html+=`
           <p> Name: `+ data[0].name +`</p>
           <p> Email: `+ data[0].email +`</p>
           <p> Contact: `+ data[0].contact +`</p>
           <p> About: `+ data[0].about +`</p>
           `;

           $("#modal_body").html(html);
           $('#photographerInfoModal').modal("show");
         },
         error: function(XMLHttpRequest, textStatus, errorThrown) {
           toastr.error(XMLHttpRequest.responseJSON.message);
           $('.note-button').attr('disabled', false);
         }});
    },

    getCategoryInfo: function(id){
      $.ajax({
         url: 'rest/categories/photographer/' + id,
         type: "GET",
         beforeSend: function(xhr){
           xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
         },
         success: function(data) {
           var html= "";
           html+=`
           <p> Category: `+ data[0].name +`</p>
           <p> About category: `+ data[0].description +`</p>
           `;

           $("#modal_body1").html(html);
      //     $('#photographerInfoModal').modal("show"); */
         },
         error: function(XMLHttpRequest, textStatus, errorThrown) {
           toastr.error(XMLHttpRequest.responseJSON.message);
           $('.note-button').attr('disabled', false);
         }});
    },

    getPricingInfo: function(id){
      $.ajax({
         url: 'rest/postings/' + id + '/tiers',
         type: "GET",
         beforeSend: function(xhr){
           xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
         },
         success: function(data) {

           var html="";
           html+=`
           <p> Price: `+ data[0].price +`</p>
           <p>`+ data[0].description +`</p>
           `;

           $("#modal_body2").html(html);
           $('#pricingInfoModal').modal("show");
         },
         error: function(XMLHttpRequest, textStatus, errorThrown) {
           toastr.error(XMLHttpRequest.responseJSON.message);
           $('.note-button').attr('disabled', false);
         }});
    },

    get: function(id){
      $('.note-button').attr('disabled', true);

      $.ajax({
         url: 'rest/postings/'+id,
         type: "GET",
         beforeSend: function(xhr){
           xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
         },
         success: function(data) {
           $('#addPostingForm input[name="id"]').val(data.id);
           $('#addPostingForm input[name="title"]').val(data.name);
           $('#addNoteForm input[name="description"]').val(data.description);


           $('.note-button').attr('disabled', false);
           $('#addNoteModal').modal("show");
         },
         error: function(XMLHttpRequest, textStatus, errorThrown) {
           toastr.error(XMLHttpRequest.responseJSON.message);
           $('.note-button').attr('disabled', false);
         }});
    },

    add: function(entity){
      var user_id = (UserService.parseJWT(localStorage.getItem("token"))).id;
      //console.log(user_id);
      entity.photographer_id = user_id;
      entity.tier_id = $('select[class*="selectize"] option').val();


      $.ajax({
        url: 'rest/postings',
        type: 'POST',
        beforeSend: function(xhr){
          xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
        },
        data: JSON.stringify(entity),
        contentType: "application/json",
        dataType: "json",
        success: function(result) {
            $("#note-list").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
            PostingService.list(); // perf optimization
            $("#addPostingModal").modal("hide");
            toastr.success("Posting added!");
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


    delete: function(id){
      $('.note-button').attr('disabled', true);
      $.ajax({
        url: 'rest/postings/'+id,
        beforeSend: function(xhr){
          xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
        },
        type: 'DELETE',
        success: function(result) {
            $("#note-list").html('<div class="spinner-border" role="status"> <span class="sr-only"></span>  </div>');
            PostingService.list();
            toastr.success("Posting deleted!");
        }
      });
    },

}
