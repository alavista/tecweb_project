function formhash(form, password) {
   // Crea un elemento di input che verrà usato come campo di output per la password criptata.
   var p = document.createElement("input");
   // Aggiungi un nuovo elemento al tuo form.
   form.append(p);

   p.name = "p";
   p.type = "hidden"
   p.value = hex_sha512(password.val());
   // Assicurati che la password non venga inviata in chiaro.
   password.val("");
   // Come ultimo passaggio, esegui il 'submit' del form.
   form.submit();
}
