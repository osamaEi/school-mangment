<script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[title]').tooltip();
    
        // Form submission handling
        $('form').on('submit', function() {
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Processing...');
        });
    
        // Reset form on modal close
        $('.modal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
            $(this).find('.is-invalid').removeClass('is-invalid');
        });
    });
    </script>
  