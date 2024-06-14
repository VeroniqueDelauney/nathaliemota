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




    // Load more pictures
    document.getElementById("load-more-photos").addEventListener('click', function()
    {

        // Launch search
        $.ajax({
            type: "POST",
            dataType: "json",
            url: theme_data.ajaxurl, // Défini sur functions.php
            data: {
                action: "nathaliemota",
                function: "load_more",
                data: current_page, // current_page = 1 au chargement de la page
            },
            success: function (retour_json) {
                //alert(retour_json);
                // console.log("success");
                // console.log("data");
                console.log(retour_json);
                $('.photos').html(retour_json);
            
            },
            error: function (xhr, status, error) {
                let retour_json = JSON.parse(xhr.responseText);
                console.log("error");
                console.log(retour_json);
            },
            complete: function (data) {
                current_page ++;
            },

        });

        return;
        //alert("toto");
    } );





    // Lightbox
    class Lightbox {
        static init() {            
            //const links = document.querySelectorAll('a [href$=".jpg"], a [href$=".jpeg"]')
            const links = document.querySelectorAll('div.photo img')
            .forEach(link => link.addEventListener('click', e =>
                {   
                    alert(url);        
                    e.preventDefault() // "e" est l'évènement en cours
                    new Lightbox(e.currentTarget.getAttribute('href'))
                }
            ))
        }

        // "url" est l'url de l'image - On construit la structure hmtl de la lightbox
        constructor(url) {
            const element = this.buildDOM(url);  
            document.body.appendChild(element);           
        }
        // BuildDOM va retourner un élément HMTL pour pouvoir travailler dessus
        buildDOM(url) {
            const dom = document.createElement('div');
            dom.classList.add('lightbox');
            dom.innerHTML = `<div class="lightbox"><button class="lightbox_close">X</button>
	            <button class="lightbox_next">Suivante</button>
	            <button class="lightbox_prev">Précédente</button>
	            <div class="lightbox_container">
		        <img src="${url}" alt="">
	            </div></div>`
            return dom;
        }


    }

//     <div class="lightbox">
// 	
// </div>


    Lightbox.init();

}