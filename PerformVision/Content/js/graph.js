        // Initialise le canevas avec Fabric.js
        var canvas = new fabric.Canvas('signatureCanvas', {
            isDrawingMode: true
        });
    
        function clearSignature() {
            canvas.clear(); // Efface tout sur le canevas
        }
    
        function saveSignature() {
            var dataURL = canvas.toDataURL({
        format: 'png',
        quality: 0.8
    }); // Convertit le canevas en une URL de données (image)
            
            // Vous pouvez envoyer 'dataURL' au serveur ou faire autre chose avec la signature
            console.log('Signature enregistrée:', dataURL);
            return dataURL ;
        }