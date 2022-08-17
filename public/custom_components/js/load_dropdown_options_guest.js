/* function to load [Divisions] drop down options */
function loadDivDDOptions(ddID, selectedOption, parentDDID, incInactive, loadAll, postTo, selectFirstDiv, divHeadSpecific, parentContainer) {
    parentDDID = parentDDID || '';
    loadAll = loadAll || -1;
    incInactive = incInactive || -1;
    postTo = postTo || '/api/divisionsdropdownGuest';
    selectFirstDiv = selectFirstDiv || 0;
    divHeadSpecific = divHeadSpecific || 0;
    parentContainer = parentContainer || $(document);

    var parentDDVal = 0;
    if (parentDDID != '') parentDDVal = parentContainer.find('#' + parentDDID).val();
    //console.log('divHeadSpecific = ' + divHeadSpecific);
    var parentDDLabel = parentContainer.find('label[for="' + parentDDID + '"]').html();
    var ddLabel = parentContainer.find('label[for="' + ddID + '"]').html();
    //console.log('calls the function with: ' + ddID + ', ' + ddLabel + ', ' + postTo + ', ' + selectedOption + ', ' + parentDDVal + ', ' + parentDDLabel + ', ' + incInactive + ', ' + loadAll + ', ');
    var divLvl = parseInt(ddID.substr(ddID.lastIndexOf("_") + 1));
    //console.log('division level: ' + divLvl);
    $.post(postTo, { div_level: divLvl, parent_id: parentDDVal, div_head_specific: divHeadSpecific, _token: $('input[name=_token]').val(), load_all: loadAll, inc_inactive: incInactive },
        function(data) {
            var dropdown = parentContainer.find('#'+ddID);
            var firstDDOption = "*** Select a " + ddLabel + " ***";
            if (loadAll == 1) {
                //console.log('load all is: ' + loadAll);
                firstDDOption = "*** Select a " + ddLabel + " ***";
            }
            else if (loadAll == -1) {
                //console.log('load all is: ' + loadAll);
                if (parentDDVal > 0) firstDDOption = "*** Select a " + ddLabel + " ***";
                else firstDDOption = "*** Select a " + parentDDLabel + " First ***"; //if (parentDDVal == '')
            }
            dropdown.empty();
            dropdown
                .append($("<option></option>")
                    .attr("value",'')
                    .text(firstDDOption));
            $.each(data, function(key, value) {
                var ddOption = $("<option></option>")
                    .attr("value",value)
                    .text(key);
                if (selectedOption == value) ddOption.attr("selected", "selected");
                dropdown
                    .append(ddOption);
            });
            if (selectFirstDiv == 1) { //select the first division
                dropdown.val(parentContainer.find('#' + ddID + ' option:nth-child(2)').val());
                dropdown.trigger('change');
            }
        });
}

/* function to load child [Division] and employee (HR Person) drop down options */
function divDDOnChange(dropDownObj, hrPeopleDDID, parentContainer) {
    hrPeopleDDID = hrPeopleDDID || 'hr_person_id';
    parentContainer = $('#'+parentContainer) || $(document);

    var postTo = ''; var selectedOption = '';
    var ddID = dropDownObj.id;
    var parentDDVal = dropDownObj.value;
    var incInactive = -1; var loadAll = -1;
    var childDDID = ''; var childDDLabel = '';
    var hrPeopleDDLabel = $('label[for="' + hrPeopleDDID + '"]').html();
    //console.log("function called by dd changed event: " + "ddID = " + ddID + ", parentDDVal = " + parentDDVal + ", parentDDLabel = " + parentDDLabel);

    switch(ddID) {
        case 'division_level_5':
            childDDID = 'division_level_4';
            childDDLabel = $('label[for="' + childDDID + '"]').html();
            loadDivDDOptions(childDDID, selectedOption, ddID, incInactive, loadAll, postTo, null, null, parentContainer);
           break;
        case 'division_level_4':
            childDDID = 'division_level_3';
            childDDLabel = $('label[for="' + childDDID + '"]').html();
            loadDivDDOptions(childDDID, selectedOption, ddID, incInactive, loadAll, postTo, null, null, parentContainer);
            break;
        case 'division_level_3':
            childDDID = 'division_level_2';
            childDDLabel = $('label[for="' + childDDID + '"]').html();
            loadDivDDOptions(childDDID, selectedOption, ddID, incInactive, loadAll, postTo, null, null, parentContainer);
            break;
        case 'division_level_2':
            //console.log("level two div changed");
            childDDID = 'division_level_1';
            childDDLabel = $('label[for="' + childDDID + '"]').html();
            loadDivDDOptions(childDDID, selectedOption, ddID, incInactive, loadAll, postTo, null, null, parentContainer);
            break;
        case 'division_level_1':
            break;
        default:
            return null;
            break;
    }
}