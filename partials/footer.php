 <!-- Main Footer -->
 <footer class="main-footer">
   <!-- To the right -->
   <div class="float-right d-none d-sm-block ">
     <strong>Version 1.0.1</strong>
   </div>
   <!-- Default to the left -->
   <strong>Copyright &copy; <?php date('Y') ?> <a href="javascript:void(0);">Rian Septiadi</a>.</strong> All rights reserved.
 </footer>
 <script>
   $(document).on({
     mouseenter: function() {
       trIndex = $(this).index() + 1;
       $("table.dataTable").each(function(index) {
         $(this).find("tr:eq(" + trIndex + ")").each(function(index) {
           $(this).find("td").addClass("hover");
         });
       });
     },
     mouseleave: function() {
       trIndex = $(this).index() + 1;
       $("table.dataTable").each(function(index) {
         $(this).find("tr:eq(" + trIndex + ")").each(function(index) {
           $(this).find("td").removeClass("hover");
         });
       });
     }
   }, ".dataTables_wrapper tbody>tr");
 </script>