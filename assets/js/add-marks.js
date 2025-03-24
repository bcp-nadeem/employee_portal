// Percentage Calculator

$(document).ready(function () {

    // For Employee
    function calculateSectionWeightedSum(sectionId) {
        var totalWeightedSum = 0;
        var totalWeightVal = 0;
        var countValidMarks = 0;
    
        $("#navs-justified-section-" + sectionId + " table tbody tr.remove_bb").each(function () {
            var markVal = parseFloat($(this).find("input.employee_marks_value").first().val());
            var weightVal = parseFloat($(this).find("input.employee_question_weight_data").first().val());
            
            // Skip calculation if mark is 0, undefined, or NaN
            if (!isNaN(markVal) && markVal > 0 && !isNaN(weightVal) && weightVal > 0) {
                // Calculate weighted value for this mark
                var weightedValue = (markVal * weightVal);
                totalWeightedSum += weightedValue;
                totalWeightVal += weightVal;
                countValidMarks++;
                
                // Debug logging for each calculation
                // console.log('Mark:', markVal, 'Weight:', weightVal, 'Weighted Value:', weightedValue);
            }
        });
    
        // Calculate final percentage
        var finalPercentage = 0;
        if (totalWeightVal > 0) {
            finalPercentage = ((totalWeightedSum / totalWeightVal)).toFixed(2);
        }
    
        // Update the display
        $(".section-" + sectionId + "-average").text(finalPercentage + "%");
    
        // Debug logging
        // console.log("Section " + sectionId + " Calculations:", {
        //     validEntries: countValidMarks,
        //     totalWeightedSum: totalWeightedSum,
        //     totalWeightValue: totalWeightVal,
        //     finalPercentage: finalPercentage
        // });
    }

    // On page load, calculate the weighted sum for each section.
    $(".tab-pane[id^='navs-justified-section-']").each(function () {
        var fullId = $(this).attr("id"); // e.g. "navs-justified-section-3"
        var parts = fullId.split("-");
        var sectionId = parts[parts.length - 1];
        calculateSectionWeightedSum(sectionId);
    });

    // Recalculate if any employee mark input is changed.
    $(document).on("change", "input.employee_marks_value", function () {
        var sectionId = $(this).closest(".tab-pane").attr("id").split("-").pop();
        calculateSectionWeightedSum(sectionId);
    });

    // For Supervisor

    // ... existing code ...

    // For Supervisor
    function calculateSupervisorSectionWeightedSum(sectionId) {
        var totalWeightedSum = 0;
        var totalWeightVal = 0;
        
        $("#navs-justified-section-" + sectionId + " table tbody tr.remove_bb").each(function () {
            var markVal = parseFloat($(this).find("input.supervisor_marks_value").first().val()) || 0;
            var weightVal = parseFloat($(this).find("input.supervisor_question_weight_data").first().val());
            weightVal = isNaN(weightVal) ? 0 : weightVal;
            
            totalWeightedSum += (markVal * weightVal);
            totalWeightVal += weightVal;
        });
        
        var average = totalWeightVal > 0 ? (totalWeightedSum / totalWeightVal).toFixed(2) : "0.00";
        $(".section-" + sectionId + "-supervisor-average").text(average + "%");
        
        // console.log("Supervisor Section " + sectionId, {
        //     totalWeightedSum: totalWeightedSum,
        //     totalWeightVal: totalWeightVal,
        //     average: average
        // });
    }

    // Calculate both employee and supervisor metrics on page load
    $(".tab-pane[id^='navs-justified-section-']").each(function () {
        var fullId = $(this).attr("id");
        var sectionId = fullId.split("-").pop();
        calculateSectionWeightedSum(sectionId);
        calculateSupervisorSectionWeightedSum(sectionId);
    });

    // Recalculate if any supervisor mark input is changed
    $(document).on("change", "input.supervisor_marks_value", function () {
        var sectionId = $(this).closest(".tab-pane").attr("id").split("-").pop();
        calculateSupervisorSectionWeightedSum(sectionId);
    });

// ... rest of existing code ...


    // ... existing supervisor calculation code ...

    function calculateManagerMerits(sectionId) {
        var totalMarks = 0;
        
        $("#navs-justified-section-" + sectionId + " table tbody tr.remove_bb").each(function () {
            var markVal = parseFloat($(this).find("input.supervisor_marks_value").first().val()) || 0;
            if (markVal === 100) {
                totalMarks++;
            }
        });
        
        // Update the Manager Merits cell for this section
        $(".manager-merits-section-" + sectionId).text(totalMarks);
        
        // console.log("Manager Merits Section " + sectionId, {
        //     totalMarks: totalMarks
        // });
        
        return totalMarks;
    }

    // Calculate Manager Merits on page load and when supervisor marks change
    function updateAllManagerMerits() {
        var totalMerits = 0;
        $(".tab-pane[id^='navs-justified-section-']").each(function () {
            var sectionId = $(this).attr("id").split("-").pop();
            totalMerits += calculateManagerMerits(sectionId);
        });
        
        // Update total merits if needed
        $("#total-manager-merits").text(totalMerits);
    }

    // Add to existing page load calculations
    $(".tab-pane[id^='navs-justified-section-']").each(function () {
        var fullId = $(this).attr("id");
        var sectionId = fullId.split("-").pop();
        calculateSectionWeightedSum(sectionId);
        calculateSupervisorSectionWeightedSum(sectionId);
        calculateManagerMerits(sectionId);
    });

    // Add to existing supervisor mark change handler
    $(document).on("change", "input.supervisor_marks_value", function () {
        var sectionId = $(this).closest(".tab-pane").attr("id").split("-").pop();
        calculateSupervisorSectionWeightedSum(sectionId);
        calculateManagerMerits(sectionId);
        updateAllManagerMerits();
    });



});


$(document).ready(function() {

    // console.log('Script loaded'); // Debug log

    $("#addField").click(function() {
        var newField = `
            <div class="row mb-3 field-row">
                <div class="col-md-5">
                    <label class="form-label">Mark Name <span class="text-danger">*</span></label>
                    <input type="text" name="mark_name[]" class="form-control" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Mark Value <span class="text-danger">*</span></label>
                    <input type="number" name="mark_value[]" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-field mt-4">Remove</button>
                </div>
            </div>
        `;
        $("#dynamicFieldsContainer").append(newField);
    });

    $(document).on('click', '.remove-field', function() {
        $(this).closest('.field-row').remove();
    });


});

    // employee marks form validation

    

// supervisore marks form validation


$(document).ready(function() {
    // Calculate section average
    function calculateSectionAverage(sectionId) {
        let total = 0;
        let count = 0;
        
        // Get all employee scores for this section
        $(`select[name="supervisor_score[]"][data-section="${sectionId}"]`).each(function() {
            let value = parseFloat($(this).val());
            if (!isNaN(value)) {
                total += value;
                count++;
            }
        });

        // Calculate and display average
        let average = count > 0 ? (total / count).toFixed(1) : "0.0";
        $(`.section-${sectionId}-average-supervisor`).text(average);
    }

    // Update PHP template
    $('.supervisor_score').on('change', function() {
        let sectionId = $(this).data('section');
        calculateSectionAverage(sectionId);
    });
});
