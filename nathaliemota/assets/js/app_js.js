/**
 * @property {HTMLElement} element
 * @property {string[]} images Chemins des images à afficher dans la lightbox
 * @property {string} url Image actuellement affichée
 */

if (typeof $ === "undefined") {
	var $ = jQuery;
}

//var current_page = 1;
var currentPage = 1;


window.onload = function(){

    // Obtenir tous les conteneurs des posts(images) du catalogue
    lightboxContainer  = document.querySelector(".lightbox");
    photos = document.querySelector(".photos");
    const allPostContainers = Array.from(
        photos.querySelectorAll(".photo")
    );
    let currentIndex;    

    function openLightbox(element) {

        // On rend la lightbox visible
        document.querySelector(".lightbox").style.visibility = "visible";
  
        // Récupérer les attributs des éléments de l'image
        //const reference = element.querySelector(".linkPhoto").getAttribute("data-position");
        const title = element.querySelector(".linkPhoto").getAttribute("data-title");
        const imageUrl = element.querySelector(".linkPhoto").getAttribute("data-image");
        const category = element.querySelector(".linkPhoto").getAttribute("data-category");
        const reference = element.querySelector(".linkPhoto").getAttribute("data-reference");
  
        // Mettre à jour les éléments de la Lightbox avec les valeurs récupérées
        document.querySelector(".jpeg").src = imageUrl;
        document.querySelector(".col1").textContent = reference.toUpperCase();
        document.querySelector(".col2").textContent = category.toUpperCase();
  
        // Récupérer l'index de l'image actuellement affichée
        currentIndex = allPostContainers.indexOf(element);
        //alert(currentIndex);
    }
  
    function showPrevImage() {
        // Décrémenter l'index de l'image actuelle
        currentIndex--;
        // Si l'index devient inférieur à zéro, revenir à la dernière image du catalogue
        if (currentIndex < 0) {
            currentIndex = allPostContainers.length - 1;
        }
        // Récupérer le conteneur de l'image précédente
        const prevImageContainer = allPostContainers[currentIndex];
        // Afficher l'image précédente dans la Lightbox
        openLightbox(prevImageContainer);
    }
  
    function showNextImage() {
        // Incrémenter l'index de l'image actuelle
        currentIndex++;
        // Si l'index dépasse la dernière image du catalogue, revenir à la première image
        if (currentIndex >= allPostContainers.length) {
            currentIndex = 0;
        }
        // Récupérer le conteneur de l'image suivante
        const nextImageContainer = allPostContainers[currentIndex];
        // Afficher l'image suivante dans la Lightbox
        openLightbox(nextImageContainer);
    }
  
    // Ajouter un gestionnaire d'événement pour ouvrir la Lightbox lorsque l'utilisateur clique sur une icône d'image
    photos.addEventListener("click", function (event) {
    // if (event.target.closest(".zoom")) {
    //   event.preventDefault();
    //   // Récupérer le conteneur de l'image correspondant à l'icône cliquée
        const postContainer = event.target.closest(".photo");
    //   // Afficher l'image dans la Lightbox
    //   openLightbox(postContainer);
    //}
    openLightbox(postContainer);
    });
  
    // Ajouter des gestionnaires d'événements pour les boutons "Prev" et "Next" de navigation
    lightboxContainer.querySelector(".lightbox_prev").addEventListener("click", showPrevImage);
    lightboxContainer.querySelector(".lightbox_next").addEventListener("click", showNextImage);


    // Fermer la lightbox
    function closeLightbox() {
        var closeBtn = document.querySelector(".lightbox_close");
        closeBtn.addEventListener("click",function(){
            document.querySelector(".lightbox").style.visibility = "hidden";                   
        });
    };
    closeLightbox();








    // MODAL
    var modal = document.getElementById("contactModal");
    var btn = document.querySelector(".contact-btn");
    if(btn) {
        btn.addEventListener("click",function(){
            alert("hello");
            modal.classList.add("show");
        });
    }
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            //modal.style.display = "none";
            modal.classList.remove("show");
        }
    }


    // Mobile menu
    function toggleMenu() {
        const btn = document.querySelector(".hamburger-icon");
        const topMenu = document.getElementById("topMenu");
        const header = document.querySelector(".header");
        btn.addEventListener("click",function(){
            topMenu.classList.add("show");
            header.style.display = "block";

            // Close menu if Contact is clicked on mobile
            if (window.innerWidth <= 480) {       
                var modal = document.getElementById("contactModal");
                var btn = document.getElementById("menu-item-69");
                btn.addEventListener("click",function(){
                    topMenu.classList.remove("show");
                });
            }
        });
    }
    toggleMenu();






    // Load more pictures 
    function search_picture(append_or_replace) {

        current_category = document.querySelector("select[name='categories']").value;
        current_format = document.querySelector("select[name='formats']").value;
        current_sort = document.querySelector("select[name='tri']").value;  
        

        $.ajax({
            type: "POST",
            dataType: "json",
            url: theme_data.ajaxurl, // Défini sur functions.php -- C'est le lien vers le fichier php
            data: {
                action: "nathaliemota",
                function: "search_picture",
                data: "category=" + current_category + "&format=" + current_format + "&sort=" + current_sort + "&page=" + currentPage,
            },
            beforeSend : function ( xhr ) {               
                //$( '#load-more-photos' ).text( 'Chargement...' );
            },
            success: function (retour_json) {  // Gère ce qui est renvoyé par le PHP         
                if(currentPage == 1) {
                    $('#picturesContainer').html(retour_json.html_content); // On écrase tout
                }
                else
                {
                    $('#picturesContainer').append(retour_json.html_content); // On ajoute à la suite de l'existant
                }
                // Gestion du bouton loadmore
                if(retour_json.has_more_pictures == 1) {
                    $('#LoadMore').show();
                }
                else
                {
                    $('#LoadMore').hide();
                }     
            },
            error: function (xhr, status, error) {
                let retour_json = JSON.parse(xhr.responseText);
                console.log("error");
                //console.log(retour_json);
            },
            complete: function (retour_json) {
                //console.log(retour_json.currentPage);
               //$('#LoadMore').hide();
                // $( '#load-more-photos' ).text( 'Charger plus' );
            }
        });
    };



    var btnLoadMorePhotos = document.getElementById("load-more-photos"); // On vérifie si le bouton existe
    if(btnLoadMorePhotos) {
        btnLoadMorePhotos.addEventListener('click', function()
        {       
            currentPage ++;
            search_picture('append');
        } );
    }


    let selects = document.querySelectorAll(".form_filter");
    selects.forEach((select) => {
        select.addEventListener("change", (event) => {
            currentPage = 1;
            search_picture('replace');
        });
    });


    

};