if (typeof $ === "undefined") {
	var $ = jQuery;
}

var current_page = 1;



window.onload = function(){

    // MODAL
    var modal = document.getElementById("contactModal");
    var btn = document.querySelector(".contact-btn");
    if(btn) {
        btn.addEventListener("click",function(){
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





    // $('#load-more').on('click', function() {
    //   currentPage++; // Do currentPage + 1, because we want to load the next page
    
    //   $.ajax({
    //     type: 'POST',
    //     url: '/wp-admin/admin-ajax.php',
    //     dataType: 'html',
    //     data: {
    //       action: 'weichie_load_more',
    //       paged: currentPage,
    //     },
    //     success: function (res) {
    //       $('.publication-list').append(res);
    //     }
    //   });
    // });



    // Load more pictures 
    var currentPage = 1;
    document.getElementById("load-more-photos").addEventListener('click', function()
    {       
        currentPage ++;
        $.ajax({
            type: "POST",
            dataType: "json",
            url: theme_data.ajaxurl, // Défini sur functions.php -- C'est le lien vers le fichier php
            data: {
                action: "nathaliemota",
                paged: currentPage, // current_page = 1 au chargement de la page
                function: "load_more",
                //data: current_page, // current_page = 1 au chargement de la page/
            },
            beforeSend : function ( xhr ) {               
                $( '#load-more-photos' ).text( 'Chargement...' );
            },
            success: function (retour_json) {
                if(retour_json)
                {
                    // alert(retour_json); // Retourne <div class='photo'><a href='' class='linkPhoto'><img src='http://nathaliemota.local/wp-content/uploads/2024/06/nathalie-13-scaled.jpeg' alt='1'></a></div> 
                    $('.photosNew').append(retour_json);
                }
                else
                {
                    document.getElementById("load-more-photos").remove() // Remove load more button
                } 
            },
            error: function (xhr, status, error) {
                let retour_json = JSON.parse(xhr.responseText);
                console.log("error");
                console.log(retour_json);
            },
            complete: function (data) {
                $( '#load-more-photos' ).text( 'Charger plus' );
            }
        });
        return;
        alert("toto");
    } );







    // Lightbox
    class Lightbox {
        static init() { 
          
            //const links = document.querySelectorAll('a [href$=".jpg"], a [href$=".jpeg"]')
            
            const links = document.querySelectorAll('.linkPhoto');
            if(links) {
                links.forEach(link => {
                    link.addEventListener("click",function(){
                        alert("hello");    
                        // e.preventDefault() // "e" est l'évènement en cours
                        // // currentTarget est le nom du lien sur lequel on vient de cliquer - on récupère la valeur de href
                        // new Lightbox(e.currentTarget.getAttribute('href'))
                        // document.querySelector(".main-navigation").classList.remove("toggled");
                        // document.querySelector(".menu-toggle").classList.remove("rotate");
                        // document.querySelector(".menu-toggle").setAttribute("aria-expanded", false);
                        // document.getElementById("showMenu").style.display = "none";
                    });
                });
            }

        }






        // "url" est l'url de l'image - On construit la structure hmtl de la lightbox
        constructor(url) {
            const element = this.buildDOM(url);  
            document.body.appendChild(element); // "element" est la lightbox     
        }

        // BuildDOM va retourner un élément HMTL pour pouvoir travailler dessus
        buildDOM(url) {
            const dom = document.createElement('div');
            dom.classList.add('lightbox');
            dom.innerHTML = `<button class="lightbox_next">Suivante</button>
	            <button class="lightbox_prev">Précédente</button>
	            <div class="lightbox_container">
		        <img src="${url}" alt="">
	            </div>`
            return dom;
        }  
    }

    Lightbox.init();

}