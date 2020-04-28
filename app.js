$(document).ready(function(){ 
    let edit=false;
  $('#task-result').hide();
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
        title:$('#title').val(),
        autor:$('#autor').val(),
        type:$('#type').val(),
        asignatura:$('#asignatura').val(),
        type_lect:$('#type_lect').val(),
        year:$('#year').val(),
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
            console.log(response);

            $('#task-form').trigger('reset');
            
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
            for (var clave in tasks){
                    // Controlando que json realmente tenga esa propiedad
                    if (tasks.hasOwnProperty(clave)) {
                      // Mostrando en pantalla la clave junto a su valor.
                      template+=`<tr taskId="${tasks[clave].id}">
                      <td>${tasks[clave].id}</td>
                     <td> <a href="#" class="task-item">${tasks[clave].titulo}</a></td>
                      <td>${tasks[clave].autor}</td>
                      <td>${tasks[clave].materia}</td>
                      <td>
                      <button class="task-delete btn btn-danger btn-block">ELIMINAR</button>
 
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
    $.post('task-single.php',{id},function(response){
        const task=JSON.parse(response);
        
        $('#name').val(task.name);
        $('#description').val(task.description);
        $('#taskId').val(task.id);
        edit=true;
       
            });
       
   })

});

