<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>

$(document).ready(function() {
    $('#historyApprovalModal').modal('show');
});
// Initialize jscolor picker
document.querySelectorAll('.jscolor').forEach(input => {
    new jscolor(input, {
        format: 'hex'
    });
});

// Handle color box clicks
document.querySelectorAll('.color-box').forEach(box => {
    box.addEventListener('click', function() {
        const color = this.dataset.color;
        const modalId = this.closest('.modal').id;
        const input = document.querySelector(`#${modalId} .jscolor`);
        input.value = color.replace('#', '');
        input.style.backgroundColor = color;
    });
});

// Handle level changes
$('.employee_level').on('change', function() {
    const levelId = $(this).val();
    const modal = $(this).closest('.modal');

    $.ajax({
        url: '<?php echo base_url("admin/AM_Controller/getSubLevels"); ?>',
        type: 'POST',
        data: { level_id: levelId },
        success: function(response) {
            const subLevels = JSON.parse(response);

            let options = '<option value="">Select Sub Level</option>';
            
            subLevels.forEach(level => {
                options += `<option value="${level.employee_sub_level_id}">${level.employee_sub_level_name}</option>`;
            });
            
            modal.find('.emp_sub_level').html(options);
        }
    });
});
</script>
    <!-- Employee Email Check is avalible -->
    <script>

        $(document).ready(function() {
            $("#vaild_email").hide();
            $("#login_email").keyup(function(){
                var email = $("#login_email").val();
                // console.log(email);
                if(email != ''){
                  $.ajax({
                  url:"<?php echo base_url(); ?>admin/AM_Controller/checkValidAccount",
                  method:"POST",
                  data:{email:email},
                  success:function(data){
                    if(data==1){
                      $("#vaild_email").show();
                    }else{
                      $("#vaild_email").hide();
                    }
                  }
                  });
                }
            });
        });

        $(document).ready(function(){
            $('#department_id').change(function(){
                var department_id = $('#department_id').val();
                if(department_id != ''){
                $.ajax({
                url:"<?php echo base_url(); ?>admin/AM_Controller/fetchDepartmentDrop",
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

        // ... existing code ...

        $(document).ready(function() {
            $('.employee_level').on('change', function() {
                var levelId = $(this).val();

                // alert(levelId);
                $.ajax({
                    url:"<?php echo base_url(); ?>admin/AM_Controller/getSubLevels",
                    type: 'POST',
                    data: {level_id: levelId},
                    success: function(response) {
                        var data = JSON.parse(response);
                        
                        var html = '';
                        
                        if(data && data.length > 0) {
                            
                            $.each(data, function(index, item) {
                                html = '<option selected value="' + item.employee_sub_level_id + '">' + item.employee_sub_level_name + '</option>';
                            });
                            $('.emp_sub_level').prop('disabled', false); // Enable the select
                        } else {
                            html = '<option value="">No sub levels available</option>';
                        }
                        
                        $('.emp_sub_level').html(html).trigger('change'); // Trigger change event for select2
                        $('.sub-level-show').show();
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            });

            // Initialize select2
            $('.emp_sub_level').select2({
                width: '100%'
            });
        });

        

        // $(document).ready(function() {
        //     $('.employee_level').on('change', function() {
        //         var levelId = $(this).val();
        //         console.log('Selected Level:', levelId);
                
        //         if (!levelId) {
        //             console.log('No level selected');
        //             return;
        //         }
                
        //         $.ajax({
        //             url:"<?php //echo base_url(); ?>admin/AM_Controller/getUserRole",
        //             type: 'POST',
        //             data: {employee_level: levelId},
        //             dataType: 'json',
        //             success: function(response) {
        //                 console.log('Raw response:', response);
                        
        //                 if (response && response.status === 'success' && response.employee_level_value) {
        //                     var html = '<input type="hidden" name="user_role" value="' + response.employee_level_value + '">';
        //                     $('.user_role').html(html);
        //                     console.log('User role set to:', response.employee_level_value);
        //                 } else {
        //                     console.log('Invalid response format:', response);
        //                     $('.user_role').empty();
        //                 }
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error('AJAX Error:', error);
        //                 console.log('Status:', status);
        //                 console.log('Response:', xhr.responseText);
        //                 $('.user_role').empty();
        //             }
        //         });
        //     });
        // });

        $(document).ready(function() {
            // Existing level change handler
            $('.employee_level, .emp_sub_level').on('change', function() {
                var levelId = $('.employee_level').val();
                var subLevelId = $('.emp_sub_level').val();

                // alert(levelId);
                // alert(subLevelId);

               
                
                $.ajax({
                    url: "<?php echo base_url(); ?>admin/AM_Controller/getSpectrumByLevel",
                    type: 'POST',
                    data: {
                        employee_level: levelId,
                        employee_sub_level: subLevelId
                    },
                    success: function(response) {
                        var data = JSON.parse(response);

                        var html = '<option value="" selected disabled>Select Spectrum</option>';
                        
                        if(data && data.length > 0) {
                            $.each(data, function(index, item) {
                                html += '<option value="' + item.spectrum_id + '" data-color="' + item.spectrum_color_code + '">' 
                                    + item.spectrum_color_name + '</option>';
                            });
                        }
                        
                        $('#spectrum_select').html(html);
                        $('#spectrum_color_preview').css('background-color', ''); // Reset color preview
                    }
                });
            });

            // Add spectrum color preview handler
            $('#spectrum_select').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var colorCode = selectedOption.data('color');
                if(colorCode) {
                    $('.holder img').css('border-color', '#'+colorCode);
                } else {
                    $('.holder img').css('border-color', '#eee'); // Reset to default border color
                }

            });
        });

        // Add Department Handler
          $('#saveDepartment').on('click', function() {
              var departmentName = $('#new_department_name').val();
              if(departmentName) {
                  $.ajax({
                      url: "<?php echo base_url(); ?>admin/AM_Controller/addDepartmentDynamic",
                      type: 'POST',
                      data: { department_name: departmentName },
                      success: function(response) {
                          var data = JSON.parse(response);
                          if(data.status === 'success') {
                              // Add new option to select
                              $('#department_id').append(new Option(departmentName, data.department_id));
                              // Close modal
                              $('#addDepartmentModal').modal('hide');
                              // Clear input
                              $('#new_department_name').val('');
                              // Show success message
                              toastr.success('Department added successfully');
                          } else {
                            toastr.error(response.message || 'Failed to add department');
                        }
                      },
                      error: function() {
                          alert('Error occurred while adding department');
                      }
                  });
              } else {
                  alert('Please enter department name');
              }
          });

          // Add Designation Handler
          // Add Designation Handler
            $('#saveDesignation').on('click', function() {
                var designationName = $('#new_designation_name').val();
                var departmentId = $('#designation_department_id').val();  // Changed from d_department_id
                

                console.log(designationName, departmentId);

                if(!designationName || !departmentId) {
                    alert('Please enter designation name and select department');
                    return;
                }
                
                $.ajax({
                    url: "<?php echo base_url(); ?>admin/AM_Controller/addDesignationDynamic",
                    type: 'POST',
                    data: { 
                        designation_name: designationName,
                        department_id: departmentId
                    },
                    success: function(response) {

                    console.log(response);

                        var data = JSON.parse(response);
                        if(data.status === 'success') {
                            if($('#department_id').val() === departmentId) {
                                $('#designation_id').append(new Option(designationName, data.designation_id));
                            }
                            $('#addDesignationModal').modal('hide');
                            $('#new_designation_name').val('');
                            $('#designation_department_id').val('');
                            toastr.success('Designation added successfully!');
                        } else {
                            toastr.error(data.message || 'Failed to add department');
                        }
                    },
                    error: function() {
                        toastr.error('Error occurred while adding designation');
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
              url: '<?php echo base_url("admin/AM_Controller/getSectionsBySpectrum/"); ?>' + spectrumId,
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

  $(document).ready(function() {
    // Load departments initially
    loadDepartments();

    // Handle department selection change
    $('#department_id').on('change', function() {
        loadDesignations($(this).val());
    });

    // Handle department addition
    $('#saveDepartment').on('click', function() {
        const departmentName = $('#new_department_name').val().trim();
        
        if (!departmentName) {
            alert('Please enter department name');
            return;
        }

        $.ajax({
            url: baseUrl + 'admin/AM_Controller/addDepartment',
            type: 'POST',
            data: { department_name: departmentName },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Refresh both department dropdowns
                    loadDepartments();
                    $('#addDepartmentModal').modal('hide');
                    $('#new_department_name').val('');
                    
                    // Show success message
                    toastr.success('Department added successfully');
                } else {
                    toastr.error(response.message || 'Failed to add department');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('Error adding department');
                console.error(error);
            }
        });
    });
});

// function loadDepartments() {
//     $.ajax({
//         url: baseUrl + 'admin/AM_Controller/getDepartments',
//         type: 'GET',
//         dataType: 'json',
//         success: function(departments) {
//             let html = '<option value="">Select Department</option>';
//             departments.forEach(function(dept) {
//                 html += `<option value="${dept.department_id}">${dept.department_name}</option>`;
//             });
            
//             // Update both department dropdowns
//             $('#department_id, #designation_department_id').html(html);
            
//             // Reinitialize select2
//             $('#department_id, #designation_department_id').select2({
//                 width: '100%'
//             });
//         },
//         error: function(xhr, status, error) {
//             console.error('Error loading departments:', error);
//         }
//     });
// }
// Add this inside your existing $(document).ready function
$(document).ready(function() {
    $('#refreshDepartments').on('click', function(e) {
        e.preventDefault();
        const button = $(this);
        const icon = button.find('i');
        const select = $('#designation_department_id');
        
        // Add spinning animation
        icon.addClass('bx-spin');
        button.prop('disabled', true);
        
        $.ajax({
            url: "<?php echo base_url('admin/AM_Controller/getDepartments'); ?>",
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success' && response.data) {
                    let html = '<option value="">Select Department</option>';
                    response.data.forEach(function(dept) {
                        html += `<option value="${dept.department_id}">${dept.department_name}</option>`;
                    });
                    select.html(html);
                    
                    // Reinitialize select2
                    if ($.fn.select2) {
                        select.select2({ width: '100%' });
                    }
                    
                    toastr.success('Departments refreshed successfully');
                } else {
                    toastr.error(response.message || 'Failed to refresh departments');
                }
            },
            error: function(xhr, status, error) {
                console.error('Ajax Error:', error);
                console.log('Response:', xhr.responseText);
                toastr.error('Failed to refresh departments. Please try again.');
            },
            complete: function() {
                // Remove spinning animation
                icon.removeClass('bx-spin');
                button.prop('disabled', false);
            }
        });
    });
});
$(document).ready(function() {
    // Handle department selection change
    $('#department_id').on('change', function() {
        const departmentId = $(this).val();
        loadDesignations(departmentId);
    });

    function loadDesignations(departmentId) {
        if (!departmentId) return;

        $.ajax({
            url: "<?php echo base_url('admin/AM_Controller/getDesignationsByDepartment'); ?>",
            type: 'POST',
            data: { department_id: departmentId },
            dataType: 'json',
            success: function(response) {
                let html = '<option value="">Select Designation</option>';
                if (response && response.length > 0) {
                    response.forEach(function(designation) {
                        html += `<option value="${designation.designation_id}">
                            ${designation.designation_name}
                        </option>`;
                    });
                }
                $('#designation_id').html(html).prop('disabled', false);
                
                // Reinitialize select2
                if ($.fn.select2) {
                    $('#designation_id').select2({
                        width: '100%'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading designations:', error);
                $('#designation_id').html('<option value="">Error loading designations</option>');
            }
        });
    }
});
</script>

</body>
</html>