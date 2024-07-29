<div id="contactModal" class="modal">
  <!-- Modal du formulaire de contact -->
  <div class="modal-content">
        <div class="modal-header">
            <div class="contactDesign">CONTACTCONTACTCONTACT<br><span class="second">CONTACTCONTACTCONTACT</span></div>
        </div>
        <div class="modal-body">
            <!-- Appel du shortcode WP Form du formulaire de contact -->
            <?php
                echo do_shortcode('[wpforms id="49" title="false"]');
            ?>            
        </div>
    </div>
</div>