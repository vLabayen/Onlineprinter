function downloadPDF(){
        fetch("php/downloadPDF.php", {
                method : 'GET'
        })
        .then((response) => response.blob())
        .then((blob) => {
                downloadFile(blob);
        })
        .catch((error) => {
                console.error(error);
        });
}
function downloadFile(blob){
        let a = document.createElement("a");
        let url = URL.createObjectURL(blob);

        a.href = url;
        a.download = "scan.pdf";
        document.body.appendChild(a);
        a.click();
        setTimeout(function() {
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
        }, 0);
}

