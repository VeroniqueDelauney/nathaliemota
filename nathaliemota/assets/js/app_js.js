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

    // Lightbox
    class Lightbox {
        static init() {           
            //const links = document.querySelectorAll('.linkPhoto');
            const links = Array.from(document.querySelectorAll('a[href$=".jpg"], a[href$=".jpeg"]'));           
            const gallery = links.map(link => link.getAttribute('href'));
            if(links) {
                links.forEach(link => {
                    link.addEventListener("click", e => 
                        {
                            e.preventDefault();                            
                            new Lightbox(e.currentTarget.getAttribute('href'), gallery);
                            //alert(e.currentTarget.getAttribute('href'));
                        }                        
                    )
                });
            }
        }
        /**
         * 
         * @param { string } url URL de l'image
         * @param { string[]} images Chemins des images à afficher dans la lightbox
         */

        // "url" est l'url de l'image - On construit la structure hmtl de la lightbox
        constructor(url, images) {
            this.element = this.buildDOM(url);  
            this.images = images;
            this.loadImage(url);
            document.body.appendChild(this.element); // "element" est la lightbox     
            //alert(url);
        }

        loadImage(url)
        {
            this.url = null;
            const image = new Image();
            const container = this.element.querySelector('.lightbox_container');
            container.innerHTML = '';
            image.onload = () => {
                container.appendChild(image);
                this.url = url;
                //document.removeEventListener('keyup', this.onKeyUp);
            };
            image.src = url;
            //alert(image.src);
        }

        // BuildDOM va retourner un élément HMTL pour pouvoir travailler dessus
        /**
         * Fermer la lightbox
         * @param {MouseEvent} e 
         * @returns 
         */
        close(e) {
            e.preventDefault();
            this.element.classList.add('fadeOut');
            window.setTimeout(() => {
                this.element.parentElement.removeChild(this.element);
            }, 500);
            //document.removeEventListener('keyup', this.onKeyUp);
        };

        next(e) {
            e.preventDefault();
            let i = this.images.findIndex(image => image = this.url);
            if(i = this.images.length - 1) {
                i = -1;
            }
            this.loadImage(this.images[i + 1]);
        };

        prev(e) {
            e.preventDefault();
            let i = this.images.findIndex(image => image = this.url);            
            if(i = 0) {
                i = this.images.length;
            }
            this.loadImage(this.images[i - 1]);
        };
        
        buildDOM(url) {
            const dom = document.createElement('div');
            dom.classList.add('lightbox');
            dom.innerHTML = `<button class="lightbox_close">X</button>
                <button class="lightbox_next">Suivante</button>
	            <button class="lightbox_prev">Précédente</button>                
	            <div class="lightbox_container"></div>`;
            dom.querySelector('.lightbox_close').addEventListener('click', 
                this.close.bind(this));
            dom.querySelector('.lightbox_next').addEventListener('click', 
                this.next.bind(this));
            dom.querySelector('.lightbox_prev').addEventListener('click', 
                this.prev.bind(this));
            return dom;
        }  
        
    }
    Lightbox.init();








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
            success: function (retour_json) {
                if(retour_json) {
                    $('#picturesContainer').append(retour_json.html_content);      
                }
                // if(append_or_replace == 'append') {
                //     if(retour_json) {
                //         $('#picturesContainer').append(retour_json.html_content);      
                //     }
                //     else
                //     {
                //         alert("Hello");
                //         $('#LoadMore').hide();
                //     }                                             
                // }
                // else {
                //     $('#picturesContainer').html(retour_json.html_content);   
                // }
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

    document.getElementById("load-more-photos").addEventListener('click', function()
    {       
        currentPage ++;
        search_picture('append');
    } );

    let selects = document.querySelectorAll(".form_filter");
    selects.forEach((select) => {
        select.addEventListener("change", (event) => {
            currentPage = 1;
            search_picture('replace');
        });
    });


    

}