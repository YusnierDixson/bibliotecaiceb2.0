$(document).ready(function(){ 
    let edit=false;
  $('#task-result').hide();
  $('#mssg').hide();
  $('#search-simple').hide();
  $('#filtro').hide();
 // $('#avan-search').hide();
  $('#welcome').show();
  inicial();
fetchTasks();  
estadistica();

    $('#search').keyup(function(e){
         let search=$('#search').val();
         $('#welcome').hide();
         $.ajax({
             url:'recurso-search.php',
             type:'POST',
             data:{search},
             success:function(response){
              $('#mssg').hide();
                let tasks= JSON.parse(response);
                let template='';
                let titu=``;
                if(Object.entries(tasks).length === 0){
                    $('#mssg').show();
                    $('#task-result').hide();
                  }
                  
                for (var clave in tasks){
                    // Controlando que json realmente tenga esa propiedad
                    titu=tasks[clave].titulo;
                    if (tasks.hasOwnProperty(clave)) {
                      // Mostrando en pantalla la clave junto a su valor.
                      template+=`<li><a href="recurso-detalle.php?cat=${tasks[clave].idcategoria}&id=${tasks[clave].id}" class="task-item" target="_black">${newTitle(titu,80)}</a>
                      
                      </li>`
                     
                    }
                  }
                 
                  $('#container').html(template);
                  $('#task-result').show();
                    
                              

             }
         })
         
     })
     
    
     $('#search-gen').keyup(function(e){
      let search=$('#search-gen').val();
      $.ajax({
          url:'recurso-search.php',
          type:'POST',
          data:{search},
          success:function(response){
           $('#mssg').hide();
            
             let tasks= JSON.parse(response);
                        
             let template='';
             let template1='';
             let titu='';
             let aut='';
             let asig='';
             let icon=`<i class="fa fa-book"></i>`;
            
               if(Object.entries(tasks).length === 0){
                 $('#mssg').show();
                 $('#task-result').hide();
               }
               
             for (var clave in tasks){
                // Controlando que json realmente tenga esa propiedad
                if (tasks.hasOwnProperty(clave)) {
                  // Mostrando en pantalla la clave junto a su valor.
                  if(tasks[clave].idcategoria==4){
                    icon=`<i class="fa fa-film"></i>`;
                  } else if(tasks[clave].idcategoria==3){
                       icon=`<i class="fa fa-graduation-cap"></i>`;
                  }
                  else if(tasks[clave].idcategoria==2||tasks[clave].idcategoria==7){
                    icon=`<i class="fa fa-file-text"></i>`;
                   }
                   else if(tasks[clave].idcategoria==5){
                    icon=`<i class="fa fa-file-sound-o"></i>`;
                   }
                  titu=tasks[clave].titulo;
                  aut=tasks[clave].autor;
                  asig=tasks[clave].materia;
                 
                  template+=`<tr taskId="${tasks[clave].id}">
                  <td>${icon}</td>
                 <td> <a href="#" class="task-item">${newTitle(titu,15)}</a></td>
                  <td>${newTitle(aut,15)}</td>
                  <td>${newTitle(asig,15)}</td>
                  <td>
                  <a href="recurso-detalle.php?cat=${tasks[clave].idcategoria}&id=${tasks[clave].id}" target="_black" class="btn btn-secondary btn-sm" role="button">Ver</a>
                   <button id="recur_del" class="recurso-delete btn btn-danger btn-sm">ELIMINAR</button>
                  </td>        
                  </tr>`
                  template1+=`<tr taskId="${tasks[clave].id}">
                  <td>${icon}</td>
                 <td> <a href="#" class="task-item">${newTitle(titu,15)}</a></td>
                  <td>${newTitle(aut,15)}</td>
                  <td>${newTitle(asig,15)}</td>
                  <td>
                  <a href="recurso-detalle.php?cat=${tasks[clave].idcategoria}&id=${tasks[clave].id}" target="_black" class="btn btn-secondary btn-sm" role="button">Ver</a>
                   
                  </td>        
                  </tr>`
                 
                }
               }
             
               $('#tasks-searchs').html(template);
               $('#tasks-searchs-simple').html(template1);     

          }
      })
 
      
  })

  $('#search-avanzada').submit(function(e){
     const dataSearch={
       autor:$('#autor-s').val(),
       asigs:$('#asig-s').val(),
       type:$('#tip-recur').val(),
       anno:$('#anno-s').val(),
     };
     $.post('avanzada.php',dataSearch,function(response){
      $('#mssg').hide();
            console.log(response);
            
             let tasks= JSON.parse(response);
                        
             let template='';
             let template1='';
             let titu='';
             let aut='';
             let asig='';
             let icon=`<i class="fa fa-book"></i>`;
            
               if(Object.entries(tasks).length === 0){
                 $('#mssg').show();
                 $('#task-result').hide();
               }
               
             for (var clave in tasks){
                // Controlando que json realmente tenga esa propiedad
                if (tasks.hasOwnProperty(clave)) {
                  // Mostrando en pantalla la clave junto a su valor.
                  if(tasks[clave].idcategoria==4){
                    icon=`<i class="fa fa-film"></i>`;
                  } else if(tasks[clave].idcategoria==3){
                       icon=`<i class="fa fa-graduation-cap"></i>`;
                  }
                  else if(tasks[clave].idcategoria==2||tasks[clave].idcategoria==7){
                    icon=`<i class="fa fa-file-text"></i>`;
                   }
                   else if(tasks[clave].idcategoria==5){
                    icon=`<i class="fa fa-file-sound-o"></i>`;
                   }
                  titu=tasks[clave].titulo;
                  aut=tasks[clave].autor;
                  asig=tasks[clave].materia;
                 
                  template+=`<tr taskId="${tasks[clave].id}">
                  <td>${icon}</td>
                 <td> <a href="#" class="task-item">${newTitle(titu,15)}</a></td>
                  <td>${newTitle(aut,15)}</td>
                  <td>${newTitle(asig,15)}</td>
                  <td>
                  <a href="recurso-detalle.php?cat=${tasks[clave].idcategoria}&id=${tasks[clave].id}" target="_black" class="btn btn-secondary btn-sm" role="button">Ver</a>
                   <button id="recur_del" class="recurso-delete btn btn-danger btn-sm">ELIMINAR</button>
                  </td>        
                  </tr>`
                  template1+=`<tr taskId="${tasks[clave].id}">
                  <td>${icon}</td>
                 <td> <a href="#" class="task-item">${newTitle(titu,15)}</a></td>
                  <td>${newTitle(aut,15)}</td>
                  <td>${newTitle(asig,15)}</td>
                  <td>
                  <a href="recurso-detalle.php?cat=${tasks[clave].idcategoria}&id=${tasks[clave].id}" target="_black" class="btn btn-secondary btn-sm" role="button">Ver</a>
                   
                  </td>        
                  </tr>`
                 
                }
               }
             
               $('#tasks-searchs').html(template);
               $('#tasks-searchs-simple').html(template1);   
      
     $('#search-avanzada').trigger('reset');

  });
    e.preventDefault();
  });
    
     $('#task-form').submit(function(e){
      const postData={
        id:$('#taskId').val(),
        title:$('#title').val(),
        autor:$('#autor').val(),
        type:$('#type').val(),
        asignatura:$('#asignatura').val(),
        type_lect:$('#type_lect').val(),
        year:$('#year').val(),
        resumen:$('#resumen').val(),
        claves:$('#claves').val(),
        conocimiento:$('#conocimiento').val(),
        tema:$('#tema').val(),
        revista:$('#revista').val(),
        editorial:$('#editorial').val(),
        idioma:$('#idioma').val(),
        isbn:$('#isbn').val(),
        issn:$('#issn').val(),
        url:$('#url').val(),
        place:$('#place').val(),
        
      };
      let urls= edit===false ? 'recurso-add.php':'recurso-edit.php';
//Funcion de JQuery envia info al back
        $.post(urls,postData,function(response){
            fetchTasks();
            $('#task-form').trigger('reset');
            inicial();
            estadistica();
        });
             //Evita el envio de un formulario es decir que se refresque

        e.preventDefault();
        

    });
   
   function fetchTasks() {
        //Esto se ejecuta apenas inicie la aplicación no depende de ningún evento
    $.ajax({
        url:'recursos-list.php',
        type:'GET',
        success: function(response){
            let tasks=JSON.parse(response);
            let template='';
            let titu='';
            let aut='';
            let asig='';
            let icon=`<i class="fa fa-book"></i>`;
            
            for (var clave in tasks){
              
                    // Controlando que json realmente tenga esa propiedad
                    if (tasks.hasOwnProperty(clave)) {
                      // Mostrando en pantalla la clave junto a su valor.
                      if(tasks[clave].idcategoria==4){
                        icon=`<i class="fa fa-film"></i>`;
                      } else if(tasks[clave].idcategoria==3){
                           icon=`<i class="fa fa-graduation-cap"></i>`;
                      }
                      else if(tasks[clave].idcategoria==2||tasks[clave].idcategoria==7){
                        icon=`<i class="fa fa-file-text"></i>`;
                       }
                       else if(tasks[clave].idcategoria==5){
                        icon=`<i class="fa fa-file-sound-o"></i>`;
                       }
                      titu=tasks[clave].titulo;
                      aut=tasks[clave].autor;
                      asig=tasks[clave].materia;
                      template+=`<tr taskId="${tasks[clave].id}">
                      <td>${icon}</td>
                     <td> <a href="#" class="task-item">${newTitle(titu,15)}</a></td>
                      <td>${newTitle(aut,15)}</td>
                      <td>${newTitle(asig,15)}</td>
                      <td>
                      <button class="task-delete btn btn-danger btn-sm">ELIMINAR</button>
 
                      </td>        
                      </tr>`
                     
                    }
                  }
            
                 $('#tasks').html(template);
                
        }
    })

 
   }

   function estadistica() {
     $.ajax({
       url:'count.php',
       type:'GET',
       success: function(response){
                     
         let estadis=JSON.parse(response);
               
         $('#cant_rev').text(estadis.revista);
         $('#cant_libro').text(estadis.libro);
         $('#cant_tesis').text(estadis.tesis);
         $('#cant_mono').text(estadis.mono);
         $('#cant_gen').text(estadis.generi);
         if(estadis.isadmin==false){
          $('#manager').hide();
          $('#edicion').hide();
          $('#search-avanzado').hide();
          $('#search-simple').show();
         }
       }
     })
     
   }


   $(document).on('click','.task-delete', function(){
     if (confirm('Esta seguro de querer eliminar el recurso seleccionado')) {
           //A partir del boton ir subiendo eleentos hasta llegar al id parent   
    let element=$(this)[0].parentElement.parentElement;//[0] esta el boton q doy click
    let id=$(element).attr('taskId');//Esto lo declaro en el momento de llenar la tabla
    $.post('recurso-delete.php',{id},function(response){
        fetchTasks();
        estadistica();

            });
     }
    
   })
   $(document).on('click','.recurso-delete', function(){
    if (confirm('Esta seguro de querer eliminar el recurso seleccionado')) {
          //A partir del boton ir subiendo eleentos hasta llegar al id parent   
   let element=$(this)[0].parentElement.parentElement;//[0] esta el boton q doy click
   let id=$(element).attr('taskId');//Esto lo declaro en el momento de llenar la tabla
   $.post('recurso-delete.php',{id},function(response){
       //fetchTasks();
       location.reload();
       estadistica();

           });
    }
   
  })
  $(document).on('click','#edicion',function(){
    if ($(this).prop('checked')) {
      $('#search-avanzado').show();
      $('#search-simple').hide();
    } else {
      $('#search-avanzado').hide();
      $('#search-simple').show();
    }

  })
  $(document).on('click','#customSwitch1',function(){
    if ($(this).prop('checked')) {
      
      $('#avan-search').show();
    } else {
      $('#avan-search').hide();
    }

  })

  $(document).on('click','#filtre',function(){
    if ($(this).prop('checked')) {
      
      $('#filtro').show();
    } else {
      $('#filtro').hide();
    }

  })

   $(document).on('click','.task-item',function(){
    let element=$(this)[0].parentElement.parentElement;//[0] esta el boton q doy click
    let id=$(element).attr('taskId');//Esto lo declaro en el momento de llenar la tabla   
    $.post('recurso-single.php',{id},function(response){
        const task=JSON.parse(response);
        if(task.idcategoria==1){
          inicial();
        $('#div_edit').show();
        $('#div_place').show();
        $('#div_isbn').show();
        $('#div_resum').show();
        }else if(task.idcategoria==2){
          inicial();
         $('#div_place').show();
         $('#div_issn').show();
         $('#div_revista').show();  
         $('#div_resum').show(); 
        } else if(task.idcategoria==3 || task.idcategoria==7){
          inicial();
          $('#div_place').show();
          $('#div_resum').show();
        } else if(task.idcategoria==4 || task.idcategoria==5|| task.idcategoria==6|| task.idcategoria==0){
          inicial();
        }
        $('#taskId').val(task.id);
        $('#title').val(task.titulo);
        $('#autor').val(task.autor);
        $('#type').val(task.idcategoria);
        $('#asignatura').val(task.materia);
        $('#type_lect').val(task.tipolectura);
        $('#year').val(task.ano);
        $('#resumen').val(task.resumen);
        $('#claves').val(task.palabraclave);
        $('#conocimiento').val(task.areaconocimiento);
        $('#tema').val(task.recurso);
        $('#revista').val(task.revista);
        $('#editorial').val(task.editorial);
        $('#idioma').val(task.idioma);
        $('#isbn').val(task.isbn);
        $('#issn').val(task.numeropagina);
        $('#url').val(task.url);
        $('#place').val(task.lugarpublicacion);
           edit=true;
         
       
            });
       
   })

$(document).on('change','#type',function(){
    if ($(this).val()==1) {
      inicial();
        $('#div_edit').show();
        $('#div_place').show();
        $('#div_isbn').show();
        $('#div_resum').show();
    } else if($(this).val()==2){
      inicial();
      $('#div_place').show();
      $('#div_issn').show();
      $('#div_revista').show();  
      $('#div_resum').show();   
    } else if($(this).val()==3||$(this).val()==7){
      inicial();
      $('#div_place').show();
      $('#div_resum').show();
    }else if($(this).val()==4||$(this).val()==5||$(this).val()==6){
      inicial();
      
    }
    else {
      inicial();
    }
    
});
function inicial() {
  $('#div_edit').hide();
  $('#div_place').hide();
  $('#div_isbn').hide();
  $('#div_issn').hide();
  $('#div_revista').hide();
  $('#div_clave').hide();
  $('#div_resum').hide();
}
function newTitle(title,leng) {
  let shortTitle=title.substr(0,leng);
  let punt='...';
  let newTitle=shortTitle.concat(punt);
  return newTitle;
}

});

