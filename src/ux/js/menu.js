function showMenu() {
    const btnMenu = document.querySelector("#menuBtn");
    const menu = document.querySelector("#menu");

    btnMenu.addEventListener("click", function (){
        menu.classList.toggle("show");
        menu.classList.add("transition");
        setTimeout(() => { menu.classList.remove("transition"); }, 500);
    });

}
showMenu()









