/**
 * @property {HTMLElement} element
 * @property {string[]} images Chemins des images à afficher dans la lightbox
 * @property {string} url Image actuellement affichée
 */

if (typeof $ === "undefined") {
	var $ = jQuery;
}

var currentPage = 1;
var allPhotos;
var currentIndex;

window.onload = function(){

     
    // Effet fade in au chargement de la page
    document.getElementById("page").style.opacity = "1";


    // Obtenir tous les blocs de photos individuelles
    function listenPhotosClick(){
        let domPhotos = document.querySelectorAll(".photos .photo");
        allPhotos = Array.from(
            domPhotos
        );
        //let inputs = document.querySelectorAll(".yes-no-toggle input");
        console.log(domPhotos);  
        domPhotos.forEach((domPhoto) => {
            domPhoto.querySelector(".zoom").addEventListener("click", (event) => {     
                openLightbox(domPhoto);
            });
        });        
    };
    listenPhotosClick();
    
  

    function openLightbox(element) {

        // Au lancement de la fonction, on rend la lightbox visible
        document.querySelector(".lightbox").style.visibility = "visible";
  
        // Récupérer les attributs des éléments de l'image
        const title = element.querySelector(".linkPhoto").getAttribute("data-title");
        const imageUrl = element.querySelector(".linkPhoto").getAttribute("data-image");
        const category = element.querySelector(".linkPhoto").getAttribute("data-category");
        const reference = element.querySelector(".linkPhoto").getAttribute("data-reference");

        // Mettre à jour les éléments de la Lightbox avec les valeurs récupérées
        document.querySelector(".jpeg").src = imageUrl;
        document.querySelector(".jpeg").style.opacity = "1";
        document.querySelector(".col1").textContent = reference.toUpperCase();
        document.querySelector(".col2").textContent = category.toUpperCase();
        // Récupérer l'index de de la photo sélectionnée en ce moment
        currentIndex = allPhotos.indexOf(element);
    }
  
    function showPrevImage() {
        // On décrémente l'image en cours
        currentIndex--;
        // Revenir à la dernière photo quand on est en dessous de 0
        if (currentIndex < 0) {
            currentIndex = allPhotos.length - 1;
        }
        // Récupérer le conteneur de l'image précédente
        const prevImageContainer = allPhotos[currentIndex];
        // On appelle la lightbox avec l'image précédente
        openLightbox(prevImageContainer);
    }
  
    function showNextImage() {
        // On incrémente l'image en cours
        currentIndex++;
        // Revenir à la première image quand on est sur la dernière
        if (currentIndex >= allPhotos.length) {
            currentIndex = 0;
        }
        // Récupérer le conteneur de l'image suivante
        const nextImageContainer = allPhotos[currentIndex];
        // On appelle la lightbox avec l'image suivante
        openLightbox(nextImageContainer);
    }
  
    // Appel des fonctions "showNextImage" et "showPrevImage" quand on clique sur "Précédente" et "Suivante"
    if(document.querySelector(".lightbox .lightbox_prev")) {
        document.querySelector(".lightbox .lightbox_prev").addEventListener("click", showPrevImage);
        document.querySelector(".jpeg").style.opacity = "0";
    }
    if(document.querySelector(".lightbox .lightbox_next")) {
        document.querySelector(".lightbox .lightbox_next").addEventListener("click", showNextImage);
        document.querySelector(".jpeg").style.opacity = "0";
    }

    // Fermer la lightbox    
    if(document.querySelector(".lightbox_close")) {
        var closeBtn = document.querySelector(".lightbox_close");
        closeBtn.addEventListener("click",function(){
            document.querySelector(".lightbox").style.visibility = "hidden";                   
        });
    }






    // Pre-fill form with reference number
    var modal = document.getElementById("contactModal");
    let btns = document.querySelectorAll(".contact-btn");
    let btnRef = document.querySelector(".reference");
    btns.forEach((btn) => {
        btn.addEventListener("click", function() {
            modal.classList.add("show");
            if(document.querySelector(".reference")) {
                const photo_ref = btnRef.getAttribute("data-ref").toUpperCase();
                
                document.getElementById("wpforms-49-field_3").setAttribute('value', photo_ref);
                document.getElementById("wpforms-49-field_3").innerHTML = "Value = " + "'" + document.getElementById("wpforms-49-field_3").value + "'";
            }
        });
    });





    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.classList.remove("show");
        }
    }






    // Show/hide image on mouseover/mouseleave on visionneuse
    function showMiniature(selecteur, miniatureDiv, eventToListen, opacityValue) {
		var arrow = document.querySelector(selecteur);
		if(arrow) {
			arrow.addEventListener(eventToListen, function() {
				document.querySelector(miniatureDiv).style.opacity = opacityValue;
			});
		};
	}
	showMiniature(".prev_arrow", ".prev", "mouseover", "1");
    showMiniature(".prev_arrow", ".prev", "mouseleave", "0");
	showMiniature(".next_arrow", ".next", "mouseover", "1");
    showMiniature(".next_arrow", ".next", "mouseleave", "0");
  
   

    
    // Mobile show/hide hamburger menu
    function hamburger() {
		var hamburgerIcon = document.querySelector(".hamburger-icon");
        var hamburgerIconClose = document.querySelector(".hamburger-icon-close");
        var topMenu = document.getElementById("topMenu");
		if(hamburgerIcon) {
			hamburgerIcon.addEventListener("click", function() {
                hamburgerIcon.style.display = "none";
				hamburgerIconClose.style.display = "block";
                if(topMenu) {
                    topMenu.style.display = "block";
                };
			});
		};
        if(hamburgerIconClose) {
			hamburgerIconClose.addEventListener("click", function() {
                hamburgerIconClose.style.display = "none";
				hamburgerIcon.style.display = "block";
                if(topMenu) {
                    topMenu.style.display = "none";
                };
			});
		};
	}
	hamburger();
  





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
                    var hamburgerIcon = document.querySelector(".hamburger-icon");
                    hamburgerIcon.style.display = "block";
                    var hamburgerIconClose = document.querySelector(".hamburger-icon-close");
                    hamburgerIconClose.style.display = "none";    
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
            },
            complete: function (retour_json) {                
                setTimeout((e) => {
                    listenPhotosClick(); // Appelle la fonction d'ouverture de la lightbox sur le fichier app_js.js
                }, 200);
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