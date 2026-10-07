//var baseUrl = "<?php echo base_url(); ?>";
//var baseUrl = window.location.origin + '/admin/'; //goble variable for getting base url
var baseUrl = window.location.origin + '/admin/';

 // Script for delete category
  $(document).on('click', '.deleteCategory', function(e) {
    e.preventDefault(); // Prevent default link behavior
    var statusButton = $(this);
    var id = statusButton.data('id');
    var decodeId = atob(id);
    var tableName = statusButton.data('table');
    var decodeTable = atob(tableName);
    var deletecategory = statusButton.data('deletecategory');
    //console.log(decodeId);debugger;
    var status = '1';
    
    //var msg = (status === '1') ? 'Activate' : 'Deactivate';
    Swal.fire({
      icon: 'question',
      text: "Are you sure you want to  Delete ?",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes'
    }).then((result) => {
      if (result.isConfirmed) {
        // User clicked Yes, proceed with the AJAX call
        $.ajax({
          type: "POST",
          url: 'Updatestatus',
          data: {"id": decodeId, "status": status, "tableName": decodeTable, "deletecategory":deletecategory},
          success: function(data) {

            // Show Toastr-style success notification
            var toastrMsg = 'Data Delete Successfully';
            Swal.fire({
              icon: 'success',
              title: toastrMsg,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ok'
        
            }).then((result) => { 
                if (result.isConfirmed) {
                    location.reload();
                }
            });
            

        }
        });
      }
    });
  });
//End Script for Delete Category
 // Script for changing status (Active/Inactive) without page reload
 $(document).on('click', '.status_checks', function(e) {
  e.preventDefault(); // Prevent default link behavior
  var statusButton = $(this);
  var id = statusButton.data('id');
  var tableName = statusButton.data('table');
  var currentStatus = statusButton.text().trim();
  var status = (currentStatus === 'Active') ? '0' : '1';
  
  var msg = (status === '1') ? 'Activate' : 'Deactivate';
  Swal.fire({
    icon: 'question',
    text: "Are you sure you want to " + msg + "?",
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then((result) => {
    if (result.isConfirmed) {
      // User clicked Yes, proceed with the AJAX call
      $.ajax({
        type: "POST",
        url: 'Updatestatus',
        data: {"id": id, "status": status, "tableName": tableName},
        success: function(data) {
          // Update button appearance and status text
          if (status === '0') {
            statusButton.removeClass('btn-success').addClass('btn-danger').text('Inactive');
          } else {
            statusButton.removeClass('btn-danger').addClass('btn-success').text('Active');
          }

          // Show Toastr-style success notification
          var toastrMsg =  msg + ' Successfully';
          Swal.fire({
            icon: 'success',
            title: toastrMsg
          });

      }
      });
    }
  });
});
//End Script for changing status (Active/Inactive) without page reload
//Script For Data Table
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
//End Script for Data Table

// Script for get sub Category
  $(document).ready(function(){
        //var baseUrl = window.location.origin + '/admin/';

        // Initial AJAX request
        var category_id = $('#category_name').val();
        var sub_cat_id = $('#sub_cat_id').val(); // get current subcategory id

        var decodeId = atob(sub_cat_id); //decode sub category id
        //alert(decodeId);
        fetchSubcategories(category_id);
    
        // Function to fetch subcategories
        function fetchSubcategories(category_id) {
            $.ajax({
                url: baseUrl + 'getSubcategories',
                type: 'post',
                data: {id: category_id},
                dataType: 'json',
                success: function(response) {
                    var len = response.length;
                    $("#subCat_name").empty();

                    $("#subCat_name").append("<option value=''> --- Please Select Sub Category--- </option>");
                    for(var i = 0; i < len; i++) {
                        var id = response[i]['sub_cat_id'];
                        var name = response[i]['name'];
                        var selected = (id == decodeId) ? "selected" : ""; // Check if current option is selected
                        $("#subCat_name").append("<option value='"+id+"' "+selected+">"+name+"</option>");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX request failed:", textStatus, errorThrown);
                }
            });
        }
        // When category changes, fetch related subcategories
        $('#category_name').change(function(){
            var category_id = $(this).val();
            fetchSubcategories(category_id);
        });
        
   });
// End script for get sub Category

//Script for Update Child category
$(document).ready(function() {
  $('#UpdateChild').click(function(e) {
      e.preventDefault();

      var formData = new FormData();
      var decodedEditId = atob($('#Edit_id').val()); // Decode Edit_id value using atob
      formData.append('Edit_id', decodedEditId);
      formData.append('category_name', $('#category_name').val());
      formData.append('subCat_name', $('#subCat_name').val());
      formData.append('name', $('#name').val());
      formData.append('cat_description', $('#cat_description').val());
      formData.append('cat_image', $('#cat_image')[0].files[0]);

      $.ajax({
          type: 'POST',
          url: baseUrl + 'UpdateChildCat',
          data: formData,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
              var toastrMsg = 'Data updated successfully!';
              setTimeout(function() {
                  window.location.href = baseUrl + 'ViewChildCategory';
              }, 4000);
              setTimeout(function() {
                  Swal.fire({
                      icon: 'success',
                      title: toastrMsg,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Ok'
                  });
              }, 1000);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
          }
      });
  });
});
//End Update Child Category

//Script for Update Sub Category
$(document).ready(function() {
  $('#UpdateSub').click(function(e) {
      e.preventDefault();

      var formData = new FormData();
      var decodedEditId = atob($('#sub_cat_id').val()); // Decode id value using atob
      formData.append('Edit_id', decodedEditId);
      formData.append('category_name', $('#category_name').val());
      formData.append('name', $('#name').val());
      formData.append('cat_description', $('#cat_description').val());
      formData.append('cat_image', $('#cat_image')[0].files[0]);

      $.ajax({
          type: 'POST',
          url: baseUrl + 'UpdateSubCat',
          data: formData,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
              var toastrMsg = 'Data updated successfully!';
              setTimeout(function() {
                  window.location.href = baseUrl + 'ViewSubCategory';
              }, 4000);
              setTimeout(function() {
                  Swal.fire({
                      icon: 'success',
                      title: toastrMsg,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Ok'
                  });
              }, 1000);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
          }
      });
  });
});
//End Update Sub Category
// Script for Update Package
$(document).ready(function() {
  $('#UpdatePackage').click(function(e) {
      e.preventDefault();

      var formData = new FormData();
      var decodedEditId = atob($('#Edit_id').val()); // Decode id value using atob
      formData.append('Edit_id', decodedEditId);
      formData.append('package_name', $('#package_name').val());
      formData.append('package_period', $('#package_period').val());
      formData.append('package_amount', $('#package_amount').val());

      $.ajax({
          type: 'POST',
          url: baseUrl + 'UpdatePackage',
          data: formData,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
              var toastrMsg = 'Data updated successfully!';
              setTimeout(function() {
                  window.location.href = baseUrl + 'ViewPackage';
              }, 4000);
              setTimeout(function() {
                  Swal.fire({
                      icon: 'success',
                      title: toastrMsg,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Ok'
                  });
              }, 1000);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
          }
      });
  });
});
//End Update Package

// Script for Update Shift
$(document).ready(function() {
  $('#UpdateShift').click(function(e) {
      e.preventDefault();

      var formData = new FormData();
      var decodedEditId = atob($('#Edit_id').val()); // Decode id value using atob
      formData.append('Edit_id', decodedEditId);
      formData.append('shift_name', $('#shift_name').val());
      formData.append('shift_time_start', $('#shift_time_start').val());
      formData.append('shift_time_end', $('#shift_time_end').val());

      $.ajax({
          type: 'POST',
          url: baseUrl + 'UpdateShift',
          data: formData,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
              var toastrMsg = 'Data updated successfully!';
              setTimeout(function() {
                  window.location.href = baseUrl + 'ViewShift';
              }, 4000);
              setTimeout(function() {
                  Swal.fire({
                      icon: 'success',
                      title: toastrMsg,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Ok'
                  });
              }, 1000);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
          }
      });
  });
});
//End Update Shift

// Get Shift Time According to Shift
$(document).ready(function() {
  function populateShiftTime(shiftName, selectedTime) {
    //console.log("Selected Time:- "+selectedTime);
    var get_shift_time = $('#get_shift_time').val();
      $.ajax({
          url: baseUrl + 'GetShiftTime',
          type: 'POST',
          data: {shift_name: shiftName},
          dataType: 'json',
          success: function(response) {
              $('#shift_time').empty();
              $('#shift_time').append('<option>Please Select Shift Time</option>');
              $.each(response, function(index, value) {
                  if(value == get_shift_time) {
                      $('#shift_time').append('<option value="'+value+'" selected>'+value+'</option>');
                  } else {
                      $('#shift_time').append('<option value="'+value+'">'+value+'</option>');
                  }
              });
          }
      });
  }

  // When the page loads, check if shift_name is already selected and populate shift_time
  var initialShift = $('#shift_name').val();
  var initialShiftTime = "<?= isset($getCustomerData) ? $getCustomerData->shift_time : ''; ?>";
  if (initialShift) {
      populateShiftTime(initialShift, initialShiftTime);
  }

  // On shift_name change, update shift_time
  $('#shift_name').change(function() {
      var shiftName = $(this).val();
      populateShiftTime(shiftName, null);
  });
});

// customer paid option js
document.addEventListener('DOMContentLoaded', function() {
  var checkbox = document.getElementById('checkboxSuccess1');
  var paidOptionContainer = document.getElementById('paid_option_container');
  
  // Set initial state based on whether the checkbox is checked
  paidOptionContainer.style.display = checkbox.checked ? 'block' : 'none';
  
  checkbox.addEventListener('change', function() {
      paidOptionContainer.style.display = this.checked ? 'block' : 'none';
  });
});


// Script for Update Customer
$(document).ready(function() {
  $('#UpdateCustomer').click(function(e) {
      e.preventDefault();

      var formData = new FormData();
      var decodedEditId = atob($('#Edit_id').val()); // Decode id value using atob
      formData.append('Edit_id', decodedEditId);
      formData.append('joining_date', $('#joining_date').val());
      formData.append('first_name', $('#first_name').val());
      formData.append('last_name', $('#last_name').val());
      formData.append('dob', $('#dob').val());
      formData.append('gender', $('#gender').val());
      formData.append('weight', $('#weight').val());
      formData.append('address', $('#address').val());
      formData.append('city', $('#city').val());
      formData.append('mobile', $('#mobile').val());
      formData.append('photo', $('#photo')[0].files[0]);
      formData.append('shift_name', $('#shift_name').val());
      formData.append('shift_time', $('#shift_time').val());
      formData.append('package', $('#package').val());
      formData.append('checkboxSuccess1', $('#checkboxSuccess1').val());
      formData.append('paid_option', $('#paid_option').val());

      $.ajax({
          type: 'POST',
          url: baseUrl + 'UpdateCustomer',
          data: formData,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
              var toastrMsg = 'Data updated successfully!';
              setTimeout(function() {
                  window.location.href = baseUrl + 'ViewCustomer';
              }, 4000);
              setTimeout(function() {
                  Swal.fire({
                      icon: 'success',
                      title: toastrMsg,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Ok'
                  });
              }, 1000);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
          }
      });
  });
});
//End Update Customer

// Script for Update Profile
$(document).ready(function() {
  $('#UpdateProfile').click(function(e) {
      e.preventDefault();

      var formData = new FormData();
      var decodedEditId = atob($('#Edit_id').val()); // Decode id value using atob
      formData.append('Edit_id', decodedEditId);
      formData.append('user_name', $('#user_name').val());
      
      var password = $('#password').val();
      if (password) {
          formData.append('password', password);
      }
      
      formData.append('display_name', $('#display_name').val());
      
      var file = $('#fileInput')[0].files[0];
      if (file) {
          formData.append('user_image', file);
      }
      console.log('FormData:', formData);

      $.ajax({
          type: 'POST',
          url: baseUrl + 'UpdateProfile',
          data: formData,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
              var toastrMsg = 'Profile updated successfully!';
              setTimeout(function() {
                  window.location.href = baseUrl + 'ViewProfile';
              }, 4000);
              setTimeout(function() {
                  Swal.fire({
                      icon: 'success',
                      title: toastrMsg,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Ok'
                  });
              }, 1000);
          },
          error: function(xhr, status, error) {
              console.error(xhr.responseText);
          }
      });
  });
});

//End Update Profile
// Insert Customers Payment
$(document).ready(function() {
    $('#paymentInsert').click(function(e) {
        //alert("Hii");exit;
        e.preventDefault();
  
        var formData = new FormData();
        
        formData.append('joining_date', $('#joining_date').val());
        formData.append('next_due_date', $('#next_due_date').val());
        formData.append('user_id', $('#user_id').val());
        formData.append('first_name', $('#first_name').val());
        formData.append('last_name', $('#last_name').val());
        formData.append('mobile', $('#mobile').val());
        formData.append('package', $('#package').val());
        formData.append('paid_option', $('#paid_option').val());
        formData.append('accept_payment_date', $('#accept_payment_date').val());
        //console.log("THis is BASEURL 04-09-2024 :- "+baseUrl);
        $.ajax({
            type: 'POST',
            url: baseUrl + 'InsertPayment',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                var toastrMsg = 'Payment Accept successfully!';
                setTimeout(function() {
                    window.location.href = baseUrl + 'ViewPayment';
                }, 4000);
                setTimeout(function() {
                    Swal.fire({
                        icon: 'success',
                        title: toastrMsg,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ok'
                    });
                }, 1000);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
  });
// Insert Customers Payment
// Get all payment details of single customer
// $(document).ready(function() {
//     $('[data-toggle="modal"]').on('click', function() {
//         // Get the modal ID and user ID from the button's data attributes
//         var modalId = $(this).data('target');
//         var userId = $(this).data('user-id');
//         var id = $(this).data('id');

//         // Make an AJAX request to fetch the payment details
//         $.ajax({
//             url: baseUrl + 'GetSingleCustomerDetails',
//             type: 'GET',
//             data: { user_id: userId ,id: id },
//             success: function(response) {
//                 // Populate the modal with the fetched data
//                 $('#payment-details-container-' + id).html(response);
//             },
//             error: function(xhr, status, error) {
//                 console.error('Error fetching payment details:', error);
//             }
//         });
//     });
// });

// Get all payment details of single customer
//Initialize Select2 Elements
$('.select2').select2()

//Initialize Select2 Elements
$('.select2bs4').select2({
  theme: 'bootstrap4'
})

$('#summernote').summernote()

// Scrript for Select all customer for message sending
$(document).ready(function() {
    $('#customerList').on('change', function() {
        let selectedValues = $(this).val();
        if (selectedValues.includes('selectAll')) {
            // Select all options except "Select All"
            $('#customerList option').each(function() {
                if ($(this).val() !== 'selectAll') {
                    $(this).prop('selected', true);
                } else {
                    $(this).prop('selected', false);
                }
            });
            $('#customerList').trigger('change'); // Trigger change event to update the UI
        } else {
            // Deselect "Select All" if it's not selected
            $('#customerList option[value="selectAll"]').prop('selected', false);
        }
    });
});

// Script for changing status (Paid/Unpaid) without page reload
$(document).on('click', '.status_check_paidUnpaid', function(e) {
    alert("hi");
    e.preventDefault(); // Prevent default link behavior
    var statusButton = $(this);
    var id = statusButton.data('id');
    var tableName = statusButton.data('table');
    var currentStatus = statusButton.text().trim();
    var status = (currentStatus === 'Paid') ? '0' : '1';
    
    var msg = (status === '1') ? 'Paid' : 'UnPaid';
    Swal.fire({
      icon: 'question',
      text: "Are you sure you want to " + msg + "?",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes'
    }).then((result) => {
      if (result.isConfirmed) {
        // User clicked Yes, proceed with the AJAX call
        $.ajax({
          type: "POST",
          url: 'UpdatePaidUnpaid',
          data: {"id": id, "status": status, "tableName": tableName},
          success: function(data) {
            // Update button appearance and status text
            if (status === '0') {
              statusButton.removeClass('btn-success').addClass('btn-danger').text('Unpaid');
            } else {
              statusButton.removeClass('btn-danger').addClass('btn-success').text('Paid');
            }
  
            // Show Toastr-style success notification
            var toastrMsg = 'Data ' + msg + ' Successfully';
            Swal.fire({
              icon: 'success',
              title: toastrMsg
            });
  
        }
        });
      }
    });
  });
  //End Script for changing status (Paid/Unpaid) without page reload

  // Script for Update Category
$(document).ready(function () {
    $('#UpdateCategory').click(function (e) {
      e.preventDefault();
  
      var formData = new FormData();
      var decodedEditId = atob($('#Edit_id').val()); // Decode id value using atob
      formData.append('Edit_id', decodedEditId);
      //formData.append('language_name', $('#language_name').val());
      formData.append('category_name', $('#category_name').val());
      formData.append('cat_description', $('#cat_description').val());
      formData.append('cat_image', $('#cat_image')[0].files[0]);
  
      $.ajax({
        type: 'POST',
        url: baseUrl + 'Updatecategory',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (response) {
          var toastrMsg = 'Data updated successfully!';
          setTimeout(function () {
            window.location.href = baseUrl + 'ViewCategory';
          }, 4000);
          setTimeout(function () {
            Swal.fire({
              icon: 'success',
              title: toastrMsg,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ok'
            });
          }, 1000);
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    });
  });
  //End Update Category
  
   /*Script for add and edit get sub cateogry old and new */
  /*$(document).ready(function () {
    function loadSubcategories(categoryId, callback) {
        //alert(baseUrl);
        if (categoryId !== '') {
            $.ajax({
                url: baseUrl + 'GetSubcategory',
                type: "POST",
                data: { category_id: categoryId },
                dataType: "json",
                success: function (response) {
                    console.log("Subcategory Response:", response);
                    let options = '<option value="">-- Please Select Sub Category --</option>';
                    $.each(response.data, function (index, subCategory) {
                        options += '<option value="' + subCategory.id + '">' + subCategory.name + '</option>';
                    });
                    $('#sub_category_name').html(options);
                    if (typeof callback === 'function') callback();
                }
            });
        } else {
            $('#sub_category_name').html('<option value="">-- Please Select Sub Category --</option>');
            $('#sub_subCategory').html('<option value="">-- Please Select Sub Sub Category --</option>');
        }
    }

    function loadSubSubcategories(categoryId, subCategoryId, callback) {
        if (categoryId !== '' && subCategoryId !== '') {
            $.ajax({
                url: baseUrl + 'GetsubSubcategory',
                type: "POST",
                data: {
                    category_id: categoryId,
                    subcategory_id: subCategoryId
                },
                dataType: "json",
                success: function (response) {
                    let options = '<option value="">-- Please Select Sub Sub Category --</option>';
                    $.each(response, function (index, subSub) {
                        options += '<option value="' + subSub.id + '">' + subSub.name + '</option>';
                    });
                    $('#sub_subCategory').html(options);
                    if (typeof callback === 'function') callback();
                }
            });
        } else {
            $('#sub_subCategory').html('<option value="">-- Please Select Sub Sub Category --</option>');
        }
    }

    // When Category is changed (Add Mode or manually in Edit)
    $('#category_name').change(function () {
        const categoryId = $(this).val();
        loadSubcategories(categoryId, function () {
            $('#sub_category_name').val('');
            $('#sub_subCategory').html('<option value="">-- Please Select Sub Sub Category --</option>');
        });
    });

    // When Subcategory is changed
    $('#sub_category_name').change(function () {
        const categoryId = $('#category_name').val();
        const subCategoryId = $(this).val();
        loadSubSubcategories(categoryId, subCategoryId);
    });

    // ðŸ›  Handle auto-select if in Edit Mode
    if (typeof selectedCategory !== 'undefined' && selectedCategory !== '') {
        $('#category_name').val(selectedCategory);

        loadSubcategories(selectedCategory, function () {
            $('#sub_category_name').val(selectedSubCategory);

            if (selectedSubCategory !== '') {
                loadSubSubcategories(selectedCategory, selectedSubCategory, function () {
                    $('#sub_subCategory').val(selectedSubSubCategory);
                });
            }
        });
    }
});*/

        /*New script*/
        
        $(document).ready(function () {

    let categoryId = $('#category_name').val();
    let editSubCatId = $('#edit_sub_cat_id').val(); // hidden field

    // EDIT case → load on page load
    if (categoryId) {
        loadSubcategories(categoryId, editSubCatId);
    }

    // ADD / EDIT → when category changes
    $('#category_name').change(function () {
        let categoryId = $(this).val();
        loadSubcategories(categoryId, '');
    });

    function loadSubcategories(categoryId, selectedSubCatId = '') {

        if (categoryId !== '') {
            $.ajax({
                url: baseUrl + 'GetSubcategory',
                type: "POST",
                data: { category_id: categoryId },
                dataType: "json",
                success: function (response) {

                    let options = '<option value="">-- Please Select Sub Category --</option>';

                    if (response.data && response.data.length > 0) {
                        $.each(response.data, function (index, subCategory) {

                            // ✅ CORRECT FIELD + NO SYNTAX ERROR
                            let selected = (subCategory.id == selectedSubCatId) ? 'selected' : '';

                            options += `
                                <option value="${subCategory.id}" ${selected}>
                                    ${subCategory.name}
                                </option>
                            `;
                        });
                    }

                    $('#sub_category_name').html(options);
                },
                error: function (xhr, status, error) {
                    console.error('Subcategory AJAX Error:', error);
                }
            });
        } else {
            $('#sub_category_name').html('<option value="">-- Please Select Sub Category --</option>');
        }
    }

});

        
        /*//New Script*/



  //Get Subcategory according to category end
  
  /*//Script for add and edit get sub cateogry old and new */
  
  

 // Script for Update Gallery Category
 $(document).ready(function () {
    $('#UpdateGalleryCategory').click(function (e) {
      e.preventDefault();
  
      var formData = new FormData();
      var decodedEditId = atob($('#Edit_id').val()); // Decode id value using atob
      formData.append('Edit_id', decodedEditId);
      //formData.append('language_name', $('#language_name').val());
      formData.append('category_name', $('#category_name').val());
    //   formData.append('cat_description', $('#cat_description').val());
    //   formData.append('cat_image', $('#cat_image')[0].files[0]);
  
      $.ajax({
        type: 'POST',
        url: baseUrl + 'UpdateGallerycategory',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (response) {
          var toastrMsg = 'Data updated successfully!';
          setTimeout(function () {
            window.location.href = baseUrl + 'ViewGalleryCategory';
          }, 4000);
          setTimeout(function () {
            Swal.fire({
              icon: 'success',
              title: toastrMsg,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ok'
            });
          }, 1000);
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    });
  });
  //End Update Gallery Category  

  
 // Script for Update Catlog Category
 $(document).ready(function () {
  $('#UpdateCatlogCategory').click(function (e) {
    e.preventDefault();

    var formData = new FormData();
    var decodedEditId = atob($('#Edit_id').val()); // Decode id value using atob
    formData.append('Edit_id', decodedEditId);
    //formData.append('language_name', $('#language_name').val());
    formData.append('category_name', $('#category_name').val());
    formData.append('cat_description', $('#cat_description').val());
    formData.append('price', $('#price').val());
  //   formData.append('cat_image', $('#cat_image')[0].files[0]);

    $.ajax({
      type: 'POST',
      url: baseUrl + 'UpdateCatlogCategory',
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function (response) {
        var toastrMsg = 'Data updated successfully!';
        setTimeout(function () {
          window.location.href = baseUrl + 'ViewCatlogCategory';
        }, 4000);
        setTimeout(function () {
          Swal.fire({
            icon: 'success',
            title: toastrMsg,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok'
          });
        }, 1000);
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  });
});
//End Script for Update Catlog Category

//Update Order status 
$(document).on('change', '.order-status-dropdown', function () {
  var selectedStatus = $(this).val();
  var selectedStatusText = $(this).find("option:selected").text(); // Get selected status name
  var orderId = $(this).data('order-id');
  var table = $(this).data('table');

  if (selectedStatus !== "") {
    $.ajax({
      url: baseUrl + 'updateOrderStatus', 
      method: "POST",
      data: {
        order_id: orderId,
        status_id: selectedStatus,
        table: table
      },
      success: function (response) {
        if (response.success) {
          var toastrMsg = 'Order status updated to'+ selectedStatusText+ 'Successfully !' ;
                    setTimeout(function () {
                        Swal.fire({
                            icon: 'success',
                            title: toastrMsg,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ok'
                        });
                    }, 500);

        } else {
          alert("Failed to update order status.");
        }
      },
      error: function () {
        alert("Something went wrong!");
      }
    });
  }
});
//Update order status 
//Update Slider Images here
//Slider Update script
   $(document).ready(function() {
  $('#UpdateSlider').click(function(e) {
      e.preventDefault();

      var formData = new FormData();

      // Decode ID
      var encodedId = $('#Edit_id').val();
      var decodedEditId = atob(encodedId);
      formData.append('Edit_id', decodedEditId);

      // Normal text fields
      formData.append('slider_title', $('#slider_title').val());
      formData.append('slider_description', $('#slider_description').val());
      formData.append('web_link', $('#web_link').val());

      // -----------------------------
      // ⭐ ADD IMAGES (WEB + MOBILE)
      // -----------------------------

      // Web Slider Image
      var webImage = $('#slider_image')[0].files[0];
      if (webImage) { 
          formData.append('slider_image', webImage);
      }

      // Mobile Slider Image
      var mobileImage = $('#mobile_slider_image')[0].files[0];
      if (mobileImage) {
          formData.append('mobile_slider_image', mobileImage);
      }

      // AJAX REQUEST
      $.ajax({
          type: 'POST',
          url: baseUrl + 'UpdateSlider',
          data: formData,
          contentType: false,
          processData: false,
          dataType: 'json',

          success: function(response) {
              var toastrMsg = 'Data updated successfully!';

              setTimeout(function() {
                  window.location.href = baseUrl + 'ViewSlider';
              }, 4000);

              setTimeout(function() {
                  Swal.fire({
                      icon: 'success',
                      title: toastrMsg,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Ok'
                  });
              }, 1000);
          },

          error: function(xhr, status, error) {
              console.error(xhr.responseText);
          }
      });
  });
});


// Product Images delete
$(document).on('click', '.deleteProductImage', function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();

    let imageId = $(this).data('id');

    Swal.fire({
        icon: 'warning',
        title: 'Delete Image?',
        text: 'This image will be removed from the product.',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: baseUrl + 'deleteProductImage',
                type: "POST",
                dataType: "json",
                data: { image_id: imageId },
                success: function (res) {

                    if (res.status === 'success') {

                        $('#imgBox' + imageId).fadeOut(300, function () {
                            $(this).remove();
                        });

                        // Success toast
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Image deleted successfully',
                            timer: 1500,
                            showConfirmButton: false
                        });

                    } else {
                        Swal.fire('Error', res.message || 'Delete failed', 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Something went wrong!', 'error');
                }
            });
        }
    });
});

//Product image update
// Open file picker on edit click
$(document).on('click', '.editProductImage', function () {
    let imageId = $(this).data('id');
    $('.replaceImageInput[data-id="' + imageId + '"]').click();
});

// When new image selected
$(document).on('change', '.replaceImageInput', function () {

    let imageId = $(this).data('id');
    let file = this.files[0];

    if (!file) return;

    let formData = new FormData();
    formData.append('image_id', imageId);
    formData.append('new_image', file);

    Swal.fire({
        title: 'Updating Image...',
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: baseUrl + 'updateProductImage',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (res) {

            Swal.close();

            if (res.status === 'success') {

                // Update preview instantly
                $('#previewImg' + imageId).attr('src', res.new_image_url);

                Swal.fire({
                    icon: 'success',
                    title: 'Updated',
                    text: 'Image updated successfully',
                    timer: 1200,
                    showConfirmButton: false
                });

            } else {
                Swal.fire('Error', res.message, 'error');
            }
        },
        error: function () {
            Swal.close();
            Swal.fire('Error', 'Something went wrong', 'error');
        }
    });
});



//Colour Pick JS

// Convert HEX → RGB
function hexToRGB(hex) {
    console.log("hexToRGB() function called with:", hex);
    hex = hex.replace('#', '');

    // If short HEX (#fff → #ffffff)
    if (hex.length === 3) {
        hex = hex.split('').map(c => c + c).join('');
    }

    const r = parseInt(hex.substring(0, 2), 16);
    const g = parseInt(hex.substring(2, 4), 16);
    const b = parseInt(hex.substring(4, 6), 16);

    return `rgb(${r}, ${g}, ${b})`;
}

// When selecting color
document.getElementById('colour_picker').addEventListener('input', function() {
    let hex = this.value;
    let rgb = hexToRGB(hex);

    // Show both HEX + RGB in the input
    document.getElementById('colour_code').value = `${hex} | ${rgb}`;
    console.log("Final Output Written To Input:", `${hex} | ${rgb}`);
});

//Update Colour 
  $(document).ready(function() {
  $('#UpdateColour').click(function(e) {
      e.preventDefault();

      var formData = new FormData();

      // Decode ID
      var encodedId = $('#Edit_id').val();
      var decodedEditId = atob(encodedId);
      formData.append('Edit_id', decodedEditId);

      // Normal text fields
      formData.append('colour_name', $('#colour_name').val());
      formData.append('colour_code', $('#colour_code').val());
      

      // AJAX REQUEST
      $.ajax({
          type: 'POST',
          url: baseUrl + 'UpdateColour',
          data: formData,
          contentType: false,
          processData: false,
          dataType: 'json',

          success: function(response) {
              var toastrMsg = 'Data updated successfully!';

              setTimeout(function() {
                  window.location.href = baseUrl + 'ViewColours';
              }, 4000);

              setTimeout(function() {
                  Swal.fire({
                      icon: 'success',
                      title: toastrMsg,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Ok'
                  });
              }, 1000);
          },

          error: function(xhr, status, error) {
              console.error(xhr.responseText);
          }
      });
  });
});





