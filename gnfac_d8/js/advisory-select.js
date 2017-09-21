function fetcharchive(oForm){
  if (oForm.elements['year'].value != null &&
      oForm.elements['year'].value != ''){
    msg = oForm.elements['year'].value;
    if (oForm.elements['month'].value != null &&
        oForm.elements['month'].value != ''){
      msg += '/'+ oForm.elements['month'].value;
      if  (oForm.elements['day'].value != null &&
          oForm.elements['day'].value != ''){
        msg += '/'+ oForm.elements['day'].value;
        window.location.href="/advisory/"+msg;
        return false;
      }
    }
  }
  window.location.href="/archive/advisory/20"+msg;
  return false;  
}
