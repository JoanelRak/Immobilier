<main>
    <div class="image-upload-container">
        <div class="image-upload-header">
            <h2><i class="fas fa-cloud-upload-alt"></i> Ajouter des Images</h2>
        </div>
        <form class="image-upload-form" id="imageUploadForm">
            <div class="image-upload-field">
                <label for="imageUpload"><i class="fas fa-images"></i> Sélectionner des images</label>
                <div class="image-upload-input">
                    <input 
                        type="file" 
                        id="imageUpload" 
                        name="images" 
                        multiple 
                        accept="image/*"
                    >
                    <p>Glissez et déposez directement tous vos images ici ou cliquez pour sélectionner</p>
                </div>
            </div>

            <div class="image-upload-preview" id="imagePreview">
                <!-- Les aperçus des images seront ajoutés dynamiquement ici -->
            </div>

            <button type="submit" class="btn-upload">
                <i class="fas fa-upload"></i> Valider
            </button>
        </form>
    </div>

    <script>
        document.getElementById('imageUpload').addEventListener('change', function(event) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = ''; // Effacer les aperçus précédents

            Array.from(this.files).forEach(file => {
                if (file.type.match('image.*')) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'image-preview-item';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        
                        const removeBtn = document.createElement('button');
                        removeBtn.className = 'image-preview-remove';
                        removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                        removeBtn.onclick = function() {
                            div.remove();
                        };
                        
                        div.appendChild(img);
                        div.appendChild(removeBtn);
                        
                        preview.appendChild(div);
                    };
                    
                    reader.readAsDataURL(file);
                }
            });
        });

        document.getElementById('imageUploadForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const files = document.getElementById('imageUpload').files;
            
            if (files.length === 0) {
                alert('Veuillez sélectionner au moins une image');
                return;
            }

            // Logique de téléchargement des images
            const formData = new FormData(this);
            
            // Exemple de requête fetch (à adapter selon votre backend)
            fetch('/upload-images', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert('Images téléchargées avec succès');
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors du téléchargement');
            });
        });
    </script>
</main>