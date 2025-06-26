document.addEventListener('DOMContentLoaded', () => {
    const publishButton = document.getElementById('publish-post');
    const postTextarea = document.getElementById('post-text');
    const postMediaInput = document.getElementById('post-media');
    const postsContainer = document.getElementById('posts-container');
    const loadingSpinner = document.querySelector('.loading-spinner');

    // --- Fonctions de communication avec l'API (Backend) ---

    async function fetchPosts() {
        try {
            const response = await fetch('api/get_posts.php');
            if (!response.ok) throw new Error('Erreur réseau');
            return await response.json();
        } catch (error) {
            console.error('Impossible de charger les publications:', error);
            postsContainer.innerHTML = `<div class="post-card"><p>Erreur de chargement des publications.</p></div>`;
            return [];
        }
    }

    async function publishPost(formData) {
        try {
            const response = await fetch('api/add_post.php', {
                method: 'POST',
                body: formData
            });
            if (!response.ok) throw new Error('Erreur lors de la publication');
            return await response.json();
        } catch (error) {
            console.error('Erreur de publication:', error);
            alert('Une erreur est survenue.');
        }
    }

    // --- Fonctions d'affichage ---

    function createPostCard(post) {
        const postCard = document.createElement('div');
        postCard.classList.add('post-card');
        postCard.setAttribute('data-post-id', post.id);

        let mediaHtml = '';
        if (post.media) {
            mediaHtml = `<img src="${post.media}" alt="Média de la publication">`;
        }
        
        // Calcul du temps écoulé
        const postDate = new Date(post.timestamp);
        const timeAgo = timeSince(postDate);


        postCard.innerHTML = `
            <div class="post-header">
                <div class="avatar">${post.avatar || post.nom_utilisateur.substring(0, 2).toUpperCase()}</div>
                <div class="post-info">
                    <span class="username">${post.nom_utilisateur}</span>
                    <span class="timestamp">${timeAgo}</span>
                </div>
            </div>
            <div class="post-content">
                <p>${post.contenu}</p>
                ${mediaHtml}
            </div>
            <div class="post-actions">
                <button class="like-button">
                    <i class="fas fa-heart"></i> J'aime (${post.likes})
                </button>
                <button class="comment-button">
                    <i class="fas fa-comment"></i> Commenter
                </button>
                <button class="share-button">
                    <i class="fas fa-share"></i> Partager
                </button>
            </div>
        `;
        return postCard;
    }

    async function displayPosts() {
        loadingSpinner.style.display = 'block';
        postsContainer.innerHTML = '';
        const posts = await fetchPosts();
        loadingSpinner.style.display = 'none';

        if (posts && posts.length > 0) {
            posts.forEach(post => {
                const postCard = createPostCard(post);
                postsContainer.appendChild(postCard);
            });
        } else {
            postsContainer.innerHTML = `<div class="post-card"><p>Aucune publication pour le moment. Soyez le premier à partager !</p></div>`;
        }
    }
    
    // Fonction pour calculer le temps écoulé
    function timeSince(date) {
        const seconds = Math.floor((new Date() - date) / 1000);
        let interval = seconds / 31536000;
        if (interval > 1) return "Il y a " + Math.floor(interval) + " ans";
        interval = seconds / 2592000;
        if (interval > 1) return "Il y a " + Math.floor(interval) + " mois";
        interval = seconds / 86400;
        if (interval > 1) return "Il y a " + Math.floor(interval) + " jours";
        interval = seconds / 3600;
        if (interval > 1) return "Il y a " + Math.floor(interval) + " heures";
        interval = seconds / 60;
        if (interval > 1) return "Il y a " + Math.floor(interval) + " minutes";
        return "À l'instant";
    }


    // --- Gestion des événements ---

    publishButton.addEventListener('click', async () => {
        const content = postTextarea.value.trim();
        const mediaFile = postMediaInput.files[0];

        if (content === '' && !mediaFile) {
            alert('Veuillez écrire quelque chose ou ajouter un média.');
            return;
        }

        const formData = new FormData();
        formData.append('content', content);
        if (mediaFile) {
            formData.append('media', mediaFile);
        }

        const result = await publishPost(formData);

        if (result && result.success) {
            postTextarea.value = '';
            postMediaInput.value = '';
            await displayPosts(); // Recharger les publications
        }
    });

    // --- Initialisation ---
    displayPosts();
});