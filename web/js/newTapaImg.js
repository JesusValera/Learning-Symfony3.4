var validTypes = [
    'image/jpeg',
    'image/png'
];

function validateType(file) {
    for (let i = 0; i < validTypes.length; i++) {
        if (file.type === validTypes[i]) {
            return true;
        }
    }

    return false;
}

function onChange(event) {
    var file = event.target.files[0];
    console.log(file);

    if (validateType(file)) {
        var thumbnail = document.getElementById('tapaThumb');
        thumbnail.src = window.URL.createObjectURL(file);
    }
}