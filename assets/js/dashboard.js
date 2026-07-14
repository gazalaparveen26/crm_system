
window.addEventListener('DOMContentLoaded', function () {
const params =new URLSearchParams(window.location.search);
const page =params.get('page');
if(page){
    loadPage( decodeURIComponent(page) );
}
});
window.onpopstate = function(event){
if(event.state && event.state.page){
loadPage(event.state.page);
}
}
    function loadPage(page)
{
    fetch(page)
    .then(response => response.text())
    .then(data => {

        document.getElementById("content-area").innerHTML = data;

        executeScripts();

        initializeModules();

        history.pushState(
        {
            page: page
        },
        '',
        'dashboard.php?page=' + encodeURIComponent(page)
        );

    })
    
    .catch(error => {

        console.error(error);

    });
    setActiveMenu(page);

}
function executeScripts()
{

    const scripts =
    document.querySelectorAll(
    "#content-area script"
    );

    scripts.forEach(function(oldScript){

        const newScript =
        document.createElement("script");

        if(oldScript.src)
        {
            newScript.src =
            oldScript.src;
        }
        else
        {
            newScript.textContent =
            oldScript.textContent;
        }

        document.body.appendChild(newScript);

        oldScript.remove();

    });

}
function initializeModules()
{

    if(typeof initFollowups === "function")
    {
        initFollowups();
    }
if(typeof initActivity === 'function')
{
    initActivity();
}
}
setTimeout(() => {
    if (typeof initUsers === 'function') {
        initUsers();
    }
}, 100);


const menuBtn=document.getElementById("menu-btn");

const sidebar=document.getElementById("sidebar");

if(menuBtn && sidebar){

menuBtn.onclick=function(){

sidebar.classList.toggle("show");

};

document.addEventListener("click",function(e){

if(window.innerWidth>768)return;

if(!sidebar.contains(e.target) && !menuBtn.contains(e.target)){

sidebar.classList.remove("show");

}

});

window.addEventListener("resize",function(){

if(window.innerWidth>768){

sidebar.classList.remove("show");

}

});

}
