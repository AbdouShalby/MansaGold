function callToaster(positionClass, errorMessage, successMessage) {
    if (document.getElementById("toaster")) {
        toastr.options = {
            closeButton: true,
            debug: false,
            newestOnTop: false,
            progressBar: true,
            positionClass: positionClass,
            preventDuplicates: false,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "5000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut"
        };
        if (errorMessage) {
            toastr.error(errorMessage);
        }
        if (successMessage) {
            toastr.success(successMessage);
        }
    }
}
