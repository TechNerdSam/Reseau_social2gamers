document.addEventListener('DOMContentLoaded', () => {
    const publishButton = document.getElementById('publish-post');
    const postTextarea = document.getElementById('post-text');
    const postMediaInput = document.getElementById('post-media');
    const postsContainer = document.getElementById('posts-container');
    const loadingSpinner = document.querySelector('.loading-spinner');
    const onlineFriendsGrid = document.querySelector('.online-friends-grid');

    // --- Données simulées (viendraient d'un back-end réel) ---
    let posts = [ // Utilisation de 'let' car nous allons ajouter des posts
        {
            id: 1,
            username: "GamerPro77",
            avatar: "GP",
            timestamp: "2 heures",
            content: "Incroyable session sur Valorant ce soir ! Qui est partant pour une partie demain ? #Valorant #GamingLife",
            media: "https://images.unsplash.com/photo-1612287232292-80327f12e84d?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
            likes: 15,
            comments: 3,
            liked: false
        },
        {
            id: 2,
            username: "PixelHunter",
            avatar: "PH",
            timestamp: "Hier",
            content: "Je viens de finir The Witcher 3 pour la 5ème fois. Toujours aussi époustouflant. Quel est votre moment préféré ? #TheWitcher3 #RPG",
            media: "https://images.unsplash.com/photo-1542779283-42994ff548df?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
            likes: 42,
            comments: 8,
            liked: false
        },
        {
            id: 3,
            username: "CodeNinja",
            avatar: "CN",
            timestamp: "3 jours",
            content: "Nouveau setup PC terminé ! Enfin prêt pour les prochains défis. Regardez cette bête ! #GamingSetup #PCGaming",
            media: "https://images.unsplash.com/photo-1601619472626-d3523fe7194f?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
            likes: 28,
            comments: 5,
            liked: true
        }
    ];

    const onlineFriends = ["AlphaGamer", "MysticMage", "ShadowStrike", "ElitePlayer", "NeonKnight", "CyberKnight", "GameLord"];

    // --- Fonctions d'Utilité ---

    // Calcule un temps relatif (ex: 'il y a 5 minutes')
    function timeAgo(date) {
        const seconds = Math.floor((new Date() - date) / 1000);
        let interval = seconds / 31536000;
        if (interval > 1) return Math.floor(interval) + " ans";
        interval = seconds / 2592000;
        if (interval > 1) return Math.floor(interval) + " mois";
        interval = seconds / 86400;
        if (interval > 1) return Math.floor(interval) + " jours";
        interval = seconds / 3600;
        if (interval > 1) return Math.floor(interval) + " heures";
        interval = seconds / 60;
        if (interval > 1) return Math.floor(interval) + " minutes";
        return Math.floor(seconds) + " secondes";
    }

    // Crée une carte de publication
    function createPostCard(post) {
        const postCard = document.createElement('div');
        postCard.classList.add('post-card');
        postCard.setAttribute('data-post-id', post.id);

        let mediaHtml = '';
        if (post.media) {
            // Un vrai projet utiliserait une meilleure gestion des types de médias
            const mediaExtension = post.media.split('.').pop().toLowerCase();
            if (['jpeg', 'jpg', 'gif', 'png', 'webp'].includes(mediaExtension)) {
                mediaHtml = `<img src="${post.media}" alt="Publication média">`;
            } else if (['mp4', 'webm', 'ogg'].includes(mediaExtension)) {
                mediaHtml = `<video controls src="${post.media}"></video>`;
            }
        }

        postCard.innerHTML = `
            <div class="post-header">
                <div class="avatar">${post.avatar}</div>
                <div class="post-info">
                    <span class="username">${post.username}</span>
                    <span class="timestamp">il y a ${post.timestamp}</span>
                </div>
            </div>
            <div class="post-content">
                <p>${post.content}</p>
                ${mediaHtml}
            </div>
            <div class="post-actions">
                <button class="like-button ${post.liked ? 'liked' : ''}" data-post-id="${post.id}">
                    <i class="fas fa-heart"></i> J'aime (<span class="like-count">${post.likes}</span>)
                </button>
                <button class="comment-button">
                    <i class="fas fa-comment"></i> Commenter (${post.comments})
                </button>
                <button class="share-button">
                    <i class="fas fa-share"></i> Partager
                </button>
            </div>
        `;

        // Gestion du bouton "J'aime"
        const likeButton = postCard.querySelector('.like-button');
        const likeCountSpan = postCard.querySelector('.like-count');

        likeButton.addEventListener('click', () => {
            const postId = parseInt(likeButton.dataset.postId);
            const postIndex = posts.findIndex(p => p.id === postId);

            if (postIndex !== -1) {
                let currentLikes = posts[postIndex].likes;
                if (!posts[postIndex].liked) {
                    currentLikes++;
                    posts[postIndex].liked = true;
                    likeButton.classList.add('liked');
                    // Animation du bouton au like
                    gsap.to(likeButton, {
                        scale: 1.1,
                        duration: 0.2,
                        ease: "power2.out",
                        onComplete: () => gsap.to(likeButton, { scale: 1, duration: 0.2 })
                    });
                    gsap.fromTo(likeCountSpan, { scale: 0.8, opacity: 0 }, { scale: 1, opacity: 1, duration: 0.3, ease: "back.out(1.7)" });
                } else {
                    currentLikes--;
                    posts[postIndex].liked = false;
                    likeButton.classList.remove('liked');
                }
                posts[postIndex].likes = currentLikes;
                likeCountSpan.textContent = currentLikes;
            }
        });

        return postCard;
    }

    // Affiche les publications initiales avec une animation en cascade
    function displayInitialPosts() {
        // Cacher le spinner après un court délai pour simuler le chargement
        gsap.to(loadingSpinner, {
            opacity: 0,
            duration: 0.5,
            onComplete: () => {
                loadingSpinner.style.display = 'none';
                posts.forEach((post, index) => {
                    const postCard = createPostCard(post);
                    postsContainer.prepend(postCard);
                    // Animation d'entrée en cascade avec GSAP
                    gsap.from(postCard, {
                        opacity: 0,
                        y: 50,
                        duration: 0.8,
                        ease: "power3.out",
                        delay: index * 0.15 // Délai pour l'effet de cascade
                    });
                });
            }
        });
    }

    // Génère les avatars d'amis en ligne
    function displayOnlineFriends() {
        onlineFriends.forEach((friend, index) => {
            const friendAvatar = document.createElement('div');
            friendAvatar.classList.add('friend-avatar');
            friendAvatar.textContent = friend.charAt(0); // Première lettre de l'ami
            onlineFriendsGrid.appendChild(friendAvatar);

            // Animation des avatars des amis
            gsap.from(friendAvatar, {
                opacity: 0,
                scale: 0,
                duration: 0.5,
                ease: "back.out(1.7)",
                delay: 1.5 + index * 0.08 // Délai après l'animation principale
            });
        });
    }

    // --- Gestion des Événements ---

    // Gérer la publication d'un nouveau post
    publishButton.addEventListener('click', () => {
        const postContent = postTextarea.value.trim();
        const postMediaFile = postMediaInput.files[0];

        if (postContent === '' && !postMediaFile) {
            gsap.to(postTextarea, { x: 10, yoyo: true, repeat: 3, duration: 0.05, ease: "power1.inOut" });
            alert('Veuillez écrire quelque chose ou ajouter un média pour publier.');
            return;
        }

        let mediaUrl = null;
        if (postMediaFile) {
            mediaUrl = URL.createObjectURL(postMediaFile);
            // Ici, dans un vrai projet, le fichier serait uploadé sur un serveur
            // et mediaUrl serait l'URL retournée par ce serveur.
        }

        const newPost = {
            id: posts.length + 1,
            username: "VotreNomDeGamer", // Remplacer par le nom de l'utilisateur réel
            avatar: "VG",
            timestamp: timeAgo(new Date()),
            content: postContent,
            media: mediaUrl,
            likes: 0,
            comments: 0,
            liked: false
        };

        posts.unshift(newPost); // Ajoute le nouveau post au début du tableau
        const newPostCard = createPostCard(newPost);
        postsContainer.prepend(newPostCard); // Ajouter la nouvelle publication en haut du flux

        // Animer l'apparition de la nouvelle publication avec GSAP
        gsap.from(newPostCard, {
            opacity: 0,
            y: 50,
            duration: 0.8,
            ease: "power3.out"
        });

        // Réinitialiser les champs et animer la réinitialisation
        gsap.to(postTextarea, {
            height: '100px', // Revenir à la hauteur initiale si elle a été redimensionnée
            duration: 0.3
        });
        postTextarea.value = '';
        postMediaInput.value = '';
    });

    // Animer l'input de texte lors du focus
    postTextarea.addEventListener('focus', () => {
        gsap.to(postTextarea, {
            height: '150px', // Agrandir la zone de texte au focus
            duration: 0.3,
            ease: "power2.out"
        });
    });

    postTextarea.addEventListener('blur', () => {
        if (postTextarea.value.trim() === '') {
            gsap.to(postTextarea, {
                height: '100px', // Réduire si vide après focus
                duration: 0.3,
                ease: "power2.out"
            });
        }
    });

    // --- Animations d'Introduction GSAP ---
    gsap.timeline({ defaults: { ease: "power3.out" } })
        .from(".navbar", { y: -100, opacity: 0, duration: 1 })
        .from(".sidebar", { x: -50, opacity: 0, duration: 0.8 }, "<0.4") // "<0.4" = 0.4s après le début de l'animation précédente
        .from(".post-creator-card", { y: 50, opacity: 0, duration: 0.8 }, "<0.4")
        .add(displayInitialPosts, ">0.5"); // Afficher les posts après les animations initiales

    // Afficher les amis en ligne après un léger délai
    displayOnlineFriends();
});