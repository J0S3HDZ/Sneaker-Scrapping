function openNav() {
  document.getElementById("menu").style.width = "250px";
  //document.getElementById("menu").style.fontSize = "30px";
  //document.getElementById("content").style.marginLeft = "250px";
    //document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
  }
function closeNav() {
  document.getElementById("menu").style.width = "0";
  //document.getElementById("content").style.marginLeft = "0";
  //document.body.style.backgroundColor = "#F3F3F3";
  //document.getElementById("menu").style.fontSize = "0";

}
  
window.onload = function(){
  document.getElementById("menu").style.width = "0";
  document.getElementById("menu").style.fontSize = "0";
  window.onscroll = function() {
    if (document.documentElement.scrollTop > 0) {
        document.getElementById('nav').classList.add("shadow");
    } else {
        document.getElementById('nav').classList.remove("shadow");
    }
  }
}


document.addEventListener("DOMContentLoaded", function() {
  // Find the loader element
  var loader = document.querySelector(".loader");
  
  // Hide the loader element
  loader.style.display = "none";
});

function scrollToId(id){
  //prevemt default
  event.preventDefault();
  var element = document.getElementById(id);
  //add margin top 100px
  
  var top = (element.offsetTop);
  top = top - 40;
  console.log("top1: " + top);
  window.scrollTo(0, top);
  console.log("click on " + id);
  console.log("top2: " + top);
}