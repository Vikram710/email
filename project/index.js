function showpwd() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";}
    else {
        x.type = "password";}
        var y = document.getElementById("rptpwd");
        if (y.type === "password") {
            y.type = "text";}
        else {
            y.type = "password";}
    }

//


function load(){
    var url = 'https://newsapi.org/v2/top-headlines?country=in&apiKey=6efb80aebc0347038f6ebbf33aaf6e8a';
    var main= document.getElementById('main');
    var output='';
    var xhr= new XMLHttpRequest();
    xhr.open('GET',url,true);
    xhr.onload=function(){
        if(xhr.status==200){
            var news=JSON.parse(xhr.responseText);

            for(var i=0;i<20;i++){
                console.log(news);
                if(news.articles[i].urlToImage!=null){
                output+='<a href='+news.articles[i].url+'><div class="sub"><img src='+news.articles[i].urlToImage+'><h3>'+news.articles[i].title+'</h3>'
                +news.articles[i].description+'<br><h4>To Know more click on this</h4><br>Published on: '+news.articles[i].publishedAt+'</div></a>';
            }}
            main.innerHTML=output;
        }
    }
    
    xhr.send();
}
 

function openNav() {
    document.getElementById("drop").style.width = "250px";
  }
  
window.addEventListener('mouseup',function(event){
    if(event.target!=document.getElementById("drop") &&  event.target.parentNose!=document.getElementById("drop")){
        document.getElementById("drop").style.width = "0";
    }
});


function opennote() {
    document.getElementById("opennote").style.width = "400px";
    var currentdate = new Date(); 
   
    var user = document.getElementById('user').value;
    var main= document.getElementById('opennote');
    var output="";
    var url = 'note.php?username='+user;
    var xhr= new XMLHttpRequest();
    xhr.open('GET',url,true);
    xhr.onreadystatechange=function(){
        if(xhr.status==200 && xhr.readyState==4){
            var note=JSON.parse(xhr.responseText);
            for(var i=0; i<note.notifications.length;i++){
                localStorage.setItem("n",note.notifications.length);
                from=' From: '+note.notifications[i].from;
                subject=' Sub: '+note.notifications[i].subject;
                sent='<span class="note"style="font-size:14px;float:right; margin-right:2px;">'+note.notifications[i].sent+'</span>';
                output+=from+subject+sent+'<br>';
                    
            }
        main.innerHTML='<p>'+output+'</p>';
      
        }
    }
    
    xhr.send();
  }


    
window.addEventListener('mouseup',function(event){
    if(event.target!=document.getElementById("opennote") &&  event.target.parentNose!=document.getElementById("opennote")){
        document.getElementById("opennote").style.width = "0";
    }
});


function changetheme(){
    var i= parseInt(localStorage.getItem("i"));
if(i>6){
    localStorage.setItem("i","1");
}   
    var i= parseInt(localStorage.getItem("i"));
    document.body.background = "theme/"+i+".jpg";
    i++;
    localStorage.setItem("i", i);
}
if(!localStorage.getItem("i")){
    localStorage.setItem("i","1");
}

        