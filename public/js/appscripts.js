/* Funcionalidad que activa los toltips de bootstrap. */
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	return new bootstrap.Tooltip(tooltipTriggerEl)
});


/* Genérico: Elementos con clase 'numeric' se permiten solo números. */
// NOTA: corregir cuando los elementos son creados dinamicamente, no se reconoce el en¿vento.
var numbers = document.querySelectorAll(".numeric");
for (let i=0; i<numbers.length; i++) {
	numbers[i].addEventListener("keyup", function() {
		numbers[i].value = numbers[i].value.replace(/[^0-9]+/ig,"");
	});
}


/* Genérico: Prevenir tecla de función F12 para inspeccionar código. */
document.onkeydown = function(event){
    if (event.keyCode==123) {
	    swal({
	        title: "Mensaje!",
	        text: "No se permiten acciones de inspecionar el código fuente. (F12).",
	        icon: "warning",
	        button: "OK",
	        dangerMode: true,
	        closeOnClickOutside: false
	    });
        return false; 
    }else if(event.ctrlKey && event.shiftKey && event.keyCode==73) { // Prevent Ctrl+Shift+I 
	    swal({
	        title: "Mensaje!",
	        text: "No se permiten acciones de inspecionar el código fuente. (Ctrl+Shift+I).",
	        icon: "warning",
	        button: "OK",
	        dangerMode: true,
	        closeOnClickOutside: false
	    });
        return false; 
    } 
};


/* Genérico: Prevenir cortar copiar y pegar en todo el documento. */
addEventListener("keydown", function(event){
    evt = (event) ? event : window.event;
    // [x] == 88; [c] == 67; [v] == 86;
    if(evt.ctrlKey && (evt.which==88 || evt.which==67 || evt.which==86)){ 
        console.log("Ctrl+C pressed!");
        evt.preventDefault();
	    swal({
	    	icon: "warning",
	        title: "Mensaje!",
	        text: "No se permite: cortar, copiar o pegar.",
	        button: "OK",
	        dangerMode: true,
	        closeOnClickOutside: false
	    });
    }
});


/* Genérico: Prevenir click derecho para evitar ver código fuente. */
document.oncontextmenu = function(){
    swal({
        title: "Mensaje!",
        text: "No se permiten acciones de click derecho.",
        icon: "warning",
        button: "OK",
        dangerMode: true,
        closeOnClickOutside: false
    });
	return false;
}



/* jQuery: Cuando se termina de cargar todo el HTML de la página. */
$(document).ready(function(){

	/* Genérico: Elementos con clase 'numeric' se permiten solo números. */
	$(document).on('keyup', '.numeric', function(){
		$(this).val( this.value.replace(/[^0-9]+/ig,"") );
	});


	// Lanzar ventana modal.
	$( "#ver-modal" ).click(function( event ) {
		event.preventDefault();
		var showHtml = `
		<div class="card border-0">
			<div class="card-body" style="background: #EAF0EE; height:4000px;">
				<h5 class="card-title">Card title</h5>
				<p>Contenido en la modal.</p>
			</div>
		</div>`;

		$("#staticModal div.modal-dialog").removeClass( "modal-lg" ).addClass( "modal-xl" );
		//$("#staticModal div.modal-dialog").removeClass( "modal-lg" ).addClass( "modal-sm" );
		//$("#staticModal div.modal-dialog").removeClass( "modal-lg" ).addClass( "modal-fullscreen" );

		$('#staticModal div.modal-header h5.modal-title').html( 'Mi titulo modal' );
		$('#staticModal div.modal-body').html( showHtml );
		$('#staticModal div.modal-footer #buttonsAdd').html( `<button type="button" class="btn btn-primary">Mi boton</button>` );
		
		var myModal = new bootstrap.Modal(document.getElementById('staticModal'), {
			backdrop: 'static', // Cierre el modal al hacer clic en close.
			keyboard: false, // Cierra el modal cuando se presiona la tecla Escape
			focus: true // 	Pone el foco en el modal cuando se inicializa.
		});
		myModal.show();
	});


	// No copiar y pegar dentro de un elemento de la página.
	$('#myElement').bind('cut copy paste', function(e) {
	    e.preventDefault();
	    //swal("Mensaje!", "No se permiten acciones de copiar y pegar.", "warning");
	    swal({
	        title: "Mensaje!",
	        text: "No se permiten acciones de copiar y pegar.",
	        icon: "warning",
	        button: "OK",
	        dangerMode: true,
	        closeOnClickOutside: false
	    });
	    return false; 
	});

});	


