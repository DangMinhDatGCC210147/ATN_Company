//Delete
function deleteProduct(id){
    Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
}).then((result) => {
if (result.isConfirmed) {
Swal.fire({
title: 'Deleted',
text: 'The item has been deleted.',
icon: 'success',
showConfirmButton: false
})
//   window.location.href = 'add_product.php?del_id=' + id;
setTimeout(() => {
  window.location.href = 'add_product.php?del_id=' + id;
}, 2000); 

} else if (result.isDenied) {
Swal.fire('Changes are not saved', '', 'info')
}
})
}

