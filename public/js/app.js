
setTimeout(function(){

	$("#paginacao_tabela").jPages({   
	        
      containerID : "hollowedtable",
	    previous : "←",
	    next : "→",
	    perPage : 10,
	    delay : 50
	});

}, 50);

function getForm(formname, identity) {

	var url = '';


	var _token = $('input[name="_token"]').val();

	if (identity == null) {

		url = '' + formname + '/create';

	} else {

		url = '' + formname + '/' + identity + '/edit/';

	}


	$.ajax({
        
        	url: url ,
			data:{ _token:_token},
        	type: 'GET',
        	success: function(data) {
            
            	showForm(data);
            
        	},
        	error: function(xhr, desc, err) {
            
            	showError('Um problema na insersacao de dados, se persistir contacto o administrador');   
            
            	console.log(xhr);
            	console.log('Details ' +desc);
                    
        }
        
        
    });

}

function getDetails(formname, identity) {

	var url = '' + formname + '/' + identity;


	var _token = $('input[name="_token"]').val();


	$.ajax({
        
        	url: url ,
			data:{ _token:_token},
        	type: 'GET',
        	success: function(data) {
            
            	showForm(data);
            
        	},
        	error: function(xhr, desc, err) {
            
            	showError('Unabled to load the details');   
            
            	console.log(xhr);
            	console.log('Details ' +desc);
                    
        }
        
        
    });

}

function updatetable(tablename) {

  var _token = $('input[name="_token"]').val();
  var url = '' + tablename + '/updatetable';


  $.ajax({
        
      url: url ,
      data:{ _token:_token},
      type: 'POST',
      success: function(data) {

          $('#hollowedtable').html(data);
            
          setTimeout(function(){

              $("#paginacao_tabela").jPages({   
                        
                  containerID : "hollowedtable",
                  previous : "←",
                  next : "→",
                  perPage : 12,
                  delay : 50
              });

               }, 50);
            
          },
          error: function(xhr, desc, err) {
            
              showError('Unabled to load the details');   
            
              console.log(xhr);
              console.log('Details ' +desc);
                    
        }
        
        
    });

}

function showForm(data) {


	newobj = $.dialog({
        icon: '',
        closeIcon: true,
        title: '<span class="now-ui-icons design_shape-circle" style=""></span> ' ,
        columnClass: 'd-none',
        content: '' + data,
        buttons: { 

              },

        onContentReady: function (e) {
            

            $('.jconfirm-holder').css({"position" : 'absolute', "top": 0, "right": 0, "width" : "100%"});

            newobj.setColumnClass('col-lg-10 d-block justify-content-center ');
            
            $('#cancel_actcolumn').on('click', function(){
                
                newobj.close();
                
                
            });

            $('#save_actcolumn').on('click', function(){
                
                newobj.close();
                
                
            });

            $('#picture').change(function(){
          
                readURL(this);
                
            });

        }

    });


}

function showError(message){

    $.alert({

	title: 'Erro',
	icon: 'now-ui-icons ui-1_circle-delete',
	content: message

    });

}

function showInfo(message){

    $.alert({

	title: 'Informacao',
	icon: 'now-ui-icons ui-1_check-circle-08',
	content: message

    });

}

function searchTable(){

    //Decalres variables
    var input, filter, table, tr, th, td, i;

    input = document.getElementById('search_input_');
    filter = input.value.toUpperCase();

    tablebody = document.getElementById('hollowedtable');

    tr = tablebody.getElementsByTagName('tr');
    th = $('#hollowedtable').parent('table').find('th');

    //Loops through all table rows, and hide those who don't match the search query

    for ( i=0; i < tr.length; i++){

	for (var j = 0; j < (th.length -1); j++) {

            td = tr[i].getElementsByTagName('td')[j];
            
            if (td) {

		if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {

                    tr[i].style.display = "";

                    break;
                } else {

		tr[i].style.display = "none";

                }
            }
        }
			
    }
    setTimeout(function(){

    	$("#paginacao_tabela").jPages({   
    	        
            containerID : "hollowedtable",
    	    previous : "←",
    	    next : "→",
    	    perPage : 12,
    	    delay : 50
    	});

     }, 50);

}

function add(tablename) {

	var form = new FormData(document.getElementById(tablename + '_form'));

	var _token = $('input[name="_token"]').val();

	var url = ""+ tablename;

	$.ajax({

        url: url ,
        method:"POST",
        headers:{

        	'X-CSRF-TOKEN' : _token

        },
        processData: false,
        contentType:false,
        data: form,
        dataType: 'json',
        success:function(data){
           
          	if (data.status == 1) {

           		showError(data.message);

           } else {

           		updatetable(tablename);
              showPush(data.message);


           }

        },

        error: function(xhr, desc, err) {

            showError('Unabled to save data :' +err);   

            console.log(xhr);
            console.log('Details ' +desc);

                }

    });

}

function update(tablename, id) {

	var form = new FormData(document.getElementById(tablename + '_form'));

	var _token = $('input[name="_token"]').val();


	$.ajax({

        url: ""+ tablename + '/' + id,
        type:"POST",
        headers:{

        	'X-CSRF-TOKEN' : _token,
        	'_method' : 'PATCH'

        },
        processData: false,
        contentType: false,
        data:form,
        dataType: 'json',
        success:function(data){
           
           if (data.status == 1) {

           		showError(data.message);

           } else {

           		
              updatetable(tablename);
              showPush(data.message);


           }
          	
        },

        error: function(xhr, desc, err) {

            showError('Unabled to update data :');   

            console.log(xhr);
            console.log('Details ' +desc);

        }

    });

}

function confirmRemotion(nomeTabela, id_linha){
    
    $.confirm({
        title: 'remove ' + nomeTabela,
        icon: 'now-ui-icons ui-1_trash',
	content: 'Are you sure you want to delete '+ nomeTabela +' data?',

	buttons: {

        yesbutton: {

			text: '<small><span class="now-ui-icons ui-1_check-curve"></span> Yes</small>',
			action: function(){

	            remove(nomeTabela, id_linha);

			}

     	},

        nobutton: {

			text: '<small style="color:red;"><span class="now-ui-icons ui-1_simple-remove"></span> Cancel</small>',
			action: function(){

			}

        }

	}


    });
    
}

function remove(tablename, id) {

	var _token = $('input[name="_token"]').val();

	$.ajax({

        url: ""+ tablename +"/" +id,
        method:"DELETE",
        data:{ _token:_token},
        success:function(data){

        	updatetable(tablename);
          showPush(data.message);

        },

        error: function(xhr, desc, err) {

            showError('Unabled to delete data :' + err);   

            console.log(xhr);
            console.log('Details ' +desc);

        }

    });

}

function readURL(input) {

    if (input.files && input.files[0]) {
        
        var reader = new FileReader();

        reader.onload = function (e) {

            $('.picturessrc').attr('src', e.target.result).fadeIn('slow');

        }

        reader.readAsDataURL(input.files[0]);
        
    }
}

function fetchData(objectiv) {

	input = document.getElementById('search_input_');
	filter = input.value.toUpperCase();
    var _token = $('input[name="_token"]').val();

    var url = "products/fetch";

    if (objectiv == 'clients') {

    	url = "clients/fetch";

      input = document.getElementById('search_input_cli');
      filter = input.value.toUpperCase();

    }

    $.ajax({

          url: url,
          method:"POST",
          data:{query:filter, _token:_token},
          success:function(data){

          	if (objectiv == 'clients') { 

            	setCurrentClient();

          	} else {

              
              lilid = data.split('addRow');
              
              if (lilid != null) {

                if (lilid.length == 2) {


                  addRow(data.match(/\d+/));

                } else {

                  $('#productsList').fadeIn();  

                  $('#productsList').html(data);


                }

              }


          	}

          }
    });
    

}

function addRow(id) {


    var _token = $('input[name="_token"]').val();

    $.ajax({

          url: "sells/addrow/" +id,
          headers:{

        	'X-CSRF-TOKEN' : _token

          },
          method:"get",
          data:{},
          success:function(data){

           if (data == 0) {

            showPush('Product already added!');

           } else {

                $('#productsList').fadeOut();
                $('#search_input_').text();

                updatetable('sells');
                updatetotal();

           }


          }
    });

}

function removerow(id_product) {

	var _token = $('input[name="_token"]').val();

    $.ajax({

          url: "sells/removerow/" +id_product,
          headers:{

          'X-CSRF-TOKEN' : _token

          },
          method:"get",
          data:{},
          success:function(data){

            updatetable('sells');
            updatetotal();

          }
    });

}

function updaterow(id) {

	var _token = $('input[name="_token"]').val();

  var newvalue = $('#' + id).val();

    $.ajax({

          url: "sells/updatequantity/" +id + "/" + newvalue,
          headers:{

          'X-CSRF-TOKEN' : _token

          },
          method:"GET",
          data:{},
          success:function(data){

            updatetable('sells');
            updatetotal();

          }
    });

}


function setCurrentClient() {

	var _token = $('input[name="_token"]').val();

    $.ajax({

          url: "clients/setCurrentClient",
          method:"GET",
          dataType: 'json',
          data:{_token:_token},
          success:function(data){

            $('#forclientname').html(data.clientname);
            $('#forclientdocid').html(data.clientdocid);
            $('#forclientcontact').html(data.clientcontact);

          }
    });

}


function previewTable(id_product = false) {

    var _token = $('input[name="_token"]').val();
    var aims = $('#filtro_relatorio').val();
    var url = "report/getstattable/"+aims+"/false/false/false/" + id_product;


    if ($('#relatorio_do_ano')) {

        year = $('#de').val();
        month = $('#month').val();
        
        if (year != '' && month != '') {

            url = "report/getstattable/"+aims+"/" + year + "/false/" + month;

        }  else if (year != '') {

            url = "report/getstattable/"+aims+"/" + year + "/false/false";

        } else if ( month != '') {

            url = "report/getstattable/"+aims+"/false/false/" + month;

        }

    }

    if ($('#relatorio_entre_anos')) {

        year = $('#de').val();
        toyear = $('#a').val();
        month = $('#month').val();

        if (year != '' && toyear != '' && month != '') {

            url = "report/getstattable/"+aims+"/" + year + "/" + toyear + "/" + month;

        } else if (year != '' && month != '') {

            url = "report/getstattable/"+aims+"/" + year + "/false/" + month;

        } else if (year != '' && toyear != '') {

            url = "report/getstattable/"+aims+"/" + year + "/" + toyear + "/" + month;

        } else if (year != '') {

            url = "report/getstattable/"+aims+"/" + year + "/false/false";

        } else if (toyear != '' && month != '') {

            url = "report/getstattable/"+aims+"/false/" + toyear + "/" + month;

        } else if ( month != '') {

            url = "report/getstattable/"+aims+"/false/false/" + month;

        }

      
    }

    $.ajax({

          url: url,
          headers:{

          'X-CSRF-TOKEN' : _token

          },
          method:"GET",
          data:{},
          success:function(data){

            $('#fortabelarelatorio').html(data);

            setTimeout(function(){

              $("#paginacao_tabela").jPages({   
                      
                    containerID : "hollowedtable",
                  previous : "←",
                  next : "→",
                  perPage : 3,
                  delay : 20
              });

             }, 50);

          }
    });

}
function printReport() {

  var _token = $('input[name="_token"]').val();

    $.ajax({

          url: "report/printreport",
          headers:{

          'X-CSRF-TOKEN' : _token

          },
          method:"get",
          data:{},
          success:function(data){


          }
    });

}

function showPush(mymessage){

    $.notify({
                          
        icon: "now-ui-icons ui-1_check-circle-08",
        message: mymessage
                        
    }, {
                          
        type: 'info',
        timer: 2000,
        placement: {
                            
            from: 'bottom',
            align: 'right'
                          
        }
                        
    });

}

function showChanges() {

    var _token = $('input[name="_token"]').val();

    var paid = $('input[name="paidvalue"]').val();

    $.ajax({

                url: "sells/computechanges/"+ paid,
                headers:{

                  'X-CSRF-TOKEN' : _token

                },
                method:"GET",
                data:{},
                success:function(data){

                  $('#changescontent').html(data);

            }
        });

    }



$(document).ready(function(){

    if (window.history && window.history.pushstate) {

        $(window).on('popstate', function(){

            alert("");


        });


    }

});


function showcotaion(){

  $('.splash').fadeIn(100);
    
    $.ajax({
                       
        url: 'cotation/generatepdf/',
        type: 'GET',
        dataType: 'json',
        success: function(data){  
            
            window.open(data.url, "_new");

            location.reload();

        },
                        
        error: function(xhr, desc, err) {
            
            showError('Um problema na insersacao de dados, se persistir contacto o administrador');   
            
            console.log(xhr);
            console.log('Details ' +desc);
                    
        }
                         
    });
    
}

/*

function displayPDF(content, url, title){
    
    var obj = $.dialog({

        title: '' ,
        icon: '',
        closeIcon: false,
        columnClass: 'd-none',
        theme: 'supervan',
        content: '',
        buttons: {

                  

              },

        onContentReady: function (e) {

          $('.jconfirm-supervan .jconfirm-holder').css({"position" : 'absolute', "top": 0, "right": 0, "width" : "100%"});
          $('.jconfirm-supervan .jconfirm-box').addClass('no-border').css({"background" : 'transparent', "box-shadow": "0px 0px 0px transparent", "padding": 0, "overflow" : 'collapse'});
          $('.jconfirm-supervan .jconfirm-content').addClass('justify-content-center').css({});
          $('.jconfirm-supervan .jconfirm-content-pane').addClass('no-scroll').css({"overflow":'hidden'});

            obj.setContent(content);
            obj.setColumnClass('col-lg-12 col-md-12 col-sm-12 col-xs-12 d-block justify-content-center');
            obj.setTitle();

            $('.closebuttonpdfreader').on('click', function(){

                obj.close();

            }); 
          
            setTimeout(function(){
                
                getDocument(url,'Tizen for Dummies');
                
            }, 1000);
            

          e.preventDefault();

        }

    });
    
}


var pageNum = 1;
var pdfScale = 1; // make pdfScale a global variable
var shownPdf; // another global we'll use for the buttons

var url = "{{public_path('pdf/1595016275.pdf')}}"; // PDF to load: change this to a file that exists;


function getDocument(url,title){



  PDFJS.getDocument(url).then(function getPdfHelloWorld(pdf) {
     displayPage(pdf, 1);
     shownPdf = pdf;
     document.getElementById('total_page').innerHTML = pdf.numPages;
     document.getElementById('crudn_bar_title_container').innerHTML = title;

     var nextbutton = document.getElementById('nextbutton');
        nextbutton.onclick = function() {
           if (pageNum >= shownPdf.numPages) {
              return;
           }
           pageNum++;
           document.getElementById('prevbutton').value = shownPdf.numPages;
           displayPage(shownPdf, pageNum);
        }

var prevbutton = document.getElementById("prevbutton");
   prevbutton.onclick = function() {
      if (pageNum <= 1) {
         return;
      }
      pageNum--;
      displayPage(shownPdf, pageNum);
   }
  });

}

function renderPage(page) {
   var scale = pdfScale; // render with global pdfScale variable
   var viewport = page.getViewport(scale);
   var canvas = document.getElementById('crudn_pdf_container');
   var context = canvas.getContext('2d');
      canvas.height = viewport.height;
      canvas.width = viewport.width;
      var renderContext = {
         canvasContext: context,
         viewport: viewport
      };
         page.render(renderContext);
         
}

function displayPage(pdf, num) {
   pdf.getPage(num).then(function getPage(page) { 
   document.getElementById('current_page').innerHTML = num;
      renderPage(page); 

   });
}

var pdfDoc = PDFJS.getDocument(url).then(function getPdfHelloWorld(pdf) {
   displayPage(pdf, 1);
   shownPdf = pdf;
   document.getElementById('total_page').innerHTML = pdf.numPages;
});

var nextbutton = document.getElementById('nextbutton');
   nextbutton.onclick = function() {
      if (pageNum >= shownPdf.numPages) {
         return;
      }
      pageNum++;
      document.getElementById('prevbutton').value = shownPdf.numPages;
      displayPage(shownPdf, pageNum);
   }

var prevbutton = document.getElementById("prevbutton");
   prevbutton.onclick = function() {
      if (pageNum <= 1) {
         return;
      }
      pageNum--;
      displayPage(shownPdf, pageNum);
   }

*/