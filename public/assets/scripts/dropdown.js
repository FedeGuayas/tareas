/**
 * Created by Hector  on 26/10/2016.
 */

//V1 OK

$("#area_id").change(function(event){
   $.get("/users/"+event.target.value+"",function(response,state){
       // console.log(response);
       $("#user_id").empty();
       for (i=0; i<response.length; i++){
           $("#user_id").append("<option value='"+response[i].id+"'>"+response[i].first_name+' ' +response[i].last_name+"</option>");
       }
       $("#user_id").trigger("chosen:updated");//estas dos lineas son solo para actualizar el choosen js
       $("#user_id").trigger("liszt:updated");
   });
});



//V2
// $("#area_id").change(event=>{
//     $.get(`persons/${event.target.value}`,function(res,sta){
//         // console.log(response);
//         $("#person_id").empty();
//         res.forEach(element=>{
//             $("#person_id").append(`<option value=${element.id}> ${element.first_name}</option>`);
// });
// });
// });