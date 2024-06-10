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
                var btn = document.getElementById("myBtn");
                btn.addEventListener("click",function(){
                    topMenu.classList.remove("show");
                    //header.style.display = "block";
                });
            }
        });
    }
    toggleMenu();
}




document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('#ajax_call').addEventListener('click', function() {
      let formData = new FormData();
      formData.append('action', 'request_recettes');   
   
      fetch(app_js.ajax_url, {
        method: 'POST',
        body: formData,
      }).then(function(response) {
        if (!response.ok) {
          throw new Error('Network response error.');
        }
      
        return response.json();
      }).then(function(data) {
        data.posts.forEach(function(post) {
          document.querySelector('#ajax_return').insertAdjacentHTML('beforeend', '<div class="col-12 mb-5">' + post.post_title + '</div>');
        });
      }).catch(function(error) {
        console.error('There was a problem with the fetch operation: ', error);
      });
    });
});