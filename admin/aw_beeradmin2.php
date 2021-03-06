<?php
// session_start();
// if(!session_is_registered(myusername)){
//  header("location:a_beerlogin.php");
// }
?>
 <!DOCTYPE html>
<html>
    <head>
    <title>Pi Reel Control Panel</title>
    <meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	   <!-- StyleSheets (CSS) -->
		 
<!-- <link rel="stylesheet" href="/css/jquery.mobile-1.3.0-rc.1.min.css" /> -->
<link rel="stylesheet" href="/css/jquery.mobile-1.3.2.min.css" />
	 <link rel="stylesheet" href="/css/swipe_style.css" />
	
	  <link rel="stylesheet" href="/css/themes/pourhouse.css" /> 
	 <link rel="stylesheet" href="/css/themes/jqm-icon-pack-2.0-original.css" />   
	 
	 <!--<link rel="stylesheet" href="css/screen-view.css" />--> 
	 <link rel="stylesheet" href="/css/custom.css" /> 
	  <link rel="stylesheet" href="/css/jsShare.css" />
	   <link rel="stylesheet" type="text/css" href="/css/jquery.jtweetsanywhere-1.3.1.css" /> 
	   <link rel="stylesheet" id="camera-css"  href="/css/camera.css" type="text/css" media="all"> 
	   <link rel="stylesheet" href="/css/jquery-mobile-fluid960.min.css" /> 	
	 <!-- JavaScripts -->
 
	 <!--<script src="/js/jquery-1.8.2.min.js"></script>--> 
	 <script src="/js/jquery-1.10.2.min.js"></script> 
	 	 <script src="/js/jquery-ui.min.js"></script>

	 <script src="/js/modernizr-latest.js" type="text/javascript"></script>
	 <script src="/js/custom.js"></script>
	 <!--<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>-->
	 <script src="/js/jquery.mobile-1.3.2.min.js"></script>
	
		 <script src="/js/swipe.js"  type="text/javascript"></script>
	 <script src="/js/jsShare.js"  type="text/javascript"></script>
 
	 <script type="text/javascript" src="/js/jquery.easing.1.3.js"></script> 
     <script type="text/javascript" src="/js/camera.min.js"></script> 
	 <script src="ckeditor/ckeditor.js"></script>
	 <script src="ckeditor/adapters/jquery.js"></script>
	<script src="/js/jquery.ui.touch-punch.min.js"></script>  
</head>
<body>
 
    <script>
    
    //$(document).bind('pageinit', function() {
    $( document ).delegate("#main", "pageinit", function() {
    var msg = "";  
    var myeditor;   
	var currAdEdit = $('#ad-id.ui-input-text').val();
    $( "#sortable" ).sortable(
    {
    distance: 0, 
    start: function(e, ui) {
        // creates a temporary attribute on the element with the old index
        $(this).attr('data-previndex', ui.item.index());
        $("#sortable li").css("border","0px solid #aaaaaa");
        ui.item.css("border","3px solid #aaaaaa");
        msg="Ad Selected";
        currAdEdit = $('#ad-id.ui-input-text').val();
        tester(ui.item.val());
        
    },
    update: function(e, ui) {
        // gets the new and old index then removes the temporary attribute
        var newIndex = ui.item.index();
        var prevIndex = ui.item.index()-1;
        var prevOrderId = $(this).find('li:eq('+prevIndex+')').children('span:first').text();
       if(prevOrderId == 'Order')prevOrderId=0;
         $("#sortable li").css("border","0px solid #aaaaaa");
         ui.item.css("border","3px solid #aaaaaa");
        ui.item.children('span:first').text(prevOrderId);
        var oldIndex = $(this).attr('data-previndex');
        $("#ad-order").val(parseInt(prevOrderId)+1); 
        $(this).removeAttr('data-previndex');
        //tester(ui.item.val());
         msg ="Ad has been repositioned";
        adupdate();
    }
});
     $( "#sortable" ).disableSelection();
    <!-- Refresh list to the end of sort to have a correct display -->
    $( "#sortable" ).bind( "sortstop", function(event, ui) {
          $('#sortable').listview('refresh');
    });
// }); 
	 		 function tester(adid) { 
		 		 alert('tester'+adid);
             var val=adid;
			  $.ajax({
                    type: "POST",
                    url: "a_updatead.php",
                    cache: false,
                    //async: false,  
                    data: {adlist : 'loadsingle',loadid : val},
                    dataType:"json",
                    success: onSuccessAdSort,
                    error: onErrorAdSort
                });
                   function onSuccessAdSort(data, status)
        {
        
         
         $("#ad-message").html('<h5 style="text-align:center;color:green;">'+msg+'</h5>').show('slow');
         $("#ad-id").val(data[0].id);
         $("#ad-title").val(data[0].ad_title);
         $("#ad-status").val(data[0].astatus);
         $("#ad-timing").val(data[0].atiming);
         $("#ad-order").val(data[0].aorder);
         $("#splash-editor").val(data[0].ad_content);
         
           
        }
           function onErrorAdSort(data, status)
        {
         
               }
                }  

     var beerview = 'ACTIVE';
       
     function onBeerAvailable(data, status)
        {
       if(data.response.found == 0){$("#message_c").text('Beer Not Found.');}
         else{           
         $("#id").val(data.response.beers.items[0].beer.bid);
         $("#beer_name").val(data.response.beers.items[0].beer.beer_name);
         $("#beer_type").val(data.response.beers.items[0].beer.beer_style);
         $("#beer_desc").val(data.response.beers.items[0].beer.beer_description);
         $("#beer_abv").val(data.response.beers.items[0].beer.beer_abv);
         $("#beer_ibu").val(data.response.beers.items[0].beer.beer_ibu);
         $("#brewery_id").val(data.response.beers.items[0].brewery.brewery_id); 
         $("#brewery_name").val(data.response.beers.items[0].brewery.brewery_name);
         var city = data.response.beers.items[0].brewery.location.brewery_city+'-'+data.response.beers.items[0].brewery.location.brewery_state; 
         $("#brewery_city").val(city); 
         $("#brewery_url").val(data.response.beers.items[0].brewery.contact.url);        
         var beer_label =  data.response.beers.items[0].beer.beer_label; 
         var brewery_label =  data.response.beers.items[0].brewery.brewery_label;
         //alert(data.response.beers.items[0].brewery.brewery_label);
         $("#beer_label").attr("src", beer_label);
         $("#beer_label_url").val(data.response.beers.items[0].beer.beer_label);
         $("#brewery_label").attr("src", brewery_label); 
         $("#brewery_label_url").val(brewery_label);        
         $("#beer_status").val("INACTIVE");
         $("#beer_glass_price").val("4.50")
         $("#beer_growler_price").val("10.95")
         $("#beer_special").val("OFF")
        
         getBeer(data.response.beers.items[0].beer.bid);
         
		 }
          
        }
  

        function onSuccessBeer(data, status)
        {
          //alert('data:'+data); 
         
          if(data != false){ 
         $("#message_c").text('Beer Searched EXISTS in Current Beer List, see shaded text.');   
         $("#id_c").text(data.id);
         $("#beer_label_url_c").text(data.beer_label_url);
         $("#brewery_label_url_c").text(data.brewery_label_url);
         $("#beer_name_c").text(data.beer_name);
         $("#beer_type_c").text(data.beer_style);
         $("#beer_desc_c").text(data.beer_desc);
         $("#beer_abv_c").text(data.beer_abv);
         $("#beer_ibu_c").text(data.beer_ibu);
         $("#brewery_id_c").text(data.brewery_id); 
         $("#brewery_name_c").text(data.brewery_name); 
         $("#brewery_city_c").text(data.brewery_city); 
         $("#brewery_url_c").text(data.brewery_url); 
         $("#beer_status_c").text(data.beer_status);
         $("#beer_glass_price_c").text(data.beer_glass_price);
         $("#beer_growler_price_c").text(data.beer_growler_price);
         $("#beer_special_c").text(data.beer_special);
         $("#beer_special_c").val(data.beer_special);  
		 }else{
		 $("#message_c").text('Beer Searched is NOT in Current Beer List. Make any edits and click "Add Beer" button to add.');
		 $("#id_c").text('Existing ID');
		 $("#beer_label_url_c").text('Beer Label Image URL');
		 $("#brewery_label_url_c").text('Brewery Label Image URL');
         $("#beer_name_c").text('Beer Name');
         $("#beer_type_c").text('Beer Type');
         $("#beer_desc_c").text('Description');
         $("#beer_abv_c").text('ABV');
         $("#beer_ibu_c").text('IBU');
         $("#brewery_id_c").text('Brewery ID'); 
         $("#brewery_name_c").text('Brewery Name'); 
         $("#brewery_city_c").text('Brewery City'); 
         $("#brewery_url_c").text('Brewery URL');
         $("#beer_status_c").text('Beer Status'); 
         $("#beer_glass_price_c").text('Price per Glass');
         $("#beer_growler_price_c").text('Growler Price');
         $("#beer_special_c").text('Beer Special');
         $("#beer_special_c").val('OFF');
			 
		 }
		
		  
        }
        
        function onSuccessBeerView(data, status)
        {
          //alert('data:'+data); 
         
          if(data != false){ 
         $("#message_c").text('EXISTING Beer selected to view. Edit and click "Add Beer" to update beer.');   
         $("#id").val(data.id);
         $("#beer_label").attr('src',data.beer_label_url);
         $("#beer_label_url").val(data.beer_label_url);
         $("#brewery_label").attr('src',data.brewery_label_url);
         $("#brewery_label_url").val(data.brewery_label_url);
         $("#beer_name").val(data.beer_name);
         $("#beer_type").val(data.beer_style);
         $("#beer_desc").val(data.beer_desc);
         $("#beer_abv").val(data.beer_abv);
         $("#beer_ibu").val(data.beer_ibu);
         $("#brewery_id").val(data.brewery_id); 
         $("#brewery_name").val(data.brewery_name); 
         $("#brewery_city").val(data.brewery_city); 
         $("#brewery_url").val(data.brewery_url); 
         $("#beer_status").val(data.beer_status);
         $("#beer_glass_price").val(data.beer_glass_price);
         $("#beer_growler_price").val(data.beer_growler_price); 
         $("#beer_special").val(data.beer_special); 
		 }else{
		 $("#message_c").val('Beer Searched is NOT in Current Beer List. Make any edits and click "Add Beer to List" button below to add.');
		 $("#id_c").val('Existing ID');
		 $("#beer_label_url_c").val('Beer Label Image URL');
		 $("#brewery_label_url_c").val('Brewery Label Image URL');
         $("#beer_name_c").val('Beer Name');
         $("#beer_type_c").val('Beer Type');
         $("#beer_desc_c").val('Description');
         $("#beer_abv_c").val('ABV');
         $("#beer_ibu_c").val('IBU');
         $("#brewery_id_c").val('Brewery ID'); 
         $("#brewery_name_c").val('Brewery Name'); 
         $("#brewery_city_c").val('Brewery City'); 
         $("#brewery_url_c").val('Brewery URL');
         $("#beer_status_c").val('Beer Status'); 
         $("#beer_glass_price_c").val('Price per Glass');
         $("#beer_growler_price_c").val('Growler Price');
         $("#beer_special_c").val('Beer Special');
			 
		 }
		
		  
        }

        
         var beercount ='0';
         function onSuccessBeerList(data, status)
        {
            beercount = Object.keys(data).length;
            
            $('#beers-listview-inventory').html('');
             $('#beers-listview-infoline').text('There are '+beercount+' Beers in: '+beerview+'');
             $('#beers-listview-inventory').append('<li data-role="list-divider" data-theme="b"><span> BEER </span><span style="float:right;"><span> SPECIAL </span><span style="padding-left:15px;">STATUS</span><span style="padding-left:20px;"> DELETE </span></span></li>');           
           
            Object.keys(data).forEach(function(key) {
             var dotimg='';
             var flagimg='';
              if(data[key].beer_status == 'ACTIVE'){dotimg = '<img style="width:10px;margin-left:5px;" src="../images/dot_green.png"/>';}
              if(data[key].beer_status == 'INACTIVE'){dotimg = '<img style="width:10px;margin-left:5px;" src="../images/dot_yellow.png"/>';}
              if(data[key].beer_status == 'BOTTLE-IN'){dotimg = '<img style="width:10px;margin-left:5px;" src="../images/dot_brown.png"/>';}
              if(data[key].beer_status == 'BOTTLE-OUT'){dotimg = '<img style="width:10px;margin-left:5px;" src="../images/dot_red.png"/>';}
              if(data[key].beer_special == 'ON'){flagimg = '<img style="width:20px;margin-right:10px;" src="../images/star_green.png"/>';}
              if(data[key].beer_special == 'OFF'){flagimg = '<img style="width:20px;margin-right:15px;" src="../images/star_yellow.png"/>';}
          // $('#beers-listview-inventory').append('<li data-theme="b"><img src="'+data[key].beer_label_url+'"/><h3>'+data[key].beer_name+'</h3><p style="max-width:350px;white-space:normal;padding:10px;">'+data[key].beer_desc+'<p><p>'+data[key].brewery_name+'<p><p>'+data[key].beer_style+'<p><p>Glass: '+data[key].beer_glass_price+'<p><p>Growler: '+data[key].beer_growler_price+'<p><p>ABV: '+data[key].beer_abv+'%<p><p>IBUs: '+data[key].beer_ibu+'<p></li>');
            if(data[key].beer_status == 'INACTIVE'){$theme='c';}else if(data[key].beer_status == 'ACTIVE'){$theme='e';} else {$theme='a';}
            
            //$('#beers-listview-inventory').append('<li class="beerdetails" data-theme="'+$theme+'" style="padding:0px;padding-left:35px;"><img src="'+data[key].beer_label_url+'" style="max-width:45px;max-height:45px;float:left;"/><h3>'+data[key].beer_name+'</h3><p class="beerspecial ui-li-aside" style="float:right;color:#ff0000;padding-right:10px;max-width:25px;" value="'+data[key].beer_special+'">'+flagimg+'</p><p class="beerdelete" style="float:right;color:#ff0000;padding-right:10px;">DELETE</p><p data-role="button" class="beertoggle" style="float:right;padding-right:5px;" id="'+data[key].id+'">'+data[key].beer_status+dotimg+'</p><p  style="float:left;padding-right:5px;">'+data[key].beer_style+'</p><p  style="clear:left;float:left;padding-right:5px;">'+data[key].brewery_name+'</p></li>');
            
             $('#beers-listview-inventory').append('<li class="beerdetails" data-theme="'+$theme+'" style="padding:0px;padding-left:70px;"><img src="beerimages/'+data[key].id+'.jpg" class="ui-li-thumb"/><h3 class="ui-li-heading" style="max-width:280px;">'+data[key].beer_name+'</h3><p  class="ui-li-desc">'+data[key].beer_style+'</p><p   class="ui-li-desc">'+data[key].brewery_name+'</p><p class="ui-li-desc" style="height:25px;padding-top:5px;"><span class="beerdelete" style="width:45px;color:#ff0000;padding-right:20px;padding-left:20px;padding-top:5px;float:right;">DELETE</span><span  class="beertoggle" style="min-width:65px;padding-right:0px;padding-top:5px;float:right;" id="'+data[key].id+'">'+data[key].beer_status+dotimg+'</span><span class="beerspecial" style="width:45px;max-width:40px;margin-right:25px;float:right;" value="'+data[key].beer_special+'">'+flagimg+'</span></p></li>');
           
           $('#beers-listview-inventory').listview('refresh');
           
    });
            
             //for (var id in data) {
			//   alert(data.id);
			//   }           
		   //jQuery.each(data, function(i, val) {
			  // $("#" + i).append(document.createTextNode(" - " + val));
			  // });
                 
       /*   if(data != false){ 
         $("#message_c").text('Beer Searched EXISTS in Current Beer List, see shaded text.');   
         $("#id_c").text(data.id);
         $("#beer_name_c").text(data.beer_name);
         $("#beer_type_c").text(data.beer_style);
         $("#beer_desc_c").text(data.beer_desc);
         $("#beer_abv_c").text(data.beer_abv);
         $("#beer_ibu_c").text(data.beer_ibu);
         $("#brewery_id_c").text(data.brewery_id); 
         $("#brewery_name_c").text(data.brewery_name); 
         $("#brewery_city_c").text(data.brewery_city); 
         $("#brewery_url_c").text(data.brewery_url);  
		 }else{
		 $("#message_c").text('Beer Searched is NOT in Current Beer List. Make any edits and click "Add Beer to List" button below to add.');
		 $("#id_c").text('Existing ID');
         $("#beer_name_c").text('Beer Name');
         $("#beer_type_c").text('Beer Type');
         $("#beer_desc_c").text('Description');
         $("#beer_abv_c").text('ABV');
         $("#beer_ibu_c").text('IBU');
         $("#brewery_id_c").text('Brewery ID'); 
         $("#brewery_name_c").text('Brewery Name'); 
         $("#brewery_city_c").text('Brewery City'); 
         $("#brewery_url_c").text('Brewery URL');
			 
		 } */
		
		  
        }

        
        
         function onSuccessInsert(data, status)
        {
          $("#message_c").text('Beer has been added and set as '+data.beer_status+'.');          
         $("#id_c").text(data.id);
         $("#beer_label_c").text(data.beer_label_url);
         $("#brewery_label_c").text(data.brewery_label_url);
         $("#beer_name_c").text(data.beer_name);
         $("#beer_type_c").text(data.beer_style);
         $("#beer_desc_c").text(data.beer_desc);
         $("#beer_abv_c").text(data.beer_abv);
         $("#beer_ibu_c").text(data.beer_ibu);
         $("#brewery_id_c").text(data.brewery_id); 
         $("#brewery_name_c").text(data.brewery_name); 
         $("#brewery_city_c").text(data.brewery_city); 
         $("#brewery_url_c").text(data.brewery_url);
         $("#beer_status_c").text(data.beer_status);
         $("#beer_glass_price_c").text(data.beer_glass_price);
         $("#beer_growler_price_c").text(data.beer_growler_price); 
         $("#beer_special_c").text(data.beer_special);    
		 listBeers(beerview,'','beer_name');
        }
  
        function onError(data, status)
        {
            // handle an error
            alert('error_getBeer'+status);
        }   
        
        function onErrors(data, status)
        {
            // handle an error
            
           alert('error:'+status);
        }       
  
    
  
			function getBeer(beerid){ 
				 //alert('getBeer'+beerid);
                //var formData = $("#callAjaxForm").serialize();
				 
                $.ajax({
                    type: "POST",
                    url: "a_getbeer.php",
                    cache: false,
                    //data: formData,
                    data: {beerid_req : beerid},
                    dataType:"json",
                    success: onSuccessBeer,
                    error: onError
                });
			}	
			
			function getBeer2(beerid){ 
				 //alert('getBeer'+beerid);
                //var formData = $("#callAjaxForm").serialize();
				 
                $.ajax({
                    type: "POST",
                    url: "a_getbeer.php",
                    cache: false,
                    //data: formData,
                    data: {beerid_req : beerid},
                    dataType:"json",
                    success: onSuccessBeerView,
                    error: onError
                });
			}	
			
			function listBeers(beerview,beerselect,beersort){ 
				 //alert('getBeer'+beerid);
                //var formData = $("#callAjaxForm").serialize();
				 
                $.ajax({
                    type: "POST",
                    url: "a_listbeers.php",
                    cache: false,
                    // data: formData,
                    data: {beer_view : beerview, beer_select : beerselect,beer_sort : beersort},
                    dataType:"json",
                    success: onSuccessBeerList,
                    error: onError
                });
			}	

			function onMenuAvailable(data, status)
        {
                    
            alert('Menu Available');  
			$("#msg").html(data);
          
        }
  
		 function onErrorsMenu(data, status)
        {
            // handle an error
            
           alert('errors:'+status);
           alert('errord:'+data);
        }  
  
		function onSuccessSpecials(data, status)
        {
         
       
         $("#special1").val(data.special_1);
         $("#special1h").val(data.special_1h);
         $("#special1s").val(data.special_1s);
         $("#special1d").val(data.special_1d);
          
         $("#special2").val(data.special_2);
         $("#special2h").val(data.special_2h);
         $("#special2s").val(data.special_2s);
         $("#special2d").val(data.special_2d);
          
		 $("#special3").val(data.special_3);
         $("#special3h").val(data.special_3h);
         $("#special3s").val(data.special_3s);
         $("#special3d").val(data.special_3d);
          

		 $("#special4").val(data.special_4);
         $("#special4h").val(data.special_4h);
         $("#special4s").val(data.special_4s);
         $("#special4d").val(data.special_4d);
          $("#marqueetext").val(data.marquee_text);
          

   
        }
  
        function onErrorSpecials(data, status)
        {
            // handle an error
        }       
  

  
  
  
  
       // $(document).ready(function() {
        
        
        				
			getBeer(0);
             listBeers(beerview,'','beer_name');            
            
            function onSuccessStatusUpdate(data, status)
            
			{ 
			
			listBeers(beerview,'','beer_name');
			 getBeer2(data);
				}
            
            $(".beerdetails").on('click',function(){  
            
				 var beerid = $(this).find('.beertoggle').attr("id");
				 $('.ui-li-heading').css('color','black');
				 $(this).find('.ui-li-heading').css('color','red');
				 getBeer2(beerid);
				 
				  });  

            
             $(".beertoggle").on('click',function(){  
            
				 var beerid = $(this).attr("id");
				
				 var beerstatus = $(this).text();
               $.ajax({
                    type: "POST",
                    url: "a_updatebeerstatus.php",
                    cache: false,
                    data: {beer_status : beerstatus,beer_id : beerid},
                    dataType:"text",
                    success: onSuccessStatusUpdate,
                    error: onError
                });   
                
  
                return false;
            });
            
            
            $(".beerspecial").on('click',function(){  
            
				// var beerid = $(this).prev().attr("id");
				var beerid = $(this).siblings('.beertoggle').attr("id");
				
				 
				var beerspecial = $(this).attr("value");
				  $.ajax({
                    type: "POST",
                    url: "a_updatebeerspecial.php",
                    cache: false,
                    data: {beer_special : beerspecial,beer_id : beerid},
                    dataType:"text",
                    success: onSuccessBeerSpecialUpdate,
                    error: onError
                });   
                
  
                return false;
            });

             function onSuccessBeerSpecialUpdate(data, status)
            
			{ 
			
			listBeers(beerview,'','beer_name');
			 getBeer2(data);
				}
            

            
             function onSuccessBeerDelete(){listBeers(beerview,'','beer_name');}
             function onErrorBeerDelete(){alert('could not delete beer');}
			 
			 function areYouSure(text1, text2, button, callback) {
				 $("#sure .sure-1").text(text1);
				 $("#sure .sure-2").text(text2);
				 $("#sure .sure-do").text(button).on("click.sure", function() {
					 callback(false);
					 $(this).off("click.sure");
					 });
					 $.mobile.changePage("#sure");
					 }
            
             $(".beerdelete").on('click',function(){  
                var beerid = $(this).next('p').attr("id");
               areYouSure("Are you sure?", "Do you want to DELETE this Beer from Your Database?", "Yes", function() {
               	// user has confirmed, do stuff 
				
				
				  
                $.ajax({
                    type: "POST",
                    url: "a_deletebeer.php",
                    cache: false,
                    data: {beer_id : beerid},
                    dataType:"text",
                    success: onSuccessBeerDelete,
                    error: onErrorBeerDelete
                });  
                
  
                
                });
                return false;
                
            });
            
			  

           
            
             $("#filterActive").on('click',function(){ 
             beerview = "ACTIVE";
             listBeers(beerview,'beer_status="ACTIVE"','beer_name'); 
             return false;
             }); 
             
              $("#filterInactive").on('click',function(){ 
              beerview = "INACTIVE";
             listBeers(beerview,'beer_status="INACTIVE"','beer_name');
              return false;
             });
              $("#filterBottle").on('click',function(){ 
              beerview = "BOTTLE";
             listBeers(beerview,'beer_status in ("BOTTLE-IN","BOTTLE-OUT")','beer_name');
              return false;
             });
              $("#filterDraft").on('click',function(){ 
              beerview = "DRAFT";
              listBeers(beerview,'beer_status in ("ACTIVE","INACTIVE")','beer_name');
              return false;
              });
              
               $("#filterAll").on('click',function(){ 
               beerview = "ALL";
              listBeers(beerview,'beer_status in ("ACTIVE","INACTIVE","BOTTLE-IN","BOTTLE-OUT")','beer_name'); 
              return false;
              });
        
            $("#submit").click(function(){
  
                var formData = $("#addBeerForm").serialize();
  
                $.ajax({
                    type: "POST",
                    url: "a_updatebeer.php",
                    cache: false,
                    data: formData,
                    dataType:"json",
                    success: onSuccessInsert,
                    error: onError
                });
  
                return false;
            });
            
            
             $('#beersearch').on("submit", function() {
				  var formData = $("#beersearch").serialize();
                var search = '';
                search = encodeURIComponent($("#searchbeer").val());
				var request='';
				 request = 'https://api.untappd.com/v4/search/beer/?client_id=C40794B80F126BF02665235734EDE64B345F02BE&client_secret=0E9E64739DB498A434D439ED16175F27EF4F904A&q='+search+'';
				 
				 //request='http://api.brewerydb.com/v2/search?q=Coors&type=beer&key=fcedc8bd35bff69c87fd220225a585e3&name='+search+'&p=1';
				    $.ajax({
                    type: "GET",
                    url: request,
                    cache: false,
                    data: formData,
                    dataType:"json",
                    success: onBeerAvailable,
                    error: onErrors
                });
  
                return false;
			});
            
            
             
			 
			
			function online() {
				var result;
				$.ajax({
					url:"testinet.php",
					async: false,  
					success:function(data) {
						result = data;
						}
						});
						return result;
						}    
				
				
			  		
						        
              $("#search").on('click', function(){
				  var ifonline = online();
				 if(ifonline == " on"){ 
                var formData = $("#beersearch").serialize();
                var search = '';
                search = encodeURIComponent($("#searchbeer").val());
				var request='';
				 request = 'https://api.untappd.com/v4/search/beer/?client_id=C40794B80F126BF02665235734EDE64B345F02BE&client_secret=0E9E64739DB498A434D439ED16175F27EF4F904A&q='+search+'';
				// request='http://api.brewerydb.com/v2/search?q=Coors&type=beer&key=fcedc8bd35bff69c87fd220225a585e3&name='+search+'&p=1';
				    $.ajax({
                    type: "GET",
                    url: request,
                    cache: false,
                    data: formData,
                    dataType:"json",
                    success: onBeerAvailable,
                    error: onErrors
                });
				}
                else{alert('SEARCH UNAVAILABLE. NO INTERNET CONNECTION');$("#message_c").text('SEARCH UNAVAILABLE. NO INTERNET CONNECTION');}

				
                return false;
                            });
             
           function onErrorBeerSearch(data, status){/* alert(data.data);alert(status);*/}  
             
             
             $("#menubutton").on('click',function(){
				 var formData = $("#menusearch").serialize();
				    $.ajax({
                    type: "POST",
                    url: "getvenue.php",
                    cache: false,
                     data: formData,                    
                    //data: {menus : %7B%22Pour%20House%20Eats%22%7D},
                    dataType:"json",
                    success: onMenuAvailable,
                    error: onErrorsMenu
                });
  
                return false;
            });

             
              var formData = $("#specialsForm").serialize();
  
                $.ajax({
                    type: "POST",
                    url: "a_getspecials.php",
                    cache: false,
                    data: formData,
                    dataType:"json",
                    success: onSuccessSpecials,
                    error: onErrorSpecials
                });
  

             
             $("#upspecial").on('click',function(){
  
                var formData = $("#specialsForm").serialize();
  
                $.ajax({
                    type: "POST",
                    url: "a_updatespecials.php",
                    cache: false,
                    data: formData,
                    dataType:"json",
                    success: onSuccessSpecials,
                    error: onErrorSpecials
                });
  
                return false;
            });
            
          function zeroFill( number, width )
		  {
			  width -= number.toString().length;
			  if ( width > 0 )
			  {
				  return new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
				  }
				  return number + ""; // always return a string
				  }
            
         function onSuccessAdLoad(data, status) {
         
         //$("#ad-message").html('<h5 style="text-align:center;">Select an Ad to Edit</h5>').show(