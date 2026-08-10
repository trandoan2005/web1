const imageInput = document.getElementById("image");
if (imageInput) {
    imageInput.addEventListener("change", function () {
        const preview = document.getElementById("preview");
        preview.innerHTML = "";
        const files = this.files;
        for (let i = 0; i < files.length; i++) {
            const img = document.createElement("img");
            img.src = URL.createObjectURL(files[i]);
            img.width = 200;
            img.className = "img-thumbnail";
            preview.appendChild(img);
        }
    });
}

const imagesInput = document.getElementById("images");
if (imagesInput) {
    imagesInput.addEventListener("change", function () {
        const preview = document.getElementById("preview-gallery");
        if (preview) preview.innerHTML = "";
        const files = this.files;
        for (let i = 0; i < files.length; i++) {
            const img = document.createElement("img");
            img.src = URL.createObjectURL(files[i]);
            img.width = 200;
            img.className = "img-thumbnail m-1";
            if (preview) preview.appendChild(img);
        }
    });
}
