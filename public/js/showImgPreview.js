addEventListener("DOMContentLoaded", (event) => {
    let prewImage = document.getElementById("imagePreview")
    let fileInput = document.getElementById("imageInput")

    fileInput.addEventListener("change", (event)=>{
        const fileIN = event.target

        if (fileIN.files && fileIN.files[0]){
            const reader = new FileReader()

            reader.onload = (e) => {
                prewImage.src = e.target.result
            }

            reader.readAsDataURL(fileIN.files[0])
        }
    })
});







function displaySelectedImage(event, elementId) {
    const selectedImage = document.getElementById(elementId);
    const fileInput = event.target;

    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            selectedImage.src = e.target.result;
        };

        reader.readAsDataURL(fileInput.files[0]);
    }
}