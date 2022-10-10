// menu selection-----------------------
let currentUrl = new URL(window.location);
$('a[href="'+currentUrl+'"]').parent().addClass('active');
$('a[href="'+currentUrl+'"]').parent().parent().parent().addClass('show');
$('a[href="'+currentUrl+'"]').parent().parent().parent().parent().addClass('active expand');

// confirm link
$('.confirm-alert').confirm({
    title: '<span style="color: #ff0000;"><i class="fa fa-exclamation-triangle"></i> অনুমোদন করবেন কি না?</span>',
    content: '<span style="padding-left: 35px; color: blue">আপনি কি নিশ্চিত?</span>',
    buttons: {
        cancel: {
            text: 'না',
            btnClass: 'btn-danger',
            action: function(){}
        },
        confirm: {
            text: 'হ্যাঁ',
            btnClass: 'btn-success',
            action: function(){
                location.href = this.$target.attr('href');
            }
        },
    }
});

// confirm form
function ConfirmForm(formId){
    $.confirm({
        title: '<span style="color: #ff0000;"><i class="fa fa-exclamation-triangle"></i> অনুমোদন করবেন কি না?</span>',
        content: '<span style="padding-left: 35px; color: blue">আপনি কি নিশ্চিত যে, এই কাজ করবেন?</span>',
        buttons: {
            cancel: {
                text: 'না',
                btnClass: 'btn-danger',
                action: function(){}
            },
            confirm: {
                text: 'হ্যাঁ',
                btnClass: 'btn-success',
                action: function(){
                    $('#'+formId).submit();
                }
            },
        }
    });
    return false;
}


// confirm deactivate user
function ConfirmActiveDeactiveUser(formId,action){
    $.confirm({
        title: '<span style="color: #ff0000;"><i class="fa fa-exclamation-triangle"></i> অনুমোদন করবেন কি না?</span>',
        content: '<span style="padding-left: 35px; color: blue">আপনি কি নিশ্চিত যে, এই কাজ করবেন?</span>',
        buttons: {
            cancel: {
                text: 'না',
                btnClass: 'btn-danger',
                action: function(){}
            },
            confirm: {
                text: 'হ্যাঁ',
                btnClass: 'btn-success',
                action: function(){
                    $('#'+formId).submit();
                }
            },
        }
    });
    return false;
}

$('.select2').select2();



//Print This....
function Print($selector){
    $('#'+$selector).printThis();
}

$(".datePicker").datepicker({
    changeMonth: true,
    changeYear: true,
    showOtherMonths: true,
    selectOtherMonths: true,
    showAnim: "slideDown",
    dateFormat: "dd/mm/yy"
});
