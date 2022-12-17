$(document).ready(function(){
  $("#division").on("change", function(){
        var divisionId = $("#division").val();
        $.ajax({
          method: "POST",
          url: "admin-ajax.php",
          data: {id: divisionId},
          dataType: "html",
          success: function(data){
            $("#district").html(data);
          }
        });
  });

  $("#district").on("change", function(){
    var upzilaId = $("#district").val();
    $.ajax({
      method: "POST",
      url: "admin-ajax.php",
      data: {upzilaId: upzilaId},
      dataType: "html",
      success: function(data){
        $("#upzila").html(data);
      }
    });
});

$("#upzila").on("change", function(){
  var userUnionId = $("#upzila").val();
  $.ajax({
    method: "POST",
    url: "admin-ajax.php",
    data: {userUnionId: userUnionId},
    dataType: "html",
    success: function(data){
      $("#user_union").html(data);
    }
  });
});



});