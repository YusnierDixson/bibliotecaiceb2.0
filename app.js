$(document).ready(function(){ 
    let edit=false;
  $('#task-result').hide();
  inicial();
fetchTasks();  
    $('#search').keyup(function(e){
         let search=$('#search').val();
         $.ajax({
             url:'recurso-search.php',
             type:'POST',
             data:{search},
             success:function(response){
                let tasks= JSON.parse(response);
                let template='';

                for (var clave in tasks){
                    // Controlando que json realmente tenga esa propiedad
                    if (tasks.hasOwnProperty(clave)) {
                      // Mostrando en pantalla la clave junto a su valor.
                      template+=`<li>
                      ${tasks[clave].titulo}
                      </li>`
                     
                    }
                  }

                  $('#container').html(template);
                  $('#task-result').show();
                    
                              

             }
         })
         
     })
     
    
    
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
                     <td> <a href="#" class="task-item">${newTitle(titu)}</a></td>
                      <td>${newTitle(aut)}</td>
                      <td>${newTitle(asig)}</td>
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

   $(document).on('click','.task-delete', function(){
     if (confirm('Esta seguro de querer eliminar el recurso seleccionado')) {
           //A partir del boton ir subiendo eleentos hasta llegar al id parent   
    let element=$(this)[0].parentElement.parentElement;//[0] esta el boton q doy click
    let id=$(element).attr('taskId');//Esto lo declaro en el momento de llenar la tabla
    $.post('recurso-delete.php',{id},function(response){
        fetchTasks();

            });
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
function newTitle(title) {
  let shortTitle=title.substr(0,15);
  let punt='...';
  let newTitle=shortTitle.concat(punt);
  return newTitle;
}

});

