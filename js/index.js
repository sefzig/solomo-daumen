
    $(document).ready(function()
    {
       daumen("start");
    });

    function daumen(methode,parameter,param2)
    {
       if (methode == "start")
       {
          $(".voting_wrapper .voting_btn").click(function (e) 
          {
          // get class name (down_button / up_button) of clicked element
             var clicked_button = $(this).children().attr('class');
             
          // get unique ID from voted parent element
             var unique_id   = $(this).parent().parent().parent().parent().parent().attr("id"); 
    
             if (clicked_button==='down_button') //user disliked the content
             {
             // prepare post content
                post_data = {'unique_id':unique_id, 'vote':'down'};
        
             // send our data to "daumen.php" using jQuery $.post()
                $.post('php/daumen.php', post_data, function(data) 
                {
                // Daten-Array anlegen
                   var data_array = data.split(";");
                   var data_up =   data_array[0]; if (!data_up)   { data_up =   0; }
                   var data_down = data_array[1]; if (!data_down) { data_down = 0; }
                   var data_typ =  data_array[2]; console.log('data_typ down: '+data_typ);
                   var data_text = data_array[3]; console.log('data_text down: '+data_text);
                   
                // Darstellung anpassen
                   $('#'+unique_id+' .up_votes').text(data_up);
                   $('#'+unique_id+' .down_votes').text(data_down);
                   $("body").attr("data-up",data_up);
                   $("body").attr("data-down",data_down);
                   
                // Fehlermeldungen überschreibt
                   if (data_text) { var text_down = data_text; } else { var text_down = daumen("text","down"); }
                   
                // Dankeschön
                   daumen("melden",text_down,"down");
                   
                // Buttons inaktiv setzen
                   if ((data_text) && (data_text != ""))
                   {
                      $(".up_button").attr("src","img/daumen_up_out.png"); 
                      $(".down_button").attr("src","img/daumen_down_out.png"); 
                   }
                   else
                   {
                      if (data_typ == "up")   { $(".up_button").attr("src","img/daumen_up_hover.png"); }
                      if (data_typ == "down") { $(".down_button").attr("src","img/daumen_down_hover.png"); }
                   }
                   
                }).fail(function(err) 
                { 
                // alert user about the HTTP server error
                   daumen("melden",err.statusText);
                });
             }
             else if (clicked_button==='up_button') //user liked the content
             {
             // prepare post content
                post_data = {'unique_id':unique_id, 'vote':'up'};
                
             // send our data to "daumen.php" using jQuery $.post()
                $.post('php/daumen.php', post_data, function(data) 
                {
                // explode data for comparison
                   var data_array = data.split(";");
                   var data_up =   data_array[0]; if (!data_up)   { data_up =   0; }
                   var data_down = data_array[1]; if (!data_down) { data_down = 0; }
                   var data_typ =  data_array[2]; console.log('data_typ up: '+data_typ);
                   var data_text = data_array[3]; console.log('data_text up: '+data_text);
                   
                // replace vote up count text with new values
                   $('#'+unique_id+' .up_votes').text(data_up);
                   $('#'+unique_id+' .down_votes').text(data_down);
                   $("body").attr("data-up",data_up);
                   $("body").attr("data-down",data_down);
               
                // Fehlermeldungen überschreibt
                   if (data_text) { var text_up = data_text; } else { var text_up = daumen("text","up"); }
                   
                // thank user for liking the content
                   daumen("melden",text_up,"up");
                   
                // Buttons inaktiv setzen
                   if ((data_text) && (data_text != ""))
                   {
                      $(".up_button").attr("src","img/daumen_up_out.png"); 
                      $(".down_button").attr("src","img/daumen_down_out.png"); 
                   }
                   else
                   {
                      if (data_typ == "up")   { $(".up_button").attr("src","img/daumen_up_hover.png"); }
                      if (data_typ == "down") { $(".down_button").attr("src","img/daumen_down_hover.png"); }
                   }
                   
                }).fail(function(err)
                { 
                // alert user about the HTTP server error
                   daumen("melden",err.statusText);
                });
             }
          });
       }
       if (methode == "melden")
       {
          if ((parameter) && (parameter != ""))
          {
             var antwort = parameter;
          }
          else
          {
             var antwort = daumen("text","fehler");
          }
          
          $("#meldung").html(antwort);
          $(".diagramm, .ergebnis").css("display","block !important");
       // $(".up_button").attr("src","img/daumen_up_out.png");
       // $(".down_button").attr("src","img/daumen_down_out.png");
       // $("."+param2+"_button").attr("src","img/daumen_"+param2+"_hover.png");
          
          var data_up =   $("body").attr("data-up");
          var data_down = $("body").attr("data-down");
          var data_up =   parseInt(data_up);
          var data_down = parseInt(data_down);
          if (data_up >= data_down) { var data_hoher = data_up; } else { var data_hoher = data_down; }
          
       // var verfugbar_hohe = $(".voting_wrapper table").height();
          var diagramm_hohe = 100 / data_hoher;
          var prozent_up =   diagramm_hohe * data_up;
          var prozent_down = diagramm_hohe * data_down;
          
          $("#ergebnis_up div").html(data_up);
          $("#ergebnis_down div").html(data_down);
          
          $("#diagramm_up div").animate({height:prozent_up+"%"}, 2000);
          $("#diagramm_down div").animate({height:prozent_down+"%"}, 2000);
          $(".voting_btn img").animate({opacity:0.75}, 2000);
       }
       if (methode == "text")
       {
          if (parameter == "up")
          {
             var text_danke_up =                         'Daumen hoch!';
             var text_danke_up =     text_danke_up  +';'+'Schön, es gefällt!';
             var text_danke_up =     text_danke_up  +';'+'Kann man gut finden.';
             var text_danke_up =     text_danke_up  +';'+'Klarer Fall von Gut.';
             var text_danke_up =     text_danke_up  +';'+'Danke für Deinen Daumen.';
             var text_danke_up =     text_danke_up  +';'+'Ja, meinst das geht?';
             var text_danke_up =     text_danke_up  +';'+'Das sehen andere auch so.';
             var text_danke_up =     text_danke_up  +';'+'Warum auch nicht?';
             var text_danke_up =     text_danke_up  +';'+'Da brüllt der Löwe.';
             var text_danke_up =     text_danke_up  +';'+'Für die Republik!';
             
             var text_danke_up_array = text_danke_up.split(";");   
             var antwort = text_danke_up_array[Math.floor(Math.random()*text_danke_up_array.length)];
          }
          if (parameter == "down")
          {
             var text_danke_down =                       'Daumen runter!';
             var text_danke_down =   text_danke_down+';'+'Schade um deine Zeit.';
             var text_danke_down =   text_danke_down+';'+'Warum hängt das hier?';
             var text_danke_down =   text_danke_down+';'+'Wirf es den Löwen zum Frass vor.';
             var text_danke_down =   text_danke_down+';'+'Der Daumen ist ab.';
             var text_danke_down =   text_danke_down+';'+'Kein Applaus.';
             var text_danke_down =   text_danke_down+';'+'Weitergehen.';
             var text_danke_down =   text_danke_down+';'+'Warum auch?';
             var text_danke_down =   text_danke_down+';'+'Du wolltest das so.';
             var text_danke_down =   text_danke_down+';'+'Sollte Neuland bleiben.';
             var text_danke_down =   text_danke_down+';'+'Ist halt Neuland.';
             var text_danke_down =   text_danke_down+';'+'Das geht mit Powerpoint besser.';

             var text_danke_down_array = text_danke_down.split(";");
             var antwort = text_danke_down_array[Math.floor(Math.random()*text_danke_down_array.length)];
          }
          if (parameter == "fehler")
          {
             var antwort = 'Fehler: Keine Meldung';
          }
          return antwort;
       }
    }
