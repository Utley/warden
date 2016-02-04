var update = function(){
  var xhr = new XMLHttpRequest();
  xhr.open("GET","/~stephen/warden/index.php?update=TRUE");
  xhr.onload = function(){
    if(document.body.innerHTML != this.responseText){
      document.body.innerHTML = this.responseText;
    }
    console.log(this.responseText);
  };
  xhr.send();
  setTimeout(update, 1000);
};
update();
