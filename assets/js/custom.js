
$(document).ready(function() {
    // Initialize jscolor
    jscolor.installByClassName("jscolor");

    // Update color preview when input changes
    $("#spectrum_color").on('change', function() {
        updateColorPreview($(this).val());
    });

    // Initialize color preview
    updateColorPreview($("#spectrum_color").val());

    // Handle predefined color clicks
    $(".color-box").each(function() {
        $(this).css('background-color', $(this).data('color'));
        $(this).click(function() {
            var color = $(this).data('color');
            $("#spectrum_color").val(color.replace('#', ''));
            updateColorPreview(color);
        });
    });

    function updateColorPreview(color) {
        if (!color.startsWith('#')) {
            color = '#' + color;
        }
        $("#color_preview").css('background-color', color);
    }

    // Form validation
    $("#formAccountSettings").on('submit', function(e) {
        var color = $("#spectrum_color").val();
        if (!color) {
            e.preventDefault();
            alert("Please select a color");
        }
    });
});


$(document).ready(function() {
    $('#spectrum_value').on('change', function() {
      var spectrumId = $(this).val();
      
      // Debug log
      console.log('Selected spectrum ID:', spectrumId);
      
      // Clear current options
      $('#section_dropdown').empty().append('<option selected disabled>Please select section name</option>');
      
      if(spectrumId) {
          $.ajax({
              url: '<?php echo base_url("EvaluationController/getSectionsBySpectrum/"); ?>' + spectrumId,
              type: 'POST',
              dataType: 'json',
              success: function(response) {
                  console.log('AJAX Response:', response); // Debug log
                  
                  if(response && response.sections && response.sections.length > 0) {
                      $.each(response.sections, function(key, value) {
                          $('#section_dropdown').append(
                              $('<option></option>')
                                  .attr('value', value.section_id)
                                  .text(value.section_name)
                          );
                      });
                      // Trigger Select2 to update
                      $('#section_dropdown').trigger('change');
                  } else {
                      console.log('No sections found for this spectrum');
                      $('#section_dropdown').append(
                          $('<option></option>')
                              .attr('disabled', true)
                              .text('No sections available')
                      );
                  }
              },
              error: function(xhr, status, error) {
                  console.error('AJAX Error:', error);
                  console.log('Status:', status);
                  console.log('Response:', xhr.responseText);
              }
          });
      }
  });
  });

  
//   $(document).ready(function() {
//     $(".sub-level-show").hide();
//     $('.emp_sub_level').prop("disabled", true);
//     $(function(){
//       let employee_level = $('.employee_level');
//       employee_level.on('change', function(){
//       let selectedLevel = $(this).children(':selected').val();
//           if(6 == selectedLevel){
//             $(".sub-level-show").show();
//             $('.emp_sub_level').prop("disabled", false);
//           }else{
//             $(".sub-level-show").hide();
//             $('.emp_sub_level').prop("disabled", true);
//           }
//       });
//     });
//  });

 
 $(document).ready(function() {
    $("#mail_evaluation_date").hide();
      $(function(){
          var email_type = $('#email_type');
          var email_employee = $('#email_employee');
          email_type.on('change', function(){
              var selectedType = $(this).children(':selected').val();
              if(selectedType==2){
                $("#mail_evaluation_date").show();
                $('#mail_evaluation_date_select').prop("disabled", true);
                email_employee.on('change', function(){
                    var selectedEmp = $(this).children(':selected').val();
                    if(selectedEmp > 1){
                      $("#mail_evaluation_date").show();
                      $('#mail_evaluation_date_select').prop("disabled", false);
                      let employeeID = parseInt(selectedEmp);
                      if(employeeID != ''){
                          $.ajax({
                          url:"<?php echo base_url(); ?>Admin/fatchEmpEvaluation",
                          method:"POST",
                          data:{employee_id:employeeID},
                          success:function(data){
                            $('#mail_evaluation_date_select').html(data);
                          }
                          });
                      }

                    }else{
                      $("#mail_evaluation_date").hide();
                      $('#mail_evaluation_date_select').prop("disabled", true);
                    }
                });

              }else{
                $("#mail_evaluation_date").hide();
                $('#mail_evaluation_date_select').prop("disabled", true);
              }
          });
      });
      $("#mail_assign_director_emp").hide();
      $("#d_email_evaluation_date").hide();
      $(function(){
          var d_email_type = $('#d_email_type');
          var email_director = $('#email_director');
          d_email_type.on('change', function(){
              var selectedType = $(this).children(':selected').val();
              if(selectedType==2){
                $("#mail_assign_director_emp").show();
                $('#assign_director_emp_select').prop("disabled", true);
                email_director.on('change', function(){
                    var selectedDirector = $(this).children(':selected').val();
                    if(selectedDirector >= 1){
                      $("#mail_assign_director_emp").show();
                      $('#assign_director_emp_select').prop("disabled", false);
                      let directorID = parseInt(selectedDirector);
                      if(directorID != ''){
                          $.ajax({
                          url:"<?php echo base_url(); ?>Admin/fatchDirectorAssignEmp",
                          method:"POST",
                          data:{director_id:directorID},
                          success:function(data){
                            $('#assign_director_emp_select').html(data);
                            $("#d_email_evaluation_date").show();
                          }
                          });
                      }

                    }else{
                      $("#mail_assign_director_emp").hide();
                      $('#assign_director_emp_select').prop("disabled", true);
                    }
                });

              }else{
                $("#mail_assign_director_emp").hide();
                $('#assign_director_emp_select').prop("disabled", true);
              }
          });
      });
      $("#mail_assign_manager_emp").hide();
      $(function(){
          var m_email_type = $('#m_email_type');
          var email_manager = $('#email_manager');
          m_email_type.on('change', function(){
              var selectedType = $(this).children(':selected').val();
              if(selectedType==2){
                $("#mail_assign_manager_emp").show();
                $('#assign_manager_emp_select').prop("disabled", true);
                email_manager.on('change', function(){
                    var selectedManger = $(this).children(':selected').val();
                    if(selectedManger >= 1){
                      $("#mail_assign_manager_emp").show();
                      $('#assign_manager_emp_select').prop("disabled", false);
                      let managerID = parseInt(selectedManger);
                      if(managerID != ''){
                          $.ajax({
                          url:"<?php echo base_url(); ?>Admin/fatchMngerAssignEmp",
                          method:"POST",
                          data:{manager_id:managerID},
                          success:function(data){
                            $('#assign_manager_emp_select').html(data);
                          }
                          });
                      }

                    }else{
                      $("#mail_assign_manager_emp").hide();
                      $('#assign_manager_emp_select').prop("disabled", true);
                    }
                });

              }else{
                $("#mail_assign_manager_emp").hide();
                $('#assign_manager_emp_select').prop("disabled", true);
              }
          });
      });

   });

   
  $(document).ready(function(){
    $('#department_id').change(function(){
        var department_id = $('#department_id').val();
        if(department_id != ''){
        $.ajax({
        url:"<?php echo base_url(); ?>Admin/fetchDepartmentDrop",
        method:"POST",
        data:{department_id:department_id},
        success:function(data)
        {
        $('#designation_id').html(data);
        }
        });
        }
    });
  });


  $(document).ready(function() {
    $('#hasSubLevels').change(function() {
        if($(this).is(':checked')) {
            $('#subLevelsSection').show();
            addSubLevel(); // Add first input field automatically
        } else {
            $('#subLevelsSection').hide();
            $('#sub-levels-container').empty(); // Clear all sub level inputs
        }
    });
});

function addSubLevel() {
    const container = document.getElementById('sub-levels-container');
    const newSubLevel = document.createElement('div');
    newSubLevel.className = 'input-group mb-3';
    newSubLevel.innerHTML = `
        <input type="text" class="form-control" name="sub_levels[]" placeholder="Enter Sub Level">
        <button class="btn btn-outline-secondary" type="button" onclick="removeSubLevel(this)">Remove</button>
    `;
    container.appendChild(newSubLevel);
}

function removeSubLevel(button) {
    const container = document.getElementById('sub-levels-container');
    button.closest('.input-group').remove();
    
    // If no sub levels left and checkbox is still checked, add one empty field
    if(container.children.length === 0 && $('#hasSubLevels').is(':checked')) {
        addSubLevel();
    }
}
  $(document).ready(function(){
                 
    $('#edit_department_id').change(function(){
        var department_id = $('#edit_department_id').val();
        if(department_id != ''){
        $.ajax({
        url:"<?php echo base_url(); ?>Admin/fetchDepartmentDrop",
        method:"POST",
        data:{department_id:department_id},
        success:function(data)
        {
        $('#edit_designation_id').html(data);
        }
        });
        }
    });
  });

  $(document).ready(function(){
    $('#main_employee_id').change(function(){

        var employee_id = $('#main_employee_id').val();

        if(employee_id != ''){
            $.ajax({
            url:"<?php echo base_url(); ?>Admin/fetchDDInput",
            method:"POST",
            data:{employee_id:employee_id},
            success:function(data){
                $('#department_name').val(data);
            }
            });
        }
        
        if(employee_id != ''){
            $.ajax({
            url:"<?php echo base_url(); ?>Admin/fetchDesiInput",
            method:"POST",
            data:{employee_id:employee_id},
            success:function(data){
                $('#designation_name').val(data);
            }
            });
        }
    });
  });

  $(document).ready(() => {
    $("#upload").change(function () {
        const file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                $("#imgPreview")
                  .attr("src", event.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
});

$(document).ready(function(){

    $('.ManagerOpt').multiselect({
        columns: 1,
        texts: {
            placeholder: 'Select Employee',
            search     : 'Search Employee'
        },
        search: true
    });

    $(document).on('change','#evaluate_date_category' ,function(){
        var evalue_category = $('#evaluate_date_category option:selected').val();
        var date = new Date($('#start_date').val());
        let finalDate = (date.getDate() + parseInt(evalue_category));
        date.setDate(finalDate);
        var dateobj = new Date(date);
        var end_date = moment(date).format('YYYY-MM-DD');  

        $("#end_date").val(end_date);
        $("#end_date_set").val(end_date);
    });

    $(document).on('change','#start_date' ,function(){
        var evalue_category = $('#evaluate_date_category option:selected').val();
        var date = new Date($('#start_date').val());

        let finalDate = (date.getDate() + parseInt(evalue_category));
        date.setDate(finalDate);
        var dateobj = new Date(date);
        var end_date = moment(date).format('YYYY-MM-DD');  

        $("#end_date").val(end_date);
        $("#end_date_set").val(end_date);
        
    });

});
