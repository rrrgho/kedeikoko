function alertSuccess(message){
swal({
    title: "Good job!",
    text: message,
    icon: "success",
    button: "Aww yiss!",
  });
}
function alertFailed(message){
swal({
    title: "Upps, sorry !",
    text: message,
    icon: "warning",
    button: "Got it!",
  });
}

function alertConfirm(message, redirect){
swal({
    title: "Are you sure?",
    text: message,
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
      if(willDelete)
        document.location.href = redirect
  });
}
