function colour (element){
    if (parseInt(element.textContent) < 0) {
        element.classList.remove("green")
        element.classList.add("red")
    }
    else if (parseInt(element.textContent) > 0){
        element.classList.remove("red")
        element.classList.add("green")
    }
    else{
        element.classList.remove("red")
        element.classList.remove("green")
    }
}