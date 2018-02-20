/* 
 * En todas las funciones se empieza con una linea varX esta varX contiene el valor introducido en el campo
 * correspondiente del formulario, ej varNombre contiene el valor del campo nombre.
 * Para todos los campos se comprueba si su longitud es igual a 0 y despues si cumplen una expresion regular
 * si se incumple algo de esto se devuelve false.
 * 
 * El elemento x dentro de cada funcion simboliza al campo de texto que está al lado de cada input
 * en caso de que la entrada introducida en un campo sea erroneo entonces se muestra un mensaje utilizando la var
 * x. Cada entrada debajo suya tiene un parrafo en blanco la variable x es ese parrafo.
 * 
 * 
 *  varX= varX.trim(); Elimina los espacios en blanco que se encuentra a la izquierda de lo introducido y a la derecha
 *  (espacio en blanco)string1(espacio blanco)string2(espacio en blanco) = string1(espacio blanco)string2
 *  varNombre= varNombre.replace(/\s+/g, ' '); Si hay más de dos espacios en blanco entre las strings de la palabra los sustituye
 *  por solamente 1. 
 *  tring1(espacio en blanco)(espacio blanco)string2= string1(espacio blanco)string2
 */


//A partir de aqui son las funciones encargadas de la comprobación de la validez de las entradas en los formularios encargados
// de la creación de usuarios y la modificación de sus datos.


/* Funcion llamada cuando se trata de validar entradas relacionadas con los datos del adminsitrador o del profesor, también cuando se realiza
 * una petcición de asistencia a una sesión.
* */
  function comprobacionDatos(formname){

    var x;
    
    if(formname=="fpeticion"){   //Si el formulario a corregir los datos es el de realizar petición a sesión entonces solamente hay que comprobar
           isValidDNI(formname);   // que el DNI insettado y el email insertados son correctos ya que no hay más campos
           isValidEmail(formname); 
           x=(isValidDNI(formname) && isValidEmail(formname));

    }
    else{
        isValidNombre(formname); //Si el formulario es el de creación de profesor, administrador o la modificación de los datos de cualquiera de
        isValidDNI(formname);    // los datos de estos
        isValidEmail(formname);
        isValidUsuario(formname);
        isValidContraseña(formname);
    
        /* Si fallara una funcion retornaria false y entonces no se comprobarian las funciones que estan a su derecha
        * por eso se hacen las 5 llamadas de arriba y las 5 llamadas en linea que vienen a continuacion */
        x=(isValidNombre(formname) && isValidDNI(formname) && isValidEmail(formname) && isValidUsuario(formname) && isValidContraseña(formname));
    }
    return x;

}
        

//Comprueba la validez del campo nombre que simboliza el nombre y apellidos del profesor o adminsitrador
function isValidNombre(formname){
    
    var varNombre = document.forms[formname]["nombre"].value;
    
    if(varNombre.length == 0){
        var x= document.getElementById("nombre");
        x.innerHTML="Campo vacio";
        return false;
    }
    
    var x= document.getElementById("nombre");
    if(/^[a-zA-Z ]{2,40}$/.test(varNombre) == false){ //palabara compuesta de letras del alfabeto de 2 a 40 carácteres
        x.innerHTML="Error: nombre inválido solamente se aceptan carácteres del alfabeto. Longitud 2-40 carácteres.";
        return false; 
    }
    x.innerHTML="";
    varNombre= varNombre.trim();
    varNombre= varNombre.replace(/\s+/g, ' '); //una vez que hemos eliminado los espacios en blanco sobrantes actualizamos el input
    document.forms[formname]["nombre"].value= varNombre;
    return true;
}

//Comprueba la validez del campo email en el formname que se le pasa como parámetro
function isValidEmail(formname){
    
    var varEmail = document.forms[formname]["email"].value;
    var x= document.getElementById("email");
    if(varEmail.length == 0){
        var x= document.getElementById("email");
        x.innerHTML="Campo vacio";
        return false;
    }
    varEmail= varEmail.trim();
    varEmail= varEmail.replace(/  /g,' ');
    
    /*
     * Para el campo email se aceptará una cadena de la forma substring1@substring2.substring3:
            substring1 tiene que ser una cadena de longitud mayor que 1 pudiendo contener los caracteres del siguiente conjunto: abecedario en minusculas o mayúsculas, números del 0 al 9 y los caracteres ._%+-.
            substring2 tiene que ser una cadena de longitud mayor que 1  pudiendo contener los caracteres del siguiente conjunto: abecedario en minusculas o mayúsculas, números del 0 al 9 y los caracteres .- .
            substring3 tiene que ser una cadena de longitud de entre 3 y 63 carácteres que puede contener los caracteres del siguiente conjunto: abecedario en minusculas o mayúsculas.
     */
    if(!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,63}$/.test(varEmail)){
        x.innerHTML="Email introducido no sigue un formato valido.";
        return false; 
    }
    
    x.innerHTML="";
    document.forms[formname]["email"].value=varEmail;
    return true;
}

//Comprueba la validez del campo dni en el formname que se le pasa como parámetro
function isValidDNI(formname){
    var varDNI = document.forms[formname]["dni"].value;
    var numero;
    var letr;
    var letra;

    var x= document.getElementById("dni");
    
    //Se comprueba que el dni insertado es una cadena de 8 carácteres y a continuación una letra
    if(/^\d{8}[a-zA-Z]$/.test(varDNI) == true){
       numero = varDNI.substr(0,varDNI.length-1);
       letr = varDNI.substr(varDNI.length-1,1);
       numero = numero % 23;
       letra='TRWAGMYFPDXBNJZSQVHLCKET';
       letra=letra.substring(numero,numero+1);
     
     /*Se comprueba si la letra que acompaña al número es aquella que coincide con la posición correspondiente en la siguiente cadena
      *'TRWAGMYFPDXBNJZSQVHLCKET' igual al resto de dividir el número del dni entre 23.
      */
        
       if (letra!=letr.toUpperCase()) {
           x.innerHTML="Dni erroneo, la letra del NIF no se corresponde";
           return false;
       }
   }else{
     x.innerHTML="Dni erroneo, formato no válido";
     return false;
   }
   x.innerHTML="";
    varDNI= varDNI.trim();
    varDNI= varDNI.replace(/  /g,' ');
    document.forms[formname]["dni"].value=varDNI;
   return true;

}

//Comprueba la validez del campo usuario en el formulario que se le pasa como parámetro. El campo usuario simboliza el nombre de usuario
function isValidUsuario(formname){
    
    var varUsuario = document.forms[formname]["usuario"].value;

    /* Usuario valido aquella cadena que tenga entre 3 o 10 caracteres del conjunto [a-zA-Z0-9] */
    var x= document.getElementById("usuario");
    if(/^[a-zA-Z0-9]{3,10}$/.test(varUsuario) == false){
       x.innerHTML="Error, carácteres aceptados letras alfabeto más numeros. Longitud 3-10 carácteres.";
       return false;
    
   }
    varUsuario=varUsuario.trim();
    varUsuario= varUsuario.replace(/\s+/g, ' ');
    document.forms[formname]["usuario"].value=varUsuario;
    x.innerHTML="";
   return true;

}
//Comprueba la validez del campo contraseña en el formulario que se le pasa como parámetro.
function isValidContraseña(formname){
    var varContraseña = document.forms[formname]["contraseña"].value;
    var retVar=false;
    
    if(formname=="fmodificarusuario" && varContraseña==""){ 
        
    /*Si no se ha introducido nada en el campo de la contraseña y es form de modificar
    * los datos de un usuario entonces significa que no se va a cambiar la contraseña 
    *  asi que no se realizan comprobaciones.
    * */
        retVar=true;
        
    }
    else{
        var x= document.getElementById("contraseña");
        //La contraseña válida es aquella formada por letras y números que tiene como longitud entre 5 y 10 carácteres-
        if(/^[a-zA-Z0-9]{5,10}$/.test(varContraseña) == false){
            x.innerHTML="Error, carácteres aceptados letras alfabeto más numeros. Longitud 5-10 carácteres.";
            retVar=false;
    
        }else{
            retVar=true;
        }
        varContraseña=varContraseña.trim();
        varContraseña= varContraseña.replace(/\s+/g, ' ');
        if(retVar){
            x.innerHTML="";
        }
        document.forms[formname]["contraseña"].value=varContraseña;
    }
   return retVar;

}





//A partir de aqui son las funciones encargadas de la comprobación de la validez de las entradas en los formularios encargados
// de las sesiones. Es decir creación sesiones y modificación de sesiones.


  $(function() {
    $( "#datepicker" ).datepicker({
        dateFormat: 'dd/mm/yy',
        maxDate:"+2m",
        minDate: 0
    });
  });
  


//Comprueba la validez de la fecha introducida en el input llamado fecha
function isValidDate(formname)
{
    // Primero obtenemos el elemento input llamado fecha
    var dateString = document.forms[formname]["fecha"].value;
    
    //Comprobamos que no sea nulo
    if(dateString.length == 0){
        var x= document.getElementById("fecha");
        x.innerHTML="Error: campo vacio";
        return false;
    }
    
    var retVar;
    //Chequeamos que sigue el patron nºnº/nºnº/nºnºnºnº
    if(!/^\d{2}\/\d{2}\/\d{4}$/.test(dateString))
        retVar= false;
    //Pasamos los datos insertados en el inputs a enteros
    var parts = dateString.split("/");
    var day = parseInt(parts[0], 10);
    var month = parseInt(parts[1], 10);
    var year = parseInt(parts[2], 10);
    
    //Comprobamos el rango del  mes y el año
    if(year < 1000 || year > 3000 || month == 0 || month > 12)
        retVar= false;

    
    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

    // Año bisiesto
    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
        monthLength[1] = 29;

    //Comprobamos si la longitud de dias del mes introducido es correcta
    if((day > 0 && day <= monthLength[month - 1] )== false)
        retVar= false;
    
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //Enero es 0!
    var yyyy = today.getFullYear();
    
    //Comprobamos que la fecha insertada no es anterior a la actual.
    if(year < yyyy || (year == yyyy && month < mm) || (year == yyyy && month == mm && day < dd))
        retVar= false;
    
    /*Si la fecha insertada no cumple alguna de las anteriores condiciones se avisa al usuario
     * para ello obtenemos el parrafo asociado al input fecha y mostramos en el un mensaje de error
     */
    
    var x= document.getElementById("fecha");
    if(retVar == false){
        x.innerHTML="Error: fecha erronea. Formato válido dd/mm/yyyy";
        return false;
    } //si no hay error entonces el parrafo asociado no muestra nada
    else x.innerHTML="";
    
    
    dateString=dateString.trim(); //quitamos los posibles espacios en blancos de los <--extremos-->
    document.forms[formname]["fecha"].value=dateString;

    return true;

};

//Comprueba la validez de las horas introducidas, hora identifica al campo dentro del form será o hinicio o hfin
function isValidTime(formname,hora){
    //Obtenemos los datos insertados en el input
    var dateString = document.forms[formname][hora].value;
    var retVar;
    //Obtenemos el parrafo anexo al input
    var x= document.getElementById(hora);
    if(dateString.length == 0){
        x.innerHTML="Error: campo vacio";
        return false;
    }
    dateString=dateString.trim();
    document.forms[formname][hora].value=dateString; //quitamos los posibles espacios en blancos de los <--extremos-->
    if(!/^\d{1,2}\:\d{1,2}$/.test(dateString)){ //comprobamos que cumple expresión regular aa:aa las a pudiendo ser números
        x.innerHTML="Error: formato erroneo. Formato aceptado: \"hh:mm\" ";
        retVar= false;
    }

    // Pasamos a enteros los datos introducidos en el input hora pasado como parámetro
    var parts = dateString.split(":");
    var hour = parseInt(parts[0], 10);
    var minute = parseInt(parts[1], 10);
    
    //Comprobamos que el rango de las horas y de los minutos es válido
    if(hour < 0 || hour > 24 || minute <0 || minute>60 )
        retVar= false;
    
    var x= document.getElementById(hora);
    if(retVar == false){
        x.innerHTML="Error: hora erronea";      //Si hay algun error con los datos introducidos en el input hora entonces mostramos mensaje de error en el
        return false;                           //parrafo asociado a ese campo input hora (hinicio o hfin)
    }
    x.innerHTML="";
    dateString = dateString.trim(); //Quitamos los posibles espacio en blanco
    document.forms[formname][hora].value=dateString; // y a continuación introducimos el valor en el input sin los espacios en blanco
    return true;
}

//Comprueba la validez de los datos introducidos en el campo ndespacho de formname
function isValidDespacho(formname){
    
    var numero = document.forms[formname]["ndespacho"].value;
    var x= document.getElementById("ndespacho");
    numero=numero.trim();
    document.forms[formname]["ndespacho"].value=numero;     //Refrescamos los datos introducidos en el campo ndespacho de formname ahora sin espacios en los extremos
    if(!/^\d{1,2}$/.test(numero)){ //Si no es un número de uno o dos dígitos entonces fallo
        x.innerHTML="Error: formato erroneo. Introduzca un solo número."
            return false;
    }
    
    if(numero.length == 0){     //Si está vacio entonces fallo
        x.innerHTML="Error: campo vacio";
        return false;
    }
    

    if(numero < 0 || numero > 100){ //Si es un número negativo o mayor que 100 fallo
        
        x.innerHTML="Error: número despacho inexistente.";
        return false; 
    }
    x.innerHTML="";
    
    numero=numero.trim();
    document.forms[formname]["ndespacho"].value=numero; 
    
    return true;
}

//Comprueba la validez de los datos introducidos en el campo asignatura
function isValidAsignatura(formname){
    
    var varAsignatura = document.forms[formname]["asignatura"].value;
    
    //Si el campo asignatura de formname está vacio entonces fallo
    if(varAsignatura.length == 0){
        var x= document.getElementById("asignatura");
        x.innerHTML="Campo vacio";
        return false;
    }
    
    var x= document.getElementById("asignatura");
    if(varAsignatura.length >100){ //Si el nombre de la asignatura tiene más de 100 carácteres entonces fallo
        x.innerHTML="Error: nombre de la asignatura debe ser menor de 100 carácteres.";
        return false; 
    }
    x.innerHTML="";
    varAsignatura=varAsignatura.trim();//quitamos los posibles espacios en blancos de los <--extremos-->
    varAsignatura= varAsignatura.replace(/\s+/g, ' ');//sustituimos los posibles múltiples espacios entre palabras por solamente uno
    document.forms[formname]["asignatura"].value=varAsignatura;
    return true;
}

//Comprueba la validez de los datos introducidos en el input curso
function isValidCurso(formname){
    
    var varCurso = document.forms[formname]["curso"].value; //Obtenemos los datos introducidos en el input curso
    
    if(varCurso.length == 0){
        var x= document.getElementById("curso");
        x.innerHTML="Campo vacio";
        return false;
    }
    varCurso=varCurso.trim();//quitamos los posibles espacios en blancos de los <--extremos-->
    varCurso= varCurso.replace(/  /g,' ');//sustituimos los posibles múltiples espacios entre palabras por solamente uno
    
    var x= document.getElementById("curso");
    if(!/^[1-4][a-hA-H]$/.test(varCurso)){//Si los datos introducidos no cumplmen "nl", siendo "n" un número entre 1 y 4 y "l" una letra en a-h o A-H
        x.innerHTML="Error: nº curso debe estar entre 1 y 4, letra entre A y H";
        return false; 
    }
    
    x.innerHTML=""; //Si no hay fallo en el parrafo anexo al input no se pone nada
    document.forms[formname]["curso"].value=varCurso;  //refrescamos los datos introducimos en el campo curso pero ahora sin espacios en blanco inválidos.
    return true;
}

//Comprueba si los datos introducidmos en el formulario identificado por formname cumplen las condiciones impusetas por las funcions que vienen a continuación
function comprobacionDatosSesiones(formname){

    var x;
    isValidDate(formname); //campo fecha del formulario válido? si hay fallo mostramos mensaje de error
    isValidTime(formname, "hinicio"); //campo hinicio del formulario válido? si hay fallo mostramos mensaje de error
    isValidTime(formname, "hfin");//campo hfin del formulario válido? si hay fallo mostramos mensaje de error
    isValidDespacho(formname);//campo ndespacho del formulario válido? si hay fallo mostramos mensaje de error
    isValidAsignatura(formname);//campo asignatura del formulario válido? si hay fallo mostramos mensaje de error
    isValidCurso(formname);//campo curso del formulario válido? si hay fallo mostramos mensaje de error
    isValidUsuario(formname); //campo usuario del formulario válido? si hay fallo mostramos mensaje de error
    
    //X es true si no ninguna de las funciones detecta ningun error en los datos introducidos
    x=(isValidDate(formname) && isValidTime(formname, "hinicio") && isValidTime(formname, "hfin") && isValidUsuario(formname) && isValidDespacho(formname) && isValidAsignatura(formname) && isValidCurso(formname));

    return x;

}
