/**
 * Created by Hector  on 26/10/2016.
 */

//V1 OK

$("#area_id").change(function(event){
   $.get("/persons/"+event.target.value+"",function(response,state){
       // console.log(response);
       $("#person_id").empty();
       for (i=0; i<response.length; i++){
           $("#person_id").append("<option value='"+response[i].id+"'>"+response[i].first_name+' ' +response[i].last_name+"</option>");
       }
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