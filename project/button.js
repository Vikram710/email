function color(){
    var y = document.getElementById('text');
    var color=document.getElementById('color').value;
    y.style.color=color;

}

/*function exist(){
    var main= document.getElementById('opennote');
    var output="";
    var url = 'note.php?username='+user;
    var xhr= new XMLHttpRequest();
    xhr.open('GET',url,true);
    xhr.onreadystatechange=function(){
        if(xhr.status==200 && xhr.readyState==4){
            var note=JSON.parse(xhr.responseText);
            for(var i=0; i<note.notifications.length;i++){
                from='From: '+note.notifications[i].from;
                subject=' Sub: '+note.notifications[i].subject;
                sent='<span class="note"style="font-size:14px;float:right; margin-right:2px;">'+note.notifications[i].sent+'</span>';
                output+=from+subject+sent+'<br>';
                    
            }
        main.innerHTML='<p>'+output+'</p>';          
        }
    }
    
    xhr.send();
  }
*/